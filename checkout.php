<?php

include 'db.php';

$sql = "
    SELECT p.name, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.id ";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn)); // Output error if query failed
}

$total = 0;
$cart_items = [];

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
} else {
    echo "No products in the cart.";
}

mysqli_close($conn);

?>

<?php

include 'header.php';

?>


<form id="checkout-form">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" name="first_name" placeholder="Firstname" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" name="last_name" placeholder="Lastname" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="email" placeholder="example@email.com"
                                required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" name="mobile" placeholder="+123 456 789" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" name="address" placeholder="123 Street" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" name="zip_code" placeholder="123" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <select class="custom-select form-control" name="city" required>
                                <option selected>select City</option>
                                <option value="Surat">Surat</option>
                                <option value="Mumbai">Mumbai</option>
                                <option value="Rajkot">Rajkot</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <select class="custom-select form-control" name="state" required>
                                <option selected>select State</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Maharashtra">Maharashtra</option>
                            </select>
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
                            <p>' . $item['name'] . ' (' . $item['price'] . ') (' . $item['quantity'] . ')</p>
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
                        <button type="button" id="place-order"
                            class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Bootstrap Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<?php

include 'footer.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $("#place-order").click(function () {
            const formData = {
                first_name: $("input[name='first_name']").val(),
                last_name: $("input[name='last_name']").val(),
                email: $("input[name='email']").val(),
                mobile: $("input[name='mobile']").val(),
                address: $("input[name='address']").val(),
                zip_code: $("input[name='zip_code']").val(),
                city: $("select[name='city']").val(),
                state: $("select[name='state']").val(),
                total: <?php echo $total; ?> // Pass PHP variable to JS
            };

            $.ajax({
                url: "place_order.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {

                    $("#modalMessage").text(response.message);
                    $("#orderModal").modal('show');


                    if (response.success) {
                        setTimeout(function () {
                            window.location.href = "success.php";
                        }, 3000);
                    }
                },
                error: function () {
                    $("#modalMessage").text("An error occurred while placing the order.");
                    $("#orderModal").modal('show');
                }
            });
        });
    });
</script>



