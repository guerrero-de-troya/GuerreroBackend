<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
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
