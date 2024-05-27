<?php

use App\Services\TaskService;

if (!isset($_SESSION['user'])) {
    header('Location: /');
}


if (!$_SESSION['user']['isAdmin']) {
    header('Location: /');
    exit;
}

$userId = $_GET['id'];

echo TaskService::deleteById($taskId) ? header("Location: /admin") : 'An error occurred';
