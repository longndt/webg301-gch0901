<?php 
require_once "model/Book.php";

class BookModel {
   //create bookList array as table in database
   public $bookList;

   public function __construct()
   {
      $this->bookList = array(
        "Greenwich 1" => new Book("Greenwich 1",123.45,50,"https://d1csarkz8obe9u.cloudfront.net/posterpreviews/action-thriller-book-cover-design-template-3675ae3e3ac7ee095fc793ab61b812cc_screen.jpg"),
        "Greenwich 2" => new Book("Greenwich 2",99.56,60,"https://d1csarkz8obe9u.cloudfront.net/posterpreviews/contemporary-fiction-night-time-book-cover-design-template-1be47835c3058eb42211574e0c4ed8bf_screen.jpg?"),
        "Greenwich 3" => new Book("Greenwich 3",67.89,70,"https://mir-s3-cdn-cf.behance.net/project_modules/1400/f1284291229191.5e2c46564f4ff.jpg"),
      );
   }

   //return multiple books
   public function getBookList() {
      return $this->bookList;
   }

   //return single book by title
   public function getBookByTitle ($title) {
      $book = $this->bookList[$title];
      return $book;
   }




}

?>