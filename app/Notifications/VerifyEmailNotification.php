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
        // Generar la URL firmada de la API
        $apiUrl = URL::temporarySignedRoute(
            'api.v1.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        // Obtener la URL del frontend
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        
        $parsedUrl = parse_url($apiUrl);
        parse_str($parsedUrl['query'] ?? '', $queryParams);
        
        // Construir la URL del frontend con todos los parámetros necesarios
        return $frontendUrl . '/verify-email/' . $notifiable->getKey() . '/' . sha1($notifiable->getEmailForVerification()) 
            . '?' . http_build_query([
                'expires' => $queryParams['expires'] ?? '',
                'signature' => $queryParams['signature'] ?? '',
            ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $expirationTime = Config::get('auth.verification.expire', 60);

        return (new MailMessage)
            ->subject('Verifica tu correo electrónico - Guerrero de Troya')
            ->view('emails.verify-email', [
                'verificationUrl' => $verificationUrl,
                'expirationTime' => $expirationTime,
            ]);
    }
}
