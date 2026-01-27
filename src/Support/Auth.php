<?php

namespace App\Support;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['auth']);
    }

    public static function user(): ?array
    {
        return $_SESSION['auth'] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION['auth']['id'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['auth']);
        session_regenerate_id(true);
    }
}
