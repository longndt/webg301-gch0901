<?php 
require_once "controller/BookController.php";

//khởi tạo 1 instance của Controller
$controller = new BookController();

//gọi đến hàm execute trong Controller để chạy web
$controller->execute();
?>