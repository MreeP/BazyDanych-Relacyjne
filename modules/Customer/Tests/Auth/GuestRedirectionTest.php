<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class PasswordResetTest
 *
 * Tests for the password reset of the customer.
 */
class GuestRedirectionTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether reset password link screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function guest_is_redirected_to_the_login_when_visiting_customer_route(): void
    {
        $this->assertGuest();

        $response = $this->get('/dashboard');

        $response->assertRedirect(route('guest.auth.customer.login'));
    }
}
