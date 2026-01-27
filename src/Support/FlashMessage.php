<?php

namespace App\Support;

class FlashMessage
{
    public static function set(string $type, string $message): void
    {
        if (! isset($_SESSION)) {
            session_start();
        }

        $_SESSION['flash_message'] = [
            ...$_SESSION['flash_message'] ?? [],
            $type => $message,
        ];
    }

    public static function get(): ?array
    {
        if (! isset($_SESSION)) {
            session_start();
        }

        $message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);

        return $message;
    }
}