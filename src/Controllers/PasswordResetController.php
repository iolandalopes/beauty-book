<?php

namespace App\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Support\FlashMessage;
use App\Support\Mailer;
use App\Support\Token;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PasswordResetController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function forgotPasswordForm(ServerRequestInterface $request): ResponseInterface
    {
        $flashMessage = FlashMessage::get();

        return $this->render('authentication/forgot_password.html.twig', compact('flashMessage'));
    }

    public function sendResetLink(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';

        try {
            $user = $this->userModel->getUser($email);

            if (! $user) {
                throw new \Exception('Usuário não encontrado.');
            }

            $token = Token::generateResetToken();

            $resetPassword = new PasswordReset();
            $resetPassword->store([
                'user_id' => $user['id'],
                'token_hash' => password_hash($token, PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
            ]);

            $resetLink = "http://localhost:8000/reset-password?token={$token}";

            Mailer::sendEmail($email, 'Recuperação de senha', $resetLink);

            FlashMessage::set('success', 'Uma nova senha foi enviada para o seu e-mail.');
        } catch (\Exception $e) {
            FlashMessage::set('error', 'Não foi possível redefinir a senha. Verifique o e-mail informado.');
        }

        return new RedirectResponse('/login');
    }

    public function resetPasswordForm(ServerRequestInterface $request): ResponseInterface
    {
        $token = $request->getQueryParams()['token'] ?? '';

        return $this->render('authentication/reset_password.html.twig', compact('token'));
    }

    public function resetPassword(ServerRequestInterface $request): ResponseInterface
    {
        $token = $request->getParsedBody()['token'] ?? '';
        $newPassword = $request->getParsedBody()['password'] ?? '';

        $passwordReset = new PasswordReset();

        $tokens = $passwordReset->getAll();

        $validReset = null;

        foreach ($tokens as $tokenRecord) {
            if (password_verify($token, $tokenRecord['token_hash'])) {
                $validReset = $tokenRecord;
                $userId = $tokenRecord['user_id'];
                break;
            }
        }

        if (! $validReset) {
            die('Token inválido ou expirado.');
        }

        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $this->userModel->update([
            'id' => $userId,
            'password' => $newPasswordHash
        ]);

        return $this->render('authentication/login.html.twig');
    }
}