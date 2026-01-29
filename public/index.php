<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';

use App\Support\Csrf;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

$request =  ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    Csrf::token();
}

if($request->getMethod() === 'POST' && isset($_POST['_method'])) {
    $request = $request->withMethod($_POST['_method']);
}

$response = $router->dispatch($request);

(new SapiEmitter)->emit($response);