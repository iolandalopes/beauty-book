<?php

namespace App\Support;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer 
{
    public static function sendEmail(string $to, string $subject, string $resetLink): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__, '../../');
        $dotenv->load();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_SECURE'];
        $mail->Port = $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($to, 'Nome do Destinatário');

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Recuperação de senha';
        $mail->Body = self::formatBody($resetLink);
        $mail->send();
    }

    protected static function formatBody(string $resetLink): string
    {
        return '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Redefinição de senha</title>
        </head>
        <body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
                <tr>
                    <td align="center">
                        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden;">
                            
                            <!-- Header -->
                            <tr>
                                <td style="background-color:#7e22ce; padding:20px 30px; color:#ffffff;">
                                    <h1 style="margin:0; font-size:20px; font-weight:600;">
                                        AgendaPRO
                                    </h1>
                                </td>
                            </tr>

                            <!-- Content -->
                            <tr>
                                <td style="padding:30px;">
                                    <p style="font-size:15px; color:#333333; margin:0 0 16px 0;">
                                        Olá,
                                    </p>

                                    <p style="font-size:15px; color:#333333; margin:0 0 16px 0;">
                                        Recebemos uma solicitação para redefinir a senha da sua conta.
                                    </p>

                                    <p style="font-size:15px; color:#333333; margin:0 0 24px 0;">
                                        Para continuar, clique no botão abaixo:
                                    </p>

                                    <!-- Button -->
                                    <table cellpadding="0" cellspacing="0" style="margin:0 auto 24px auto;">
                                        <tr>
                                            <td align="center" style="background-color:#7e22ce; border-radius:4px;">
                                                <a href="' . htmlspecialchars($resetLink) . '"
                                                style="display:inline-block; padding:12px 24px; font-size:15px; color:#ffffff; text-decoration:none; font-weight:600;">
                                                    Redefinir senha
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="font-size:14px; color:#555555; margin:0 0 16px 0;">
                                        Este link é válido por <strong> uma hora </strong>.
                                    </p>

                                    <p style="font-size:14px; color:#555555; margin:0;">
                                        Caso você não tenha solicitado a redefinição de senha, nenhuma ação é necessária.
                                    </p>
                                </td>
                            </tr>

                            <!-- Footer -->
                            <tr>
                                <td style="background-color:#f4f6f8; padding:20px 30px; font-size:12px; color:#777777;">
                                    <p style="margin:0 0 6px 0;">
                                        Este é um e-mail automático. Por favor, não responda.
                                    </p>
                                    <p style="margin:0;">
                                        © ' . date('Y') . ' AgendaPRO. Todos os direitos reservados.
                                    </p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
    }
}