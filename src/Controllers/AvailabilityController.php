<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AvailabilityController extends BaseController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        AuthMiddleware::handle();
        return $this->render('availabilities/index.html.twig');
    }
}