<?php

use App\Controllers\AuthenticationController;
use App\Controllers\AvailabilityController;
use App\Controllers\HomeController;
use App\Controllers\PasswordResetController;
use League\Route\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->map('GET', '/login', [AuthenticationController::class, 'index']);
$router->map('POST', '/login', [AuthenticationController::class, 'login']);
$router->map('POST', '/logout', [AuthenticationController::class, 'logout']);

$router->map('GET', '/forgot-password', [PasswordResetController::class, 'forgotPasswordForm']);
$router->map('POST', '/forgot-password', [PasswordResetController::class, 'sendResetLink']);
$router->map('GET', '/reset-password', [PasswordResetController::class, 'resetPasswordForm']);
$router->map('POST', '/reset-password', [PasswordResetController::class, 'resetPassword']);

$router->map('GET', '/', [HomeController::class, 'index']);

$router->map('GET', '/availabilities', [AvailabilityController::class, 'index']);
$router->map('GET', '/availabilities/create', [AvailabilityController::class, 'create']);
$router->map('POST', '/availabilities', [AvailabilityController::class, 'store']);
$router->map('DELETE', '/availabilities/{id}', [AvailabilityController::class, 'destroy']);
$router->map('GET', '/availabilities/{id}', [AvailabilityController::class, 'edit']);
$router->map('PUT', '/availabilities/{id}', [AvailabilityController::class, 'update']);
