<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class AuthenticationTest
 *
 * Tests for the authentication of the customer.
 */
class AuthenticationTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether login screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test whether customers can authenticate using the login screen.
     *
     * @return void
     */
    #[Test]
    public function customers_can_authenticate_using_the_login_screen(): void
    {
        $customer = $this->createCustomer();

        $response = $this->post('/login', [
            'email' => $customer->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('customer.dashboard', absolute: false));
    }

    /**
     * Test whether customers can not authenticate with invalid password.
     *
     * @return void
     */
    #[Test]
    public function customers_can_not_authenticate_with_invalid_password(): void
    {
        $customer = $this->createCustomer();

        $this->post('/login', [
            'email' => $customer->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Test whether customers can log out.
     *
     * @return void
     */
    #[Test]
    public function customers_can_log_out(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer, 'customer')->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
