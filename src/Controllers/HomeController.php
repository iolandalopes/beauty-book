<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends BaseController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();
        return $this->render('index.html.twig');
    }
}