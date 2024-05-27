<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../app/Config/app.php';

use App\Core\Request;
use App\Core\Router;

try {
    $request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    $router = new Router();

    require_once __DIR__ . '/../routes.php';

    $router->dispatch($request);
} catch (Exception $err) {
    http_response_code(500);
    echo $err->getMessage();
}