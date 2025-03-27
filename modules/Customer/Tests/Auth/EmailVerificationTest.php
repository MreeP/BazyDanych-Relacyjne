<?php

namespace Modules\Customer\Tests\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Modules\Customer\Tests\CustomerTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Class EmailVerificationTest
 *
 * Tests for email verification.
 */
class EmailVerificationTest extends CustomerTestCase
{

    use RefreshDatabase;

    /**
     * Test whether email verification screen can be rendered.
     *
     * @return void
     */
    #[Test]
    public function email_verification_screen_can_be_rendered(): void
    {
        $customer = $this->createCustomer(false);

        $response = $this->actingAs($customer, 'customer')->get('/verify-email');

        $response->assertStatus(200);
    }

    /**
     * Test whether email can be verified.
     *
     * @return void
     */
    #[Test]
    public function email_can_be_verified(): void
    {
        $customer = $this->createCustomer(false);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'customer.auth.verification.verify',
            now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $customer->id,
                'hash' => sha1($customer->email),
            ],
        );

        $response = $this->actingAs($customer, 'customer')->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($customer->fresh()->hasVerifiedEmail());

        $response->assertRedirect(route('customer.dashboard', absolute: false) . '?verified=1');
    }

    /**
     * Test whether email is not verified with invalid hash.
     *
     * @return void
     */
    #[Test]
    public function email_is_not_verified_with_invalid_hash(): void
    {
        $customer = $this->createCustomer(false);

        $verificationUrl = URL::temporarySignedRoute(
            'customer.auth.verification.verify',
            now()->addMinutes(60),
            ['id' => $customer->id, 'hash' => sha1('wrong-email')],
        );

        $this->actingAs($customer, 'customer')->get($verificationUrl);

        $this->assertFalse($customer->fresh()->hasVerifiedEmail());
    }
}
