<?php

use App\Services\UserService;
use App\Services\TaskService;

if (!isset($_SESSION['user'])) {
    header('Location: /');
}


if (!$_SESSION['user']['isAdmin']) {
    header('Location: /');
    exit;
}

$userId = $_GET['id'];

if (UserService::deleteUserById($userId) && TaskService::deleteTasksByUserId($userId)) {
    header("Location: /admin");
} else {
    echo 'An error occurred';
}
