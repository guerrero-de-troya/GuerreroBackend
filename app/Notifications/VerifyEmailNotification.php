<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    public function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'api.v1.verification.verify',
            Carbon::now()->addMinutes((int) Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $expirationTime = Config::get('auth.verification.expire', 5);

        return (new MailMessage)
            ->subject('Verifica tu correo electrónico - Guerrero de Troya')
            ->view('emails.verify-email', [
                'verificationUrl' => $verificationUrl,
                'expirationTime' => $expirationTime,
            ]);
    }
}
