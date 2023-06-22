<?php

namespace Src\utils;

use Firebase\JWT\JWT;

class JwtHelper
{
    public static function encode(object|array $data): string {
        return JWT::encode($data, $_ENV['JWT_SECRET'],  'HS256');
    }
}