<?php

require_once('../../database.php');
require_once('../../functions.php');

$errors = [];

$title = '';
$description = '';
$price = '';
$imagePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../../validate_product.php');

    if (empty($errors)) {
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

<?php include '../../views/partials/header.php' ?>

<body class=container>
    <h1>Create new Product</h1>
    <div>
        <a href="index.php" class="btn btn-success">Go back to Products</a>
    </div><br>

    <?php include_once('../../views/product/form.php'); ?>

</body>

</html>