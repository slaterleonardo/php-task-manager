<?php

use App\Core\Router;

$router = new Router();

$router->define([
    '/' => 'TaskController@index',
    '/user/login' => 'UserController@login',
    '/user/logout' => 'UserController@logout',
    '/user/reset-password' => 'UserController@resetPassword',
    '/user/profile' => 'UserController@profile',
    '/user/register' => 'UserController@register',

    '/task/create' => 'TaskController@create',
    '/task' => 'TaskController@task',

    '/admin' => 'AdminController@index',
    '/admin/edit-user' => 'AdminController@editUser',
    '/admin/delete-user' => 'AdminController@deleteUser',
    '/admin/edit-task' => 'AdminController@editTask',
    '/admin/delete-task' => 'AdminController@deleteTask',
]);

return $router;
