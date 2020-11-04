<?php

namespace App\Core;

class View
{


    public function render($name, $data = [])
    {
        ob_start();
        //extract($data);
        $views = ROOT_PATH . DIRECTORY_SEPARATOR .  'App' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . "$name.phtml";
        if (file_exists($views)) {
            require_once $views;
        }

        return $this;
    }

    /*
    public function __toString()
    {
        return $this->layout;
    }
    */


    public static function escapeHTML($value)
    {
        return htmlspecialchars($value);
    }
}

