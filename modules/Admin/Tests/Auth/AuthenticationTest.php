<?php

namespace Modules\Admin\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Modules\Admin\Tests\AdminTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class AuthenticationTest
 *
 * Tests for the authentication of the admin.
 */
class AuthenticationTest extends AdminTestCase
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
        $response = $this->get(URL::route('guest.auth.admin.login'));

        $response->assertStatus(200);
    }

    /**
     * Test whether admins can authenticate using the login screen.
     *
     * @return void
     */
    #[Test]
    public function admins_can_authenticate_using_the_login_screen(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(URL::route('guest.auth.admin.login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('admin');
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    /**
     * Test whether admins can not authenticate with invalid password.
     *
     * @return void
     */
    #[Test]
    public function admins_can_not_authenticate_with_invalid_password(): void
    {
        $admin = $this->createAdmin();

        $this->post(URL::route('guest.auth.admin.login'), [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('admin');
    }

    /**
     * Test whether admins can log out.
     *
     * @return void
     */
    #[Test]
    public function admins_can_log_out(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->post(URL::route('admin.auth.logout'));

        $this->assertGuest('admin');

        $response->assertRedirect(URL::route('guest.auth.admin.login'));
    }
}
