<?php 
require_once "controller/BookController1.php";

//khởi tạo 1 instance của Controller
$controller = new BookController1();

//gọi đến hàm execute trong Controller để chạy web
$controller->execute();
?>