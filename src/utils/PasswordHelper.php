<?php

namespace Src\utils;

class PasswordHelper
{
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function compare(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}