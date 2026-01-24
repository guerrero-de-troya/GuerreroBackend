<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restablecer Contraseña - Guerrero de Troya</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
    <style type="text/css">
        /* Reset para clientes de email */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            outline: none;
            text-decoration: none;
        }
        
        /* Estilos principales */
        body {
            margin: 0;
            padding: 0;
            background-color: #0f172a;
            font-family: 'DM Sans', Arial, Helvetica, sans-serif;
            color: #f1f5f9;
            line-height: 1.6;
        }
        
        .email-wrapper {
            background-color: #0f172a;
            padding: 20px 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1e293b;
            border-radius: 16px;
            overflow: hidden;
        }
        
        .email-header {
            background-color: #dc2626;
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo-text {
            font-family: 'Clash Display', Arial, sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 15px 0;
            letter-spacing: -0.5px;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 16px;
            background-color: rgba(34, 197, 94, 0.2);
            border: 1px solid #22c55e;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #86efac;
        }
        
        .email-body {
            padding: 40px 30px;
            background-color: #1e293b;
        }
        
        .greeting {
            font-family: 'Clash Display', Arial, sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #f1f5f9;
            margin: 0 0 20px 0;
            letter-spacing: -0.5px;
        }
        
        .message {
            font-size: 16px;
            color: #e0e7ff;
            margin: 0 0 30px 0;
            line-height: 1.7;
        }
        
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .reset-button {
            display: inline-block;
            padding: 14px 32px;
            background-color: #22c55e;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .token-box {
            margin-top: 30px;
            padding: 20px;
            background-color: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
        }
        
        .token-label {
            font-size: 13px;
            font-weight: 600;
            color: #93c5fd;
            display: block;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .token-value {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #e0e7ff;
            word-break: break-all;
            background-color: rgba(15, 23, 42, 0.5);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .alternative-link {
            margin-top: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 13px;
            color: #94a3b8;
            word-break: break-all;
        }
        
        .alternative-link strong {
            color: #e0e7ff;
            display: block;
            margin-bottom: 8px;
        }
        
        .alternative-link a {
            color: #a855f7;
            word-break: break-all;
        }
        
        .expiration-text {
            margin-top: 30px;
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.7;
        }
        
        .warning-text {
            margin-top: 30px;
            padding: 16px;
            background-color: rgba(251, 191, 36, 0.1);
            border-left: 4px solid #fbbf24;
            border-radius: 8px;
            font-size: 13px;
            color: #fde68a;
            line-height: 1.7;
        }
        
        .email-footer {
            padding: 30px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background-color: #0f172a;
        }
        
        .footer-text {
            font-size: 13px;
            color: #94a3b8;
            margin: 0 0 8px 0;
        }
        
        .footer-link {
            color: #a855f7;
            text-decoration: none;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                border-radius: 0 !important;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 30px 20px !important;
            }
            
            .logo-text {
                font-size: 24px !important;
            }
            
            .greeting {
                font-size: 22px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td align="center" style="padding: 20px 0;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="max-width: 600px; width: 100%; background-color: #1e293b; border-radius: 16px; overflow: hidden;">
                        <!-- Header -->
                        <tr>
                            <td class="email-header" style="background-color: #dc2626; padding: 40px 30px; text-align: center;">
                                <h1 class="logo-text" style="font-family: 'Clash Display', Arial, sans-serif; font-size: 32px; font-weight: 700; color: #ffffff; margin: 0 0 15px 0; letter-spacing: -0.5px;">Guerrero de Troya</h1>
                                <span class="badge" style="display: inline-block; padding: 6px 16px; background-color: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #fca5a5;">Restablecer Contraseña</span>
                            </td>
                        </tr>
                        
                        <!-- Body -->
                        <tr>
                            <td class="email-body" style="padding: 40px 30px; background-color: #1e293b;">
                                <h1 class="greeting" style="font-family: 'Clash Display', Arial, sans-serif; font-size: 28px; font-weight: 700; color: #f1f5f9; margin: 0 0 20px 0; letter-spacing: -0.5px;">¡Hola, guerrero!</h1>
                                
                                <p class="message" style="font-size: 16px; color: #e0e7ff; margin: 0 0 30px 0; line-height: 1.7;">
                                    Recibimos una solicitud para restablecer la contraseña de tu cuenta en Guerrero de Troya. Si no realizaste esta solicitud, puedes ignorar este correo de forma segura.
                                </p>
                                
                                <div class="button-container" style="text-align: center; margin: 30px 0;">
                                    <a href="{{ $resetUrl }}" class="reset-button" style="display: inline-block; padding: 14px 32px; background-color: #ef4444; color: #ffffff !important; text-decoration: none; border-radius: 25px; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 3px;">
                                        Restablecer Contraseña
                                    </a>
                                </div>
                                
                                <div class="token-box" style="margin-top: 30px; padding: 20px; background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 12px;">
                                    <span class="token-label" style="font-size: 13px; font-weight: 600; color: #93c5fd; display: block; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Token de Restablecimiento</span>
                                    <div class="token-value" style="font-family: 'Courier New', monospace; font-size: 14px; color: #e0e7ff; word-break: break-all; background-color: rgba(15, 23, 42, 0.5); padding: 12px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1);">
                                        {{ $token }}
                                    </div>
                                    <p style="font-size: 12px; color: #94a3b8; margin: 12px 0 0 0;">
                                        Si prefieres usar la API, utiliza este token en el endpoint <code style="background-color: rgba(255, 255, 255, 0.1); padding: 2px 6px; border-radius: 4px; font-size: 11px;">POST /api/v1/password/reset</code>
                                    </p>
                                </div>
                                
                                <p class="expiration-text" style="margin-top: 30px; font-size: 13px; color: #94a3b8; line-height: 1.7;">
                                    Este enlace y token expirarán en <strong style="color: #e0e7ff;">{{ $expirationTime ?? 60 }} minutos</strong>. Después de ese tiempo, deberás solicitar un nuevo enlace de restablecimiento.
                                </p>
                                
                                <div class="warning-text" style="margin-top: 30px; padding: 16px; background-color: rgba(251, 191, 36, 0.1); border-left: 4px solid #fbbf24; border-radius: 8px; font-size: 13px; color: #fde68a; line-height: 1.7;">
                                    <strong style="display: block; margin-bottom: 8px;">⚠️ Importante:</strong>
                                    Si no solicitaste restablecer tu contraseña, te recomendamos que cambies tu contraseña de inmediato y contactes a nuestro equipo de soporte.
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td class="email-footer" style="padding: 30px; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.1); background-color: #0f172a;">
                                <p class="footer-text" style="font-size: 13px; color: #94a3b8; margin: 0 0 8px 0;">
                                    © {{ date('Y') }} Guerrero de Troya. Todos los derechos reservados.
                                </p>
                                <p class="footer-text" style="font-size: 13px; color: #94a3b8; margin: 0;">
                                    <a href="{{ config('app.url') }}" class="footer-link" style="color: #a855f7; text-decoration: none;">Visita nuestro sitio web</a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
