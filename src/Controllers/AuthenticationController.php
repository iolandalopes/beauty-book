<?php

namespace App\Controllers;

use App\Models\User;
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
        return $this->render('authentication/login.html.twig');
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        try {
            $user = $this->userModel->getUser($email);

            if (! password_verify($password, $user['password'])) {
                return $this->render('authentication/login.html.twig', [
                    'error' => 'Credenciais inválidas.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->render('authentication/login.html.twig', [
                'error' => 'Credenciais inválidas.'
            ]);
        }

        return new RedirectResponse('/');
    }
}