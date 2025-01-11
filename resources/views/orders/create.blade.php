@extends('admin-layout.app')
@section('title', 'Create Order')
@section('content')

<div class="container-fluid mt-5">
    <div class="row column4 graph">
        <form id="orderForm" action="" method="POST" enctype="multipart/form-data" class="form-style">
            <h2 class="text-center mb-5" style="color:#6c5b3e">Create Order</h2>
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="customer_id">Customer</label>
                    <select class="form-control" name="uid" id="uid">
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" data-email="{{ $customer->email }}" data-mobile="{{ $customer->mobile }}">
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="uid-error" class="text-danger">selecrt customer first</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="product_id">Product</label>
                    <select class="form-control" name="product_id" id="product_id">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="product_id-error" class="text-danger">select product first</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Enter quantity" min="1">
                    <div id="quantity-error" class="text-danger">enter product quantity</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" readonly>
                    <div id="email-error" class="text-danger">enter email addresss</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" readonly>
                    <div id="mobile-error" class="text-danger">enter mobile number</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="address_line_1">Address Line 1</label>
                    <input type="text" class="form-control" name="address_line_1" id="address_line_1" placeholder="Enter address">
                    <div id="address_line_1-error" class="text-danger">enter address </div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="zip_code">Zip Code</label>
                    <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Enter zip code">
                    <div id="zip_code-error" class="text-danger">enter zip_code</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="city">City</label>
                    <select class="form-control" name="city" id="city">
                        <option value="">Select City</option>
                        <option value="surat">surat</option>
                        <option value="mumbai">mumbai</option>
                        <option value="rajkot">rajkot</option>
                    </select>
                    <div id="city-error" class="text-danger">select the city</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="state">State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
                        <option value="gujarat">gujarat</option>
                        <option value="maharashtra">maharashtra</option>
                    </select>
                    <div id="state-error" class="text-danger">select state</div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>

            <br><br>
            <input type="hidden" id="total_price" name="total">
            <p style="float:right">Total Price: <span id="display_price">0</span></p>
        </form>
    </div>
</div>

<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
      
        $j('.text-danger').hide();

    
        $j('#quantity').on('input', function () {
            const productId = $('#product_id');
            const selectedOption = productId.find('option:selected');
            const price = selectedOption.data('price') || 0;
            const quantity = $(this).val() || 0;
            const total = price * quantity;

            $j('#total_price').val(total);
            $j('#display_price').text(total.toFixed(2));
        });

       
        $j('#uid').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const email = selectedOption.data('email') || '';
            const mobile = selectedOption.data('mobile') || '';

            $('#email').val(email);
            $('#mobile').val(mobile);
        });

      
        $j('#orderForm').on('submit', function (event) {
            event.preventDefault();

            let formIsValid = true;

         
            $j('#uid, #product_id, #quantity, #email, #mobile, #address_line_1, #zip_code, #city, #state').each(function () {
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
                    url: "{{ route('orders.store') }}",
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
    });
</script>


@endsection
