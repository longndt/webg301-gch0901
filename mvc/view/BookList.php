<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book List</title>
   <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container col-md-4 text-center">
<table class="table table-primary mt-4">
   <tr>
      <th>Book Title</th>
      <th>Book Price</th>
   </tr>
   <?php 
      foreach ($bookList as $book) {
   ?>  
         <tr>
            <td><?= $book->title ?></td>
            <td><?= $book->price ?> $ </td>
         </tr>
   <?php
      }
   ?>
</table>
</div>
</body>
</html>

