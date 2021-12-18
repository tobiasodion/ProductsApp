<?php

require_once('../../database.php');

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
}

$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindParam(':id', $id);
$statement->execute();

header('Location: index.php');

?>