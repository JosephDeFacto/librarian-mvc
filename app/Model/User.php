<?php

namespace App\Model;

use PDO;
use App\Core\Database;
use App\Core\Model;

class User
{
    public function register($firstname, $lastname, $email, $username, $password, $registrationDate)
    {
        $sql = "INSERT INTO users (firstname, lastname, email, username, password, registrationDate)
                    VALUES (:firstname, :lastname, :email, :username, :password, :registrationDate)";
        $stmt = Database::getInstance()->prepare($sql);
        //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        //$stmt->bindParam(':phoneNumber', $data['phoneNumber'], PDO::PARAM_STR_CHAR);
        //$stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
        //$stmt->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
        //$stmt->bindParam(':avatar', $data['avatar']);
        $stmt->bindParam(':registrationDate', $registrationDate);
        //$stmt->bindParam(':activeUntil', $data['activeUntil']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($email, $password)
    {
        //$hash_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM users WHERE email = :email OR password = :password";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        $loginData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $loginData;
    }

    public function emailExists($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
        //return ($stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : false);

    }
    /*
    public function add($data)
    {
        // first check if username or email is available in db
        //User can rent maximum 6 books, create counter as zero, when counter reaches 6, then disable rent button

        $sql = "INSERT INTO users (firstname, lastname, email, phoneNumber, address, gender, avatar, registrationDate, activeUntil)
                    VALUES (:firstname, :lastname, :email, :phoneNumber, :address, :gender, :avatar, :registrationDate, :activeUntil)";
        $stmt = Database::getInstance()->prepare($sql);
            //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phoneNumber', $data['phoneNumber'], PDO::PARAM_STR_CHAR);
        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $data['avatar']);
        $stmt->bindParam(':registrationDate', $data['registrationDate']);
        $stmt->bindParam(':activeUntil', $data['activeUntil']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    */

    public function edit($data)
    {

        $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, username = :username, registrationDate = :registrationDate,
                activeUntil = :activeUntil WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
            //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $data['firstame'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(':registrationDate', $data['registrationDate']);
        $stmt->bindParam(':activeUntil', $data['activeUntil']);

        if ($stmt->execute()) {
            return true;
        }
    }

    public function delete($id)
    {

            //$stmt = Database::getInstance()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE  FROM users WHERE id = :id";
            $stmt = Database::getInstance()->prepare($sql);
            //$stmt->prepare($sql);
            //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            }
            return false;

    }

    public function getUsers()
    {
        try {
            $sql = "SELECT * FROM users";
            $stmt = Database::getInstance()->prepare($sql);
            //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();

            $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $allUsers;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getUser($id)
    {
        $sql = "SELECT firstname, lastname, email, username, registrationDate, activeUntil FROM users WHERE id = :id";
        //$sql = "SELECT * FROM users WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return ($stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : false);

    }

    public function getNumberOfUsers()
    {
        try {
            $sql = "SELECT COUNT(id) AS number_of_users FROM users";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();
            return $stmt->fetch()->number_of_users;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function userExistsInTable($firstname, $lastname)
    {

        $sql = "SELECT * FROM users WHERE firstname = :firstname AND lastname = :lastname";
        $stmt = Database::getInstance()->prepare($sql);
            //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname]);
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // check user availability
    // check users who didn't return book
    public function getUsername($username)
    {
        $sql = "SELECT username FROM users WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute(['username' => $username]);
        return ($stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : false);

    }
}