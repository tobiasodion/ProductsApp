<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$description = '';
$price = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = '';
    $date = date('Y-m-d H:i:s');

    if (!$title) {
        $errors[] = 'Product title is required!';
    }

    if (!$price) {
        $errors[] = 'Product price is required!';
    }

    if (!is_dir('images')){
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image']??null;
       
        if($image && $image['tmp_name']){
            $imagePath = 'images/'. rand(0000000, 9999999).'_'.date('Ymd_His/'). $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    

        $statement = $pdo->prepare("INSERT INTO products (title, image, description , price, create_date) 
                    VALUES (:title, :image , :description, :price, :create_date)");

        $statement->bindParam(':title', $title);
        $statement->bindParam(':image', $imagePath);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':create_date', $date);

        $statement->execute();

        header('Location: index.php');

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Create Product</title>
</head>

<body class=container>
    <h1>Create new Product</h1>
    <div>
        <a href="index.php" class="btn btn-success">Go back to Products</a>
    </div><br>

    <?php if (!empty($errors)){?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) { ?>
            <?php echo $error . '<br>'; ?>
        <?php } ?>
    </div>
    <?php } ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="Image">Product Image</label><br>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label for="Title">Product Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title?>">
        </div>

        <div class="form-group">
            <label for="Description">Product Description</label>
            <textarea class="form-control" name="description"><?php echo $description?></textarea>
        </div>

        <div class="form-group">
            <label for="Price">Product Price</label>
            <input type="text" step=".01" class="form-control" name="price" value="<?php echo $price?>">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</body>

</html>