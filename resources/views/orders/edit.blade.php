@extends('admin-layout.app')
@section('title', 'Edit Order')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="container-fluid mt-5">
    <div class="row column4 graph">
        <form id="orderForm" action="{{ route('orders.update', $order->id) }}" method="POST"
            enctype="multipart/form-data" class="form-style">

            <h2 class="text-center mb-5" style="color:#6c5b3e">Edit Order</h2>

            @csrf
            @method('PUT')

            <!-- Customer Info -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="uid">Customer</label>
                    <select class="form-control" name="uid" id="uid">
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" data-email="{{ $customer->email }}"
                                data-mobile="{{ $customer->mobile }}" @if($customer->id == $order->uid) selected @endif>
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="uid-error" class="text-danger">Select customer first</div>
                </div>
            </div>

            <!-- Product Info -->
            <div id="productRows">
                @foreach ($order->orderItems as $item)
                    <div class="row product-row">
                        <div class="col-md-6 form-group">
                            <input type="hidden" name="product_id[]" value="{{ $order->orderItems->first()->pid }}">
                            <label for="product_id">Product</label>
                            <select class="form-control product_id" name="product_id[]" id="product_id">
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        @if($product->id == $item->pid) selected @endif>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="product_id-error" class="text-danger">Select product first</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control quantity" name="quantity[]" id="quantity"
                                placeholder="Enter quantity" min="1" value="{{ $item->quantity }}">
                            <div id="quantity-error" class="text-danger">Enter product quantity</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="addProductRow" class="btn btn-secondary">Add Another Product</button>

            <br>
            <div id="product-error-message" class="text-danger" style="display: none; margin-top: 10px;">
                Please select a product before adding another one.
            </div>

            <!-- Customer Details (Email, Mobile, Address) -->
            <div class="row mt-4">
                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $order->email }}"
                        readonly>
                    <div id="email-error" class="text-danger">Enter email address</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ $order->mobile }}"
                        readonly>
                    <div id="mobile-error" class="text-danger">Enter mobile number</div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 form-group">
                    <label for="address_line_1">Address Line 1</label>
                    <input type="text" class="form-control" name="address_line_1" id="address_line_1"
                        value="{{ $order->address_line_1 }}" placeholder="Enter address">
                    <div id="address_line_1-error" class="text-danger">Enter address</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="zip_code">Zip Code</label>
                    <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{ $order->zip_code }}"
                        placeholder="Enter zip code">
                    <div id="zip_code-error" class="text-danger">Enter zip code</div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 form-group">
                    <label for="city">City</label>
                    <select class="form-control" name="city" id="city">
                        <option value="">Select City</option>
                        <option value="surat" @if($order->city == 'surat') selected @endif>Surat</option>
                        <option value="mumbai" @if($order->city == 'mumbai') selected @endif>Mumbai</option>
                        <option value="rajkot" @if($order->city == 'rajkot') selected @endif>Rajkot</option>
                    </select>
                    <div id="city-error" class="text-danger">Select the city</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="state">State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
                        <option value="gujarat" @if($order->state == 'gujarat') selected @endif>Gujarat</option>
                        <option value="maharashtra" @if($order->state == 'maharashtra') selected @endif>Maharashtra
                        </option>
                    </select>
                    <div id="state-error" class="text-danger">Select state</div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Update</button>

            <br><br>
            <input type="hidden" id="total_price" name="total">
            <p style="float:right">Total Price: <span id="display_price">{{ $order->total }}</span></p>
        </form>
    </div>
</div>




<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {

        $j('.text-danger').hide();

        function updateTotalPrice() {
            let totalPrice = 0;
            let productCount = 0;

            $j('.product-row').each(function () {
                const quantity = $(this).find('.quantity').val() || 0;
                const price = $(this).find('.product_id option:selected').data('price') || 0;
                const rowTotal = quantity * price;
                totalPrice += rowTotal;
                productCount++;
            });

            $j('#total_price').val(totalPrice);

            if (productCount > 0) {
                $j('#display_price').text(totalPrice.toFixed(2) + ' (Total for all products)');
            } else {
                $j('#display_price').text(totalPrice.toFixed(2));
            }

            if (productCount > 0 && totalPrice > 0) {
                $j('#display_price').show();
            } else {
                $j('#display_price').hide();
            }
        }

        $j(document).on('input', '.quantity', function () {
            updateTotalPrice();
        });

        $j(document).on('change', '.product_id', function () {
            updateTotalPrice();
        });

        $j('#uid').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const email = selectedOption.data('email') || '';
            const mobile = selectedOption.data('mobile') || '';

            $('#email').val(email);
            $('#mobile').val(mobile);
        });

        $j('#addProductRow').on('click', function () {
            let productSelected = false;

            $j('.product_id').each(function () {
                if ($(this).val() !== '') {
                    productSelected = true;
                }
            });

            if (!productSelected) {
                $j('#product-error-message').show();
                return;
            }

            $j('#product-error-message').hide();

            const newRow = `
        <div class="row mt-4 product-row">
            <div class="col-md-6 form-group">
                <label for="product_id">Product</label>
                <select class="form-control product_id" name="product_id[]" id="product_id">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                <div id="product_id-error" class="text-danger"></div>
            </div>

            <div class="col-md-6 form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control quantity" name="quantity[]" id="quantity"
                    placeholder="Enter quantity" min="1">
                <div id="quantity-error" class="text-danger"></div>
            </div>

            <!-- Remove Button -->
            <div class="col-md-12 form-group">
                <button type="button" class="btn btn-sm btn-danger remove-product-row" style=" padding: 2px;background-color:red; color: #fff; font-size:13px">Remove</button>
            </div>
        </div>
    `;
            $j('#productRows').append(newRow);
        });

        $j(document).on('click', '.remove-product-row', function () {
            $j(this).closest('.product-row').remove();
            updateTotalPrice();
        });

        $j('#orderForm').on('submit', function (event) {
    event.preventDefault();
    let formIsValid = true;

    // Validate all required fields
    $j('#uid, .product_id, .quantity, #email, #mobile, #address_line_1, #zip_code, #city, #state').each(function () {
        const field = $j(this);
        const fieldId = field.attr('id');
        const errorDiv = $j('#' + fieldId + '-error');

        errorDiv.hide();

        if (field.val().trim() === '') {
            errorDiv.text('This field is required').show();
            formIsValid = false;
        }
    });

    if (formIsValid) {
        const formData = new FormData(this);

        $j.ajax({
            url: "{{ route('orders.update', $order->id) }}",
            method: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    window.location.href = "{{ route('orders.index') }}";
                } else {
                    if (response.errors) {
                        $j.each(response.errors, function (field, messages) {
                            $j('#' + field + '-error').html(messages.join('<br>')).show();
                        });
                    }
                }
            },
        });
    }
});
        updateTotalPrice();
    });
</script>


@endsection