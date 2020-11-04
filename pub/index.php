<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
define('ROOT_PATH', dirname(__DIR__));

//use Controller\HomeController;
use App\Core\View;
use App\Core\Router;


//define()


spl_autoload_register(function ($className) {
    $class = lcfirst($className);
    $filename = ROOT_PATH . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $k = file_exists($filename);

    if (file_exists($filename)) {
        require_once $filename;
    }
});

$router = new Router();
$router->resolve();
/*
$router->setUrl($_GET['url'])->getUrl();
$router->parseUrl();
$router->resolve();
*/


