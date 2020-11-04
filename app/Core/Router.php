<?php


namespace App\Core;

use App\Controller\HomeController;
use App\Controller\ErrorController;

class Router
{
    private $controller;
    private $action;
    private $params = [];
    private $url;

    public function resolve()
    {
        $this->parseURL();

        session_start();
        $isLoggedIn = isset($_SESSION['isLoggedIn']);

        //Session::getInstance()->isLoggedIn();

        if (!$this->controller) {
            $homepage = new HomeController();
            $interfaces = class_implements($homepage);
            $needToBeLoggedIn = isset($interfaces['App\Core\PrivateInterface']);
            //var_dump($needToBeLoggedIn);
            if($needToBeLoggedIn && !$isLoggedIn)
            {
                header('Location: /library-mvc/PublicController/login');
                return;
            }
            $homepage->index();
            return;
            //var_dump($fileName);
        }

        if (file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR . ucfirst($this->controller) . '.php')) {
            $controller = "\\app\\Controller\\" . ucfirst($this->controller);
            $this->controller = new $controller();
            $interfaces = class_implements($this->controller);
            $needToBeLoggedIn = isset($interfaces['App\Core\PrivateInterface']);
            if($needToBeLoggedIn && !$isLoggedIn)
            {
                header('Location: /library-mvc/PublicController/login');
                return;

            }
            if (method_exists($this->controller, $this->action)) {
                if (!empty($this->params)) {
                    call_user_func_array(array($this->controller, $this->action), $this->params);
                } else {
                    $this->controller->{$this->action}();
                }
                //$this->controller();

            } else {
                if (strlen($this->action) == 0) {
                    $this->controller->index();
                } else {
                    $errorpage = new ErrorController();
                    $errorpage->index();
                }

            }
        } else {
            $errorpage = new ErrorController();
            $errorpage->index();
        }
    }


    public function parseURL()
    {
        /*
        if(!isset($_GET['url']))
        {
            return;
        }
        */
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            $url = trim($url, '/');
            $url = explode('/', $url);

            $this->controller = isset($url[0]) ? $url[0] : '/';
            $this->action = isset($url[1]) ? $url[1] : '/';

            unset($url[0], $url[1]);

            $this->params = array_values($url);
        }

    }
    /*
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    public function getUrl() {
        return $this->url;
    }
    */

    public static function config($key)
    {
        $configPath = ROOT_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config.php';
        $config = include $configPath;
        return $config[$key];
    }
}