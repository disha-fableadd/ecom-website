<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);

    $sql = "INSERT INTO orders (first_name, last_name, email, mobile, address, zip_code, city, state, total) 
            VALUES ('$first_name', '$last_name', '$email', '$mobile', '$address', '$zip_code', '$city', '$state', '$total')";

    if (mysqli_query($conn, $sql)) {

        $order_id = mysqli_insert_id($conn);

        $delete_cart_sql = "DELETE FROM cart";
        if (mysqli_query($conn, $delete_cart_sql)) {
            echo json_encode(['success' => true, 'message' => 'Order placed successfully. Cart has been cleared.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Order placed, but cart clearing failed: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
    exit;
}
?>
