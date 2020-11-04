<?php


namespace App\Core;


class Session
{
    private static $instance;

    private function __construct()
    {
        session_start();
    }


    public function __clone()
    {
        // prevent from cloning
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function login()
    {
        $_SESSION['isLoggedIn'] = true;
    }

    public function isLoggedIn()
    {
        $isLoggedIn = isset($_SESSION['isLoggedIn']) ? true : false;
    }


    public function logout()
    {
        unset($_SESSION['isLoggedIn']);
        session_destroy();
    }
}