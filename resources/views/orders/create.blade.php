@extends('admin-layout.app')
@section('content')
<style>

#orderFormContainer {
    display: none;
    transition: all 0.3s ease;
}


    /* General container */
    .container-fluid {
        margin-top: 30px;
    }

    /* Card styling */
    .card {
        border-radius: 8px;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e2e6ea;
    }

    .card-body {
        padding: 2rem;
    }

    /* Form elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        font-weight: bold;
    }

    select.form-control,
    input.form-control {
        height: 40px;
        font-size: 1rem;
    }

    /* Table styling */
    .table {
        border-radius: 8px;
        overflow: hidden;
        margin-top: 20px;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: center;
    }

    .table th {
        background-color: #214162;
        color: white;
    }

    .table td img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }

    /* Button styling */
    .btn {
        border-radius: 5px;

        font-size: 1rem;
    }

    .btn-primary {
        background-color: #15283c;
        border-color: #15283c;
    }

    .btn-primary:hover {
        background-color: #15283c;
        border-color: #15283c;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Grand Total Styling */
    .text-right {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .text-center .btn {
        width: 150px;
        padding: 0.6rem 0;
    }

    /* Alert message styles */
    .alert {
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #28a745;
        color: white;
    }

    .alert-danger {
        background-color: #dc3545;
        color: white;
    }

    /* Quantity Controls */
    .quantity-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-container input {
        width: 100px;
        text-align: center;
    }

    .quantity-container button {
        width: 30px;
        height: 30px;
        font-size: 1.2rem;
        margin: 0 5px;
    }

    .decreaseQty,
    .increaseQty {

        font-weight: bold;
    }

    /* Add Product Button */
    #add-more {
        margin-top: 10px;
        font-size: 1rem;
        padding: 0.8rem 1.6rem;
        width: 20%;
    }

    /* Order Item Row */
    #orderTable tbody tr {
        transition: background-color 0.2s ease;
    }

    #orderTable tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Create Order</h3>
                </div>
                <div class="card-body">
                    <form id="orderForm" method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <!-- Select Customer -->
                        <div class="form-group">
                            <label for="customer">Select Customer</label>
                            <select class="form-control" id="customer" name="customer" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->first_name }}
                                        {{ $customer->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product">Select Product</label>
                            <select class="form-control" id="product" name="product" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id  }}" data-price="{{ $product->price }}"
                                        data-image="{{  asset('storage/' . json_decode($product->image)[0]) }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Add More Button -->
                        <div class="form-group">
                            <button type="button" id="add-more" class="btn btn-primary">Add Product</button>
                        </div>

                        <!-- Order Table -->
                        <table class="table table-bordered" id="orderTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="orderTableBody">

                            </tbody>
                        </table>


                        <div class="text-right mt-3">
                            <strong>Grand Total: $<span id="grandTotal">0.00</span></strong>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" id="submitOrder" class="btn btn-primary">Submit Order</button>
                        </div>
                    </form>


                 


                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        function updateTotalPrice() {
            let grandTotal = 0;
            $('#orderTableBody tr').each(function () {
                grandTotal += parseFloat($(this).find('.totalPrice').text());
            });
            $('#grandTotal').text(grandTotal.toFixed(2));
        }

        function showMessage(message, type = 'danger') {
            const messageContainer = $('#messageContainer');
            if (messageContainer.length === 0) {
                // Create message container if it doesn't exist
                $('body').prepend(`<div id="messageContainer" class="alert alert-${type}">${message}</div>`);
            } else {
                messageContainer.removeClass('alert-danger alert-success').addClass(`alert alert-${type}`);
                messageContainer.text(message);
                messageContainer.show();
            }
            setTimeout(() => {
                messageContainer.hide();
            }, 6000);
        }

        $('#add-more').click(function () {
            const selectedProduct = $('#product').val();
            const selectedProductPrice = $('#product option:selected').data('price');
            const selectedProductName = $('#product option:selected').text();
            const selectedProductImage = $('#product option:selected').data('image');

            if (!selectedProduct) {
                showMessage('Please select a product before clicking Add More.');
                return;
            }

            const existingRow = $('#orderTableBody').find(`tr[data-product-id="${selectedProduct}"]`);

            if (existingRow.length > 0) {
                // Increase quantity if the product already exists
                const quantityInput = existingRow.find('.quantity');
                const currentQuantity = parseInt(quantityInput.val());
                const newQuantity = currentQuantity + 1;
                quantityInput.val(newQuantity);

                const newTotalPrice = (newQuantity * selectedProductPrice).toFixed(2);
                existingRow.find('.totalPrice').text(newTotalPrice);
            } else {
                // Add new row if product does not exist
                const row = `
        <tr data-product-id="${selectedProduct}">
            <td>${selectedProductName}</td>
            <td><img src="${selectedProductImage}" alt="${selectedProductName}" width="100" height="100"></td>
            <td>${selectedProductPrice}</td>
            <td class="quantity-container">
                <button type="button" class="btn btn-secondary btn-sm decreaseQty">-</button>
                <input type="number" class="form-control quantity" value="1" min="1" readonly>
                <button type="button" class="btn btn-secondary btn-sm increaseQty">+</button>
            </td>
            <td class="totalPrice">${selectedProductPrice}</td>
            <td><button type="button" class="btn btn-danger removeProduct">Remove</button></td>
        </tr>
    `;
                $('#orderTableBody').append(row);
            }

            updateTotalPrice();
            $('#product').val(''); // Clear the product dropdown
        });


        // Remove or decrease product quantity
        $(document).on('click', '.removeProduct', function () {
            const row = $(this).closest('tr');
            const quantityInput = row.find('.quantity');
            const quantity = parseInt(quantityInput.val(), 10);

            if (quantity > 1) {
                // Decrease the quantity by 1 if greater than 1
                quantityInput.val(quantity - 1);
                const price = parseFloat(row.find('td:nth-child(3)').text());
                row.find('.totalPrice').text(((quantity - 1) * price).toFixed(2));
            } else {
                // If quantity is 1, remove the row entirely
                row.remove();
            }

            updateTotalPrice();
        });

        // Increase product quantity
        $(document).on('click', '.increaseQty', function () {
            const row = $(this).closest('tr');
            const quantityInput = row.find('.quantity');
            const quantity = parseInt(quantityInput.val(), 10);
            const price = parseFloat(row.find('td:nth-child(3)').text());

            quantityInput.val(quantity + 1);
            row.find('.totalPrice').text(((quantity + 1) * price).toFixed(2));

            updateTotalPrice();
        });

        // Decrease product quantity
        $(document).on('click', '.decreaseQty', function () {
            const row = $(this).closest('tr');
            const quantityInput = row.find('.quantity');
            const quantity = parseInt(quantityInput.val(), 10);
            const price = parseFloat(row.find('td:nth-child(3)').text());

            if (quantity > 1) {
                quantityInput.val(quantity - 1);
                row.find('.totalPrice').text(((quantity - 1) * price).toFixed(2));
                updateTotalPrice();
            }
        });

      
   


    });
</script>






@endsection