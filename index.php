<?php

require 'vendor/autoload.php';
use Src\lib\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
$router
    ->enableCors()
    ->get('/test', 'TestController@index')
    ->post('/login', 'AuthController@login')
    ->startRouter();