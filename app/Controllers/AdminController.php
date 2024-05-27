<?php

namespace App\Controllers;

class AdminController
{
    public function index()
    {
        $this->render('admin/index');
    }

    public function editUser()
    {
        $this->render('admin/edit-user');
    }

    public function deleteUser()
    {
        $this->render('admin/delete-user');
    }

    public function editTask()
    {
        $this->render('admin/edit-task');
    }

    public function deleteTask()
    {
        $this->render('admin/delete-task');
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require BASE_PATH . '/Views/' . $view . '.php';
    }
}
