<?php

use League\Route\Router;
use App\Controllers\HomeController;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->map('GET', '/', [HomeController::class, 'index']);