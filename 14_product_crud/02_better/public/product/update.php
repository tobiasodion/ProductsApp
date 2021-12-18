<?php

require_once('../../database.php');
require_once('../../functions.php');

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindParam(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];

if (empty($product)) {
    header('Location: index.php');
    exit;
}

$title = $product['title'];
$description = $product['description'];
$price = $product['price'];
$imagePath = $product['image'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../../validate_product.php');
    
    if (empty($errors)) {
        $statement = $pdo->prepare("UPDATE products SET title = :title, image = :image, description = :description , 
                                    price = :price WHERE id = :id");

        $statement->bindParam(':title', $title);
        $statement->bindParam(':image', $imagePath);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':id', $id);

        $statement->execute();

        header('Location: index.php');
    }
}
?>

<?php include '../../views/partials/header.php' ?>

<body class=container>
    <h1>Update Product</h1>
    <div>
        <a href="index.php" class="btn btn-success">Go back to Products</a>
    </div><br>

    <?php include_once('../../views/product/form.php'); ?>

</body>

</html>