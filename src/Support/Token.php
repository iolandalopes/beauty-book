<?php

namespace App\Support;

class Token
{
    public static function generateResetToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}