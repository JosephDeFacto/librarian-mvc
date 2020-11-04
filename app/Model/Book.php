<?php

namespace App\Model;

use App\Core\Database;
use App\Core\Model;
use PDO;


class Book
{
    public function getBooks()
    {
        $sql = "SELECT * FROM books";

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll();

        return $books;

        $rows = $stmt->rowCount();
    }

    public function add($data)
    {   // add cover
        $sql = "INSERT INTO books (title, year, author, cover, createdDate) VALUES (:title, :year, :author, :cover, :createdDate)";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':year', $data['year']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':cover', $data['cover']);
        $stmt->bindParam(':createdDate', $data['createdDate']);

        $stmt->execute();

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($data)
    {
        try {
            Database::getInstance()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE books SET title = :title, year = :year, author = :author, createdDate = :createdDate WHERE isbn = :isbn";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->bindParam(':isbn', $data['isbn']);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':year', $data['year']);
            $stmt->bindParam(':author', $data['author']);
            $stmt->bindParam(':createdDate', $data['createdDate']);
            if ($stmt->execute()) {
                return true;
            }
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function delete($isbn)
    {
        $sql = "DELETE FROM books WHERE isbn = :isbn";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        if ($stmt) {
            return true;
        }
        return false;
    }

    public function getBook($isbn)
    {
        $sql = "SELECT isbn, title, year, author, createdDate FROM books WHERE isbn = :isbn";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        return ($stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : false);
    }

    public function getNumberOfBooks()
    {
        $sql = "SELECT COUNT(isbn) AS number_of_songs FROM books";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()->number_of_songs;
    }
    // query-check to see if book exists in db
    public function bookExistsInTable($title)
    {
        $sql = "SELECT * FROM books WHERE title = :title";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':title' => $title]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function borrowBook($data, $date_rented = null)
    {
        $date_rented = date('Y-m-d');
        $sql = "INSERT INTO rentbook (book_id, user_id, date_rented) VALUES (:book_id, :user_id, :date_rented)";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':book_id', $data['book_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':date_rented', $date_rented);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function returnBook($user_id, $book_isbn)
    {
        $date_return = date('Y-m-d');
        $sql = "UPDATE rentbook SET date_returned = :date_returned WHERE user_id = :user_id AND book_isbn = :book_isbn";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':date_returned', $date_return);
        $stmt->bindParam(':book_isbn', $book_isbn);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    public function getMyBooks($isbn)
    {
        $sql = "SELECT isbn, title, author, year, firstname, lastname, date_rented FROM books
                INNER JOIN rentbook ON books.isbn = rentbook.book_id
                INNER JOIN users ON rentbook.user_id = users.id WHERE rentbook.book_id = books.isbn";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        $myBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $myBooks;
    }
    /*
    public function borrowBook($isbn)
    {
        $date_rented = date('Y-m-d');
        $sql = "SELECT isbn, title, author, year, firstname, lastname, date_rented FROM books 
                INNER JOIN rentbook ON books.isbn = rentbook.book_id 
                INNER JOIN users ON rentbook.user_id = users.id WHERE rentbook.book_id = books.isbn LIMIT 6";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam('isbn', $isbn);
        $stmt->bindParam('date_rented', $date_rented);
        $stmt->execute();
        $borrowBook = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $borrowBook;

        //return ($stmt->rowCount() ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false);
    }
    */
    /*
    public function borrowBook($isbn)
    {
        //$date_rented = date('Y-m-d');
        $sql = "SELECT isbn, title, year, author FROM books WHERE isbn = :isbn";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        $borrowBook = $stmt->fetch(PDO::FETCH_ASSOC);
        return $borrowBook;
    }
    */
}