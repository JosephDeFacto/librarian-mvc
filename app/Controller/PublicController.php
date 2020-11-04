<?php

namespace App\Controller;

use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Model\Book;
use App\Model\User;
use App\Core\View;
use App\Core\Controller;
use App\Core\Database;

class PublicController extends Controller
{

    public function register()
    {
        $user = new User();
        $view = new View();

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'register');


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstname = Request::post('firstname');
            $lastname = Request::post('lastname');
            $email = Request::post('email');
            $username = Request::post('username');
            $password = password_hash(Request::post('password'), PASSWORD_BCRYPT);
            $registrationDate = Request::post('registrationDate');

            $validator = new Validator();
            if (!$validator->isEmail($email)) {
                exit("Email is not valid");
            }

            if ($user->emailExists($email)) {
                exit("Email already exists");
            }

            if ($user->register($firstname, $lastname, $email, $username, $password, $registrationDate)) {
                header('Location: login');
            }
        }

    }

    public function login()
    {
        $user = new User();
        $view = new View();
        $this->view->render('user' . DIRECTORY_SEPARATOR . 'login');

        if (Request::isPost()) {
            $email = Request::post('email');
            $password = password_hash(Request::post('password'), PASSWORD_BCRYPT);


            if ($user->login($email, $password)) {
                //Session::getInstance()->login();
                Session::getInstance()->login();
                header('Location: /library-mvc/BookController/index');
            } else {
                return;
            }
        }
    }

    public function logout()
    {
        Session::getInstance()->logout();

        header('Location: /library-mvc/');
    }
}