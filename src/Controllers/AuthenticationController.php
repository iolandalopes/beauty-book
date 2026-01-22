<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticationController extends BaseController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('authentication/login.html.twig');
    }
}