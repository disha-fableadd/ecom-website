<?php
include 'db.php';
session_start();

$sql = "SELECT cart.*, products.name, products.category, CAST(products.price AS DECIMAL(10, 2)) AS price, products.image 
        FROM cart 
        JOIN products ON cart.product_id = products.id";


$result = mysqli_query($conn, $sql);
$cartItems = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }
}

echo json_encode($cartItems);
?>
