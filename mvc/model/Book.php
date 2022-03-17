<?php 
class Book {
   //attributes - properties
   public $title;
   public $price;
   public $quantity;
   public $image;

   //methods - functions
   //constructor
   public function __construct($t, $p, $q, $i)
   {
      $this->title = $t;
      $this->price = $p;
      $this->quantity = $q;
      $this->image = $i;
   }

   //getter + setter (optional)
}
?>