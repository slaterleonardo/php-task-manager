<?php

namespace App\Controllers;

class TaskController
{
    public function index()
    {
        $this->render('task/tasks');
    }

    public function create()
    {
        $this->render('task/create');
    }

    public function task()
    {
        $this->render('task/task');
    
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require BASE_PATH . '/Views/' . $view . '.php';
    }
}