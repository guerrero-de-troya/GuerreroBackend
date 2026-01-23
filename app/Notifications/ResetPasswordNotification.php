<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $token
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Restablecer Contraseña - Guerrero de Troya')
            ->view('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'token' => $this->token,
                'expirationTime' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60),
            ]);
    }

    protected function resetUrl($notifiable): string
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        
        return $frontendUrl . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);
    }
}
