<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class PasswordConfirmationTest
 *
 * Tests for password confirmation.
 */
class PasswordConfirmationTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether the confirm password screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function confirm_password_screen_can_be_rendered(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->get('/confirm-password');

        $response->assertStatus(200);
    }

    /**
     * Test whether password can be confirmed.
     *
     * @return void
     * @throws \JsonException
     */
    #[Test]
    public function password_can_be_confirmed(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test whether password is not confirmed with invalid password.
     *
     * @return void
     */
    #[Test]
    public function password_is_not_confirmed_with_invalid_password(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
