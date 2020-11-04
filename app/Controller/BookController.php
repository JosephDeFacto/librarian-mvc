<?php


namespace App\Controller;
use App\Core\Controller;
use App\Core\Database;
use App\Core\PrivateInterface;
use App\Core\Request;
use App\Core\Session;
use App\Core\View;
use App\Model\Book;
use App\Core;
use App\Model\User;


class BookController extends Controller implements PrivateInterface
{
    public function index()
    {
        $book = new Book();
        $data = $book->getBooks();
        $view = new View();
        $view->render('book' . DIRECTORY_SEPARATOR . 'index', $data);

    }

    public function add()
    {

        $book = new Book();

        $view = new View();

        $this->view->render('book' . DIRECTORY_SEPARATOR . 'add');

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $cover = isset($_FILES['cover']['name']) ? $_FILES['cover']['name'] : null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['cover']['name'])) {
                $data = [
                    'title' => $_POST['title'],
                    'year' => $_POST['year'],
                    'author' => $_POST['author'],
                    'cover' => $_FILES['cover']['name'],
                    'createdDate' => $_POST['createdDate']
                ];
                    //$target_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR. 'uploads';
                    //$target_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads';
                $target_dir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                $target_file = $target_dir . basename($_FILES['cover']['name']);
                $type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowedExt = ["jpg", "jpeg", "gif", "png"];
                if (in_array($type, $allowedExt)) {
                    $imageBase64 = base64_encode(file_get_contents($_FILES['cover']['tmp_name']));
                    $image = 'data:image/' . $type . ';base64,' . $imageBase64;

                    if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_dir . $cover)) {
                        echo "Successfully uploaded file";
                    }
                }
            }
            if ($book->bookExistsInTable($title)) {
                die('Book already exists');
            }
            if ($book->add($data)) {
                header('Location: index');
                    //$this->view->render('home' . DIRECTORY_SEPARATOR . 'index');
            } else {
                echo "Something went wrong";
            }
        }
    }


    public function edit()
    {
        $book = new Book();
        $view = new View();

        $isbn = isset($_GET['isbn']) ? $_GET['isbn'] : null;
        //var_dump($book->getBook($isbn));
        $data = $book->getBook($isbn); //lodaj knjigu iz baze
        $this->view->render('book' . DIRECTORY_SEPARATOR . 'edit', $data);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
            $data = [
                'title' => $_POST['title'],
                'year' => $_POST['year'],
                'author' => $_POST['author'],
                'createdDate' => $_POST['createdDate'],
                'isbn' => $_POST['isbn']
            ];

            if ($book->edit($data)) {
                header('Location: index');
            } else {
                echo "Something went wrong";
            }
        }
    }

    public function delete()
    {
        $book = new Book();
        $view = new View();

        $isbn = isset($_GET['isbn']) ? $_GET['isbn'] : null;
        $data = $book->getBook($isbn);

        if ($book->delete($isbn)) {
            header('Location: index');
        } else {
            echo "Something went wrong";
        }
    }

    public function getMyBooks()
    {
        $book = new Book();
        $view = new View();

        $isbn = isset($_GET['book_id']) ? $_GET['book_id'] : null;
        //$data = $book->getBook($isbn);
        $data = $book->getMyBooks($isbn);
        var_dump($data);
        $this->view->render('book' . DIRECTORY_SEPARATOR . 'getMyBooks', $data);

        header('Location: getMyBooks');

    }

    public function borrow()
    {
        $book = new Book();
        $view = new View();

        $this->view->render('book' . DIRECTORY_SEPARATOR . 'borrow');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
              'book_id' => Request::post('book_id'),
              'user_id' => Request::post('user_id'),
            ];
            $date_rented = Request::post('date_rented');

            if ($book->borrowBook($data, $date_rented)) {
                header('Location: index');
            } else {
                echo "Something went wrong";
            }
        }
    }
}