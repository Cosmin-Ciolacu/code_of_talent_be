<?php

namespace Src\utils;

class ResponseSender
{
    public static function json(array $data, int $status = 200): void
    {
        header('Content-type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }

    public static function send($data, int $status = 200): void
    {
        http_response_code($status);
        echo $data;
    }
}