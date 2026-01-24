<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restablece tu contraseña - Guerrero de Troya</title>
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
            background-color: #16a34a;
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
        
        .cta-button {
            display: inline-block;
            padding: 16px 32px;
            background-color: #16a34a;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        
        .cta-button:hover {
            background-color: #15803d;
        }
        
        .button-wrapper {
            text-align: center;
            margin: 30px 0;
        }
        
        .divider {
            border: 0;
            border-top: 1px solid #334155;
            margin: 30px 0;
        }
        
        .security-notice {
            background-color: #1e293b;
            border-left: 4px solid #44ef6f;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        
        .security-notice-title {
            font-family: 'Clash Display', Arial, sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #fefefe;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
        }
        
        .security-notice-text {
            font-size: 14px;
            color: #cbd5e1;
            margin: 0;
            line-height: 1.6;
        }
        
        .expiry-info {
            background-color: #334155;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .expiry-info-text {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
        }
        
        .expiry-info-time {
            font-size: 16px;
            font-weight: 700;
            color: #fbbf24;
            margin: 5px 0 0 0;
        }
        
        .alternative-link {
            margin: 25px 0;
            padding: 20px;
            background-color: #0f172a;
            border-radius: 8px;
        }
        
        .alternative-link-title {
            font-size: 14px;
            color: #94a3b8;
            margin: 0 0 10px 0;
            font-weight: 600;
        }
        
        .alternative-link-url {
            font-size: 12px;
            color: #60a5fa;
            word-break: break-all;
            text-decoration: none;
            display: block;
        }
        
        .email-footer {
            background-color: #0f172a;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #334155;
        }
        
        .footer-text {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 15px 0;
        }
        
        .footer-links {
            margin: 15px 0;
        }
        
        .footer-link {
            color: #16a34a;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
            font-weight: 600;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .footer-copyright {
            font-size: 12px;
            color: #475569;
            margin: 20px 0 0 0;
        }
        
        /* Media Queries para responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                border-radius: 0 !important;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 25px 20px !important;
            }
            
            .logo-text {
                font-size: 28px !important;
            }
            
            .greeting {
                font-size: 24px !important;
            }
            
            .cta-button {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td align="center">
                    <div class="email-container">
                        <!-- Header -->
                        <div class="email-header">
                            <h1 class="logo-text">Guerrero de Troya</h1>
                            <span class="badge">Seguridad</span>
                        </div>
                        
                        <!-- Body -->
                        <div class="email-body">
                            <h2 class="greeting">¡Hola!</h2>
                            
                            <p class="message">
                                Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.
                            </p>
                            
                            <div class="button-wrapper">
                                <a href="{{ $resetUrl }}" class="cta-button">Restablecer Contraseña</a>
                            </div>
                            
                            <div class="expiry-info">
                                <p class="expiry-info-text">Este enlace expirará en:</p>
                                <p class="expiry-info-time">{{ $expirationTime }} minutos</p>
                            </div>
                            
                            <div class="security-notice">
                                <p class="security-notice-title">Aviso de Seguridad</p>
                                <p class="security-notice-text">
                                    Si no solicitaste restablecer tu contraseña, ignora este correo. Tu cuenta permanecerá segura y no se realizarán cambios.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="email-footer">
                            <p class="footer-text">
                                Este es un correo automático, por favor no respondas a este mensaje.
                            </p>
                            <p class="footer-copyright">
                                &copy; {{ date('Y') }} Guerrero de Troya. Todos los derechos reservados.
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
