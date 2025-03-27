<?php

namespace Modules\Admin\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use JsonException;
use Modules\Admin\Tests\AdminTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class PasswordUpdateTest
 *
 * Tests for updating the password of the admin.
 */
class PasswordUpdateTest extends AdminTestCase
{

    use RefreshDatabase;

    /**
     * Test whether password update screen can be rendered.
     *
     * @return void
     * @throws JsonException
     */
    #[Test]
    public function password_can_be_updated(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->from(URL::route('admin.profile.edit'))->put(URL::route('admin.auth.password.update'), [
            'current_password' => 'password',
            'password' => 'new-Password123!',
            'password_confirmation' => 'new-Password123!',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect(URL::route('admin.profile.edit'));

        $this->assertTrue(Hash::check('new-Password123!', $admin->refresh()->password));
    }

    /**
     * Test whether correct password must be provided to update password.
     *
     * @return void
     */
    #[Test]
    public function correct_password_must_be_provided_to_update_password(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->from(URL::route('admin.profile.edit'))->put(URL::route('admin.auth.password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrorsIn('default', 'current_password')->assertRedirect(URL::route('admin.profile.edit'));
    }
}
