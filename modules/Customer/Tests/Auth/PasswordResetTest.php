<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Modules\Customer\Notifications\Auth\ResetPassword;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class PasswordResetTest
 *
 * Tests for the password reset of the customer.
 */
class PasswordResetTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether reset password link screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    /**
     * Test whether reset password link can be requested.
     *
     * @return void
     */
    #[Test]
    public function reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $customer = $this->createCustomer();

        $this->post('/forgot-password', ['email' => $customer->email]);

        Notification::assertSentTo($customer, ResetPassword::class);
    }

    /**
     * Test whether reset password screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $customer = $this->createCustomer();

        $this->post('/forgot-password', ['email' => $customer->email]);

        Notification::assertSentTo($customer, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/' . $notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    /**
     * Test whether password can be reset with valid token.
     *
     * @return void
     */
    #[Test]
    public function password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $customer = $this->createCustomer();

        $this->post('/forgot-password', ['email' => $customer->email]);

        Notification::assertSentTo($customer, ResetPassword::class, function ($notification) use ($customer) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $customer->email,
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ]);

            $response->assertSessionHasNoErrors()->assertRedirect(route('guest.auth.customer.login'));

            return true;
        });
    }
}
