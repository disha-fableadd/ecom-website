<?php

include 'db.php';

$order_id = 1; // Example order_id

// First SQL query to get order details
$sql = "SELECT * FROM orders WHERE order_id = $order_id";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn)); // Output error if query failed
}

// Check if the query returned any rows
if (mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    echo "No records found.";
}

// Second SQL query to get cart items
$sql = "
    SELECT p.name, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.id "; // Use $order_id to reference cart_id

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn)); // Output error if query failed
}

$total = 0;
$cart_items = [];

// Check if cart has products
if (mysqli_num_rows($result) > 0) {
    // Fetch all products and calculate the total
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
} else {
    echo "No products in the cart.";
}

// Close the connection
mysqli_close($conn);

?>



<?php

include 'header.php';
?>

<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <input class="form-control" type="text" placeholder="First Name"
                            value="<?php echo isset($order['first_name']) ? $order['first_name'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <input class="form-control" type="text" placeholder="Last Name"
                            value="<?php echo isset($order['last_name']) ? $order['last_name'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" placeholder="example@email.com"
                            value="<?php echo isset($order['email']) ? $order['email'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input class="form-control" type="text" placeholder="+123 456 789"
                            value="<?php echo isset($order['mobile_no']) ? $order['mobile_no'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input class="form-control" type="text" placeholder="Address"
                            value="<?php echo isset($order['address_line_1']) ? $order['address_line_1'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input class="form-control" type="text" placeholder="Address"
                            value="<?php echo isset($order['address_line_2']) ? $order['address_line_2'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <input class="form-control" type="text" placeholder="Country"
                            value="<?php echo isset($order['country']) ? $order['country'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input class="form-control" type="text" placeholder="City"
                            value="<?php echo isset($order['city']) ? $order['city'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input class="form-control" type="text" placeholder="State"
                            value="<?php echo isset($order['state']) ? $order['state'] : ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>ZIP Code</label>
                        <input class="form-control" type="text" placeholder="ZIP Code"
                            value="<?php echo isset($order['zip_code']) ? $order['zip_code'] : ''; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Products</h5>
                    <?php
                    foreach ($cart_items as $item) {
                        echo '<div class="d-flex justify-content-between">
                        <p>' . $item['name'] . '  (' . $item['price'].' )('.$item['quantity'] . ')</p>
                        <p>$' . number_format($item['price'] * $item['quantity'], 2) . '</p>
                      </div>';
                    }
                    ?>
                    <hr class="mt-0">
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">$<?php echo number_format($total, 2); ?></h5>
                    </div>
                </div>
            </div>
            <div class="card border-secondary mb-5">
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3 place-order">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->


<?php

include 'footer.php';

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.place-order').click(function () {
         
            var order_id = <?php echo $order_id; ?>; 

            $.ajax({
                url: 'place_order.php',
                type: 'POST',
                data: { order_id: order_id },
                success: function (response) {
                    // alert(response.message);
                    if (response.success) {
                        window.location.href = 'success.php';
                    }
                },
                error: function () {
                    alert('Error placing the order. Please try again.');
                }
            });
        });
    });
</script>




