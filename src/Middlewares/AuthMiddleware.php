<?php

namespace App\Middlewares;

use App\Support\Auth;
use App\Support\FlashMessage;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (! Auth::check()) {
            FlashMessage::set('error', 'Faça login para continuar.');
            header('Location: /login');
            exit;
        }
    }
}
