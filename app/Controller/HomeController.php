<?php

namespace App\Controller;

use App\Controller\UserController;
use App\Core\Controller;
use App\Core\Model;
use App\Core\PrivateInterface;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;
use App\Model\Book;


class HomeController extends Controller implements PrivateInterface
{

    public function index()
    {

        $view = new View();

        $this->view->render('home' . DIRECTORY_SEPARATOR . 'index');
    }

}
