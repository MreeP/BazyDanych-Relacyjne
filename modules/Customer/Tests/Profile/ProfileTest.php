<?php

namespace Modules\Customer\Tests\Profile;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JsonException;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class ProfileTest
 *
 * Tests for the profile of the customer.
 */
class ProfileTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether the profile page can be rendered.
     *
     * @return void
     */
    #[Test]
    public function profile_page_is_displayed(): void
    {
        $customer = $this->createCustomer();

        $response = $this
            ->actingAs($customer)
            ->get('/profile');

        $response->assertOk();
    }

    /**
     * Test whether the profile information can be updated.
     *
     * @return void
     * @throws JsonException
     */
    #[Test]
    public function profile_information_can_be_updated(): void
    {
        $customer = $this->createCustomer();

        $response = $this
            ->actingAs($customer, 'customer')
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $customer->refresh();

        $this->assertSame('Test User', $customer->name);
        $this->assertSame('test@example.com', $customer->email);
        $this->assertNull($customer->email_verified_at);
    }

    /**
     * Test whether the email verification status is unchanged when the email address is unchanged.
     *
     * @return void
     * @throws JsonException
     */
    #[Test]
    public function email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->patch('/profile', [
            'name' => 'Test User',
            'email' => $customer->email,
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        $this->assertNotNull($customer->refresh()->email_verified_at);
    }

    /**
     * Test whether the email address can be updated.
     *
     * @return void
     * @throws JsonException
     */
    #[Test]
    public function user_can_delete_their_account(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($customer->fresh());
    }

    /**
     * Test whether the correct password must be provided to delete the account.
     *
     * @return void
     */
    #[Test]
    public function correct_password_must_be_provided_to_delete_account(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->from('/profile')->delete('/profile', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrorsIn('default', 'password')->assertRedirect('/profile');

        $this->assertNotNull($customer->fresh());
    }
}
