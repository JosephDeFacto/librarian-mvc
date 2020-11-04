<?php

namespace App\Core;

//use App\Model;
//use App\Core\View;

class Controller
{
    public $model;
    public $view;

    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

}