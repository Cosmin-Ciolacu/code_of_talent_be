<?php

namespace Src\lib;

use Src\utils\ResponseSender;

class Router
{
    private array $routes;

    public function __construct() {
        $this->routes = [];
    }

    public function enableCors(): Router {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
        return $this;
    }

    public function get(string $url, string $controllerAction): Router {
        $this->routes[$url] = "GET@$controllerAction";

        return $this;
    }

    public function post(string $url, string $controllerAction): Router {
        $this->routes[$url] = "POST@$controllerAction";

        return $this;
    }

    public function put(string $url, string $controllerAction): Router {
        $this->routes[$url] = "PUT@$controllerAction";

        return $this;
    }

    public function delete(string $url, string $controllerAction): Router {
        $this->routes[$url] = "DELETE@$controllerAction";

        return $this;
    }

    public function startRouter() {
        $requestUri = $_SERVER['REQUEST_URI'];
        if (!array_key_exists($requestUri, $this->routes)) {
            ResponseSender::json([
                'message' => 'route not found'
            ], 404);
            return;
        }

        [$requestMethod, $controllerName, $methodName] = explode('@', $this->routes[$requestUri]);
        if ($requestMethod != $_SERVER['REQUEST_METHOD']) {
            ResponseSender::json([
                'message' => 'invalid http method'
            ], 500);
            return;
        }

        $namespace = '\\Src\Controllers';
        $fullClass = "$namespace\\$controllerName";
        $controller = new $fullClass();
        $controller->$methodName();
    }



}