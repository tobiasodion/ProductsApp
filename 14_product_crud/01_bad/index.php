<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search']??'';

if ($search){
  $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :search ORDER BY create_date DESC');
  $statement->bindValue(':search', "%$search%");
}

else{
  $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products CRUD</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="app.css">
</head>

<body class="container">
  <h1>Products CRUD</h1>
  <a href="create.php" type="button" class="btn btn-success">Create</a>

  <form action="" method="get">
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search for product" name="search">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $i => $product) { ?>
        <tr>
          <th scope="row"><?php echo $i + 1 ?></th>
          <td><img class="thumb-image" src="<?php echo $product['image'] ?>"></td>
          <td><?php echo $product['title'] ?></td>
          <td><?php echo $product['description'] ?></td>
          <td><?php echo $product['price'] ?></td>
          <td><?php echo $product['create_date'] ?></td>
          <td>
            <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sn btn-outline-success">Edit</a>
            <form style="display:inline-block" action="delete.php" method="post">
              <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
              <button type="submit" class="btn btn-sn btn-outline-danger" value="">Delete</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</body>

</html>

</html>