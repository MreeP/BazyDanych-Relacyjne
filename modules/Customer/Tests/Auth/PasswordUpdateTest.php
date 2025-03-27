<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class PasswordUpdateTest
 *
 * Tests for the password update of the customer.
 */
class PasswordUpdateTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether password update screen can be rendered.
     *
     * @return void
     * @throws \JsonException
     */
    #[Test]
    public function password_can_be_updated(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-Password123!',
                'password_confirmation' => 'new-Password123!',
            ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-Password123!', $customer->refresh()->password));
    }

    /**
     * Test whether correct password must be provided to update password.
     *
     * @return void
     */
    #[Test]
    public function correct_password_must_be_provided_to_update_password(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertSessionHasErrorsIn('default', 'current_password')
            ->assertRedirect('/profile');
    }
}
