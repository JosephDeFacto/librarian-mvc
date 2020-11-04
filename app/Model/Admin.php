<?php

namespace App\Model;

use PDO;
use App\Core\Database;

class Admin
{
    public function login($username, $email, $password)
    {

        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "SELECT username, email, password FROM admin WHERE username = :username OR email = :email OR password = :password_hash";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $admin = $stmt->fetchObject('Admin');
        return $stmt;

    }
    public function addNewAdmin($username, $email, $password)
    {

            $sql = "INSRET INTO admin (username, email, password) VALUES (:username, :email, :password)";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

    }
}