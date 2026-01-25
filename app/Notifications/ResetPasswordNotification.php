<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    protected function resetUrl($notifiable): string
    {
        $appUrl = Config::get('app.url');
        
        return "{$appUrl}/api/v1/auth/password/reset?token={$this->token}&email={$notifiable->getEmailForPasswordReset()}";
    }

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = $this->resetUrl($notifiable);
        $expirationTime = Config::get('auth.passwords.users.expire', 5);

        return (new MailMessage)
            ->subject('Restablece tu contraseña - Guerrero de Troya')
            ->view('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'expirationTime' => $expirationTime,
            ]);
    }
}
