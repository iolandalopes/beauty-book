<?php

namespace App\Middlewares;

use App\Support\Authentication;
use App\Support\FlashMessage;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (! Authentication::check()) {
            FlashMessage::set('error', 'Faça login para continuar.');
            header('Location: /login');
            exit;
        }
    }
}
