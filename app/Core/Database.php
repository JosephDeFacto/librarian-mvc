<?php

namespace App\Core;

class Database extends \PDO
{
    private static $instance = null;
    public function __construct()
    {
        $dbConfig = Router::config('db');
        $dsn = 'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['name'];

        parent::__construct($dsn, $dbConfig['user'], $dbConfig['password']);

        $this->setAttribute(
            \PDO::ATTR_DEFAULT_FETCH_MODE,
            \PDO::FETCH_ASSOC
        );
    }

    private function __clone()
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
}