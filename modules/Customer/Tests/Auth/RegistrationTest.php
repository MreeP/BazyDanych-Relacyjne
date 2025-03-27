<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class RegistrationTest
 *
 * Tests for the registration of the customer.
 */
class RegistrationTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether registration screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Test whether new users can register.
     *
     * @return void
     */
    #[Test]
    public function new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('customer.dashboard', absolute: false));
    }
}
