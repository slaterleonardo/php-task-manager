<?php

namespace App\Core;
use App\Services\UserService;

class Router {
    protected $routes = [];

    public function define($routes) {
        $this->routes = $routes;
    }

    public function dispatch(Request $request) {
        $uri = $request->getUri();

        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $user = UserService::readById($userId);

            if ($user) {
                $_SESSION['user'] = $user;
            } else {
                unset($_SESSION['user']);
            }
        }

        foreach ($this->routes as $route => $action) {
            if ($route === $uri) {
                if ($_SERVER['REQUEST_METHOD'] === "PUT") {
                    $this->callAction($action);
                    return;
                }

                require PARTIAL_PATH . 'header.php';
                $this->callAction($action);
                require PARTIAL_PATH . 'footer.php';
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    protected function callAction($action) {
        list($controller, $method) = explode('@', $action);
        $controller = "App\\Controllers\\{$controller}";
        $controllerInstance = new $controller;
        return $controllerInstance->$method();
    }
}
