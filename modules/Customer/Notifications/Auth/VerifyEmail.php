<?php

namespace Modules\Customer\Notifications\Auth;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Modules\Customer\Models\Customer;

/**
 * Class VerifyEmail
 *
 * Notification for verifying email address
 */
class VerifyEmail extends Notification
{

    /**
     * Get the notification's channels.
     *
     * @return array
     */
    public function via(): array
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
        $url = $this->verificationUrl($notifiable);
        return $this->buildMailMessage($url);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string $url
     * @return MailMessage
     */
    protected function buildMailMessage(string $url): MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $url)
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  Customer $notifiable
     * @return string
     */
    protected function verificationUrl(Customer $notifiable): string
    {
        return URL::temporarySignedRoute(
            'customer.auth.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
        );
    }
}
