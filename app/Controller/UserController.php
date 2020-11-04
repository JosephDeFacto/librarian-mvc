<?php

namespace App\Controller;

use App\Core\PrivateInterface;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Model\Book;
use App\Model\User;
use App\Core\View;
use App\Core\Controller;
use App\Core\Database;

class UserController extends Controller implements PrivateInterface
{

    public function index()
    {
        $user = new User();
        $data = $user->getUsers();
        $view = new View();

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'index', $data);

        /*
        if (Session::getInstance()->isLoggedIn()) {
            echo "You are logged in";
        }
        */
    }
    /*
    public function register()
    {
        $user = new User();
        $view = new View();

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'register');


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstname = Request::post('firstname');
            $lastname = Request::post('lastname');
            $email = Request::post('email');
            $password = Request::post('password');
            $registrationDate = Request::post('registrationDate');
            $data = [
                'firstname' => Request::post('firstname'),
                'lastname' => Request::post('lastname'),
                'email' => Request::post('email'),
                'password' => password_hash(Request::post('password'), PASSWORD_BCRYPT),
                'confirm-pass' => Request::post('confirm-pass'),
                'registrationDate' => Request::post('registrationDate')
            ];

            $validator = new Validator();
            if (!$validator->isEmail($email)) {
                exit("Email is not valid");
            }

            if ($user->emailExists($email)) {
                exit("Email already exists");
            }

            if ($user->register($firstname, $lastname, $email, $password, $registrationDate)) {
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
                Session::getInstance()->login();
                header('Location: book/index');
            } else {
                return;
            }
        }
    }


    public function logout()
    {
        Session::getInstance()->logout();

        header('Location: login');

    }
    */
    /*
    public function login()
    {
        $user = new User();
        $view = new View();

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST')

            $data = [
                'email' => Request::post('email'),
                'password' => password_hash(Request::post('password'), PASSWORD_BCRYPT)
            ];


            $email = Request::post('email');
            $password = Request::post('password');

            if ($user->login($email, $password)) {
                Session::getInstance()->login();
                header('Location: index');
            }
        }
    }
    */
    /*
    public function add()
    {
        $user = new User();
        //$arr = [$firstname => $user->getUser(isset($_GET['id']) ? $_GET['id'] : null, $lastname => $user->]

        $view = new View();
        $this->view->render('user' . DIRECTORY_SEPARATOR . 'add');
        $avatar = isset($FILES['avatar']['name']) ? $_FILES['avatar']['name'] : null;

        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['avatar']['name'])) {
                $data = [
                    'firstname' => Request::post('firstname'),
                    'lastname' => Request::post('lastname'),
                    'email' => Request::post('email'),
                    'phoneNumber' => Request::post('phoneNumber'),
                    'address' => Request::post('address'),
                    'gender' => Request::post('gender'),
                    'avatar' => $_FILES['avatar']['name'],
                    'registrationDate' => Request::post('registrationDate'),
                    'activeUntil' => Request::post('activeUntil'),
                ];



                $target_dir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                $target_file = $target_dir . basename($_FILES['avatar']['name']);
                $type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowedExt = ["jpg", "jpeg", "gif", "png"];
                if (in_array($type, $allowedExt)) {
                    $imageBase64 = base64_encode(file_get_contents($_FILES['avatar']['tmp_name']));
                    $image = 'data:image/' . $type . ';base64,' . $imageBase64;
    */

                    /*if(move_uploaded_file($_FILES['avatar']['tmp_name'],   $target_file . $avatar)) {
                        echo "Successfully uploaded file";
                    }

                    */

                    //move_uploaded_file($_FILES['avatar']['tmp_name'],   $target_file . $avatar);
               // }

            //}
    /*
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['email']) || empty($data['phoneNumber']) || empty($data['address']) ||
                empty($data['gender']) || empty($data['avatar']) || empty($data['registrationDate']) || empty($data['activeUntil'])) {
                exit("All fields must be filled in");
            }

            if ($user->userExistsInTable($data['firstname'], $data['lastname'])) {
                exit("User already exists");
            }
            if ($user->add($data)) {
                header('Location: index');
            }
        }
    }
    */

    public function edit()
    {
        $user = new User();
        $view = new View();

        //$id = array_key_exists('id', $_GET) ? $_GET['id'] : null; // would work just fine
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $data = $user->getUser($id);
        //var_dump($data); // --

        $this->view->render('user' . DIRECTORY_SEPARATOR . 'edit', $data);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
            $data = [
                'firstname' => Request::post('firstname'),
                'lastname' => Request::post('lastname'),
                'email' => Request::post('email'),
                'phoneNumber' => Request::post('phoneNumber'),
                'address' => Request::post('address'),
                'gender' => Request::post('gender'),
                'avatar' => Request::post('avatar'),
                'registrationDate' => Request::post('registrationDate'),
                'activeUntil' => Request::post('activeUntil')
            ];
            if ($user->edit($data)) {
                header('Location: index');
            } else {
                echo "Something went wrong";
            }
        }
    }

    public function delete()
    {
        $user = new User();
        //$view = new View();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $data = $user->getUser($id);

        if ($user->delete($id)) {
            header('Location: index');
        } else {
            echo "Something went wrong";
        }
    }
}