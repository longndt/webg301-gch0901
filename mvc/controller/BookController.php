<?php 
require_once "model/BookModel.php";

class BookController {
  public $model;

  public function __construct()
  {
     $this->model = new BookModel;
  }

  public function execute() {
     //nếu người dùng click vào book title
     //thì render ra file bookDetail của book đấy
     if (isset($_GET['title'])) {
       $book = $this->model->getBookByTitle($_GET['title']);
       require_once "view/bookDetail.php";
     }

     //nếu người dùng không click 
     //lấy dữ liệu từ array trong file bookModel
     //và render ra file bookList (default)
     else {
        $bookList = $this->model->getBookList();
        require_once "view/bookList.php";
     }
  }
}
?>