<?php

include 'db.php';


$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;


$product_id = intval($product_id);
$quantity = intval($quantity);


$query = "SELECT * FROM cart WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

    $cart = mysqli_fetch_assoc($result);
    $new_quantity = $cart['quantity'] + $quantity;


    $updateQuery = "UPDATE cart SET quantity = '$new_quantity' WHERE product_id = '$product_id'";
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to Update product.']);
    }
} else {

    $insertQuery = "INSERT INTO cart (product_id, quantity) VALUES ('$product_id', '$quantity')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(['status' => 'success', 'message' => 'Product Added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product.']);
    }
}


mysqli_close($conn);
?>
