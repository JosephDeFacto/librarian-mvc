<?php

namespace App\Model;

use PDO;
use App\Core\Database;

class Genre
{
    public function getAllGenres()
    {
        try {
            $sql = "SELECT * FROM genre";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function getNumberOfGenres()
    {
        try {
            $sql = "SELECT COUNT(id) as number_of_genres FROM genre";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();

            $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $genres;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}