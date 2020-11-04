<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\PrivateInterface;
use App\Core\Session;
use App\Core\View;
use App\Model\Book;
use App\Model\Borrow;

class BorrowController extends Controller implements PrivateInterface
{

    /*
    public function index()
    {
        $borrow = new Borrow();
        $view = new View();

        $isbn = isset($_GET['isbn']) ? $_GET['isbn'] : null;
        //$dataArr = [$borrow->getBorrowedBooks($isbn), $borrow->getUsersThoseWhoLate()];
        $data = $borrow->getBorrowedBooks($isbn);
        //var_dump($dataArr);
        /*
        foreach ($dataArr as $dataKeys => $dataValues) {
            $dataKeys = $dataValues;
        }
        echo $dataKeys['title'] . "<br>" . $dataKeys['firstname'] . "<br>" . $dataKeys['lastname'] . "<br>";
        */

        //var_dump($data);
        //$this->view->render('borrower' . DIRECTORY_SEPARATOR . 'index', $data);
}