<?php

namespace App\Model;

use App\Core\Database;
use mysql_xdevapi\Executable;
use PDO;

class Borrow
{

    /*
    public function getBorrowedBooks($isbn)
    {
        $sql = "SELECT isbn, title, author, year, firstname, lastname FROM books 
                INNER JOIN rentbook ON books.isbn = rentbook.book_id 
                INNER JOIN users ON rentbook.user_id = users.id WHERE rentbook.book_id = books.isbn";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam('isbn', $isbn);
        $stmt->execute();

        return ($stmt->rowCount() ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false);
    }
    */

    public function getUsersThoseWhoLate()
    {
        $sql = "SELECT isbn, title, author, year, firstname, lastname, date_rented, date_returned FROM books
                INNER JOIN rentbook ON books.isbn = rentbook.book_id
                LEFT JOIN users ON rentbook.user_id = users.id
                WHERE date_returned IS NULL AND DATEDIFF(CURDATE(), date_rented) < 15";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();
        $usersWhoLate = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usersWhoLate;

    }
    /*
    public function borrowBook($isbn)
    {
        $sql = "SELECT * FROM books WHERE isbn = :isbn LIMIT 2";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam('isbn', $isbn);
        $stmt->execute();
        $borrowBook = $stmt->fetch(PDO::FETCH_ASSOC);
        return $borrowBook;
    }
    */

}