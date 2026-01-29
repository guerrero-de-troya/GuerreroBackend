<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;

class ResetPasswordNotification extends ResetPassword
{
    protected function resetUrl($notifiable): string
    {
        $frontendUrl = rtrim(Config::get('app.frontend_url', Config::get('app.url')), '/');
        $email = urlencode($notifiable->getEmailForPasswordReset());

        return "{$frontendUrl}/recuperar-contrasena?token={$this->token}&email={$email}";
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
