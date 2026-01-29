<?php

namespace App\Controllers;

use App\Models\User;
use App\Support\Authentication;
use App\Support\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticationController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $flashMessage = FlashMessage::get();

        return $this->render('authentication/login.html.twig', compact('flashMessage'));
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        try {
            $user = $this->userModel->getUser($email);

            if (! password_verify($password, $user['password'])) {
                FlashMessage::set('error', 'Credenciais inválidas.');
                FlashMessage::set('old_email', $email);

                return new RedirectResponse('/login');
            }
        } catch (\Exception $e) {
            FlashMessage::set('error', 'Credenciais inválidas.');
            FlashMessage::set('old_email', $email);

            return new RedirectResponse('/login');
        }

        $_SESSION['auth'] = [
            'id'    => $user['id'],
            'email' => $user['email'],
            'name'  => $user['name'] ?? null,
        ];

        return new RedirectResponse('/');
    }

    public function logout(ServerRequestInterface $request): ResponseInterface
    {
        Authentication::logout();
        return new RedirectResponse('/login');
    }
}