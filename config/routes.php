<?php

use App\Controllers\AuthenticationController;
use App\Controllers\HomeController;
use League\Route\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->map('GET', '/login', [AuthenticationController::class, 'index']);

$router->map('GET', '/', [HomeController::class, 'index']);