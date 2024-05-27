<?php

namespace App\Controllers;

class UserController
{
    public function login()
    {
        $this->render('user/login');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    public function resetPassword()
    {
        $this->render('user/reset-password');
    }

    public function profile()
    {
        $this->render('user/profile');
    }

    public function register()
    {
        $this->render('user/register');
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require BASE_PATH . '/Views/' . $view . '.php';
    }
}