<?php 
require_once "model/BookModel1.php";

class BookController1 {
  public $model;

  public function __construct()
  {
     $this->model = new BookModel1;
  }

  public function execute() {
     //nếu người dùng click vào book id
     //thì render ra file bookDetail của book đấy
     if (isset($_GET['id'])) {
       $book = $this->model->getBookById($_GET['id']);
       require_once "view/bookDetail1.php";
     }

     //nếu người dùng không click 
     //lấy dữ liệu từ array trong file bookModel
     //và render ra file bookList (default)
     else {
        $bookList = $this->model->getBookList();
        require_once "view/bookList1.php";
     }
  }
}
?>