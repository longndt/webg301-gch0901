<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book Detail</title>
   <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container col-md-5 text-center">
  <div class="row mt-4">
     <div class="col">
         <img src="<?= $book->image ?>" width="200" height="200">
     </div>
     <div class="col">
         <h1><?= $book->title ?></h1>
         <h2> Price : <?= $book->price ?> $ </h1>
         <h3> Quantity : <?= $book->quantity ?></h3>
     </div>
  </div>
</div>
</body>
</html>