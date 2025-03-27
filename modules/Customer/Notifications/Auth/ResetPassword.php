<?php

namespace Modules\Customer\Notifications\Auth;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Modules\Customer\Models\Customer;
use SensitiveParameter;

/**
 * Class ResetPassword
 *
 * Notification for resetting password
 */
class ResetPassword extends Notification
{

    /**
     * The password reset token.
     *
     * @var string
     */
    public string $token;

    /**
     * Create a notification instance.
     *
     * @param  string $token
     * @return void
     */
    public function __construct(#[SensitiveParameter] string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  Customer $notifiable
     * @return array
     */
    public function via(Customer $notifiable): array
    {
        return [
            'mail',
        ];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  Customer $notifiable
     * @return MailMessage
     */
    public function toMail(Customer $notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);
        return $this->buildMailMessage($url);
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string $url
     * @return MailMessage
     */
    protected function buildMailMessage(string $url): MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  Customer $notifiable
     * @return string
     */
    protected function resetUrl(Customer $notifiable): string
    {
        return URL::route('guest.auth.customer.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
    }
}
