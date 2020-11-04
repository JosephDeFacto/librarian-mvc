<?php


namespace App\Core;


class Request
{
    public static function get($key, $default = '')
    {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public static function post($key, $default = '')
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public static function files($name)
    {
        return isset($_FILES[$name]) ? $_FILES[$name] : null;
    }

    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}