<?php

include 'db.php';


$sql = "SELECT COUNT(DISTINCT product_id) AS total_products FROM cart";
$result = mysqli_query($conn, $sql);


if ($row = mysqli_fetch_assoc($result)) {

    echo json_encode(['total_products' => $row['total_products']]);
} else {

    echo json_encode(['total_products' => 0]);
}
?>
