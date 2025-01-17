@extends('layouts.app')

@section('content')

<form id="checkout-form" method="POST" action="{{ route('processpayment') }}">
    @csrf
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" name="first_name"
                                value="{{ old('first_name', $user->first_name) }}" placeholder="Firstname">
                            @error('first_name')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" name="last_name"
                                value="{{ old('last_name', $user->last_name) }}" placeholder="Lastname">
                            @error('last_name')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- Email -->
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="email"
                                value="{{ old('email', $user->email) }}" placeholder="example@email.com">
                            @error('email')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- Mobile No -->
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" name="mobile"
                                value="{{ old('mobile', $user->mobile) }}" placeholder="+123 456 789">
                            @error('mobile')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- Address -->
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" name="address_line_1"
                                value="{{ old('address_line_1') }}" placeholder="123 Street">
                            @error('address_line_1')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- ZIP Code -->
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" name="zip_code" value="{{ old('zip_code') }}"
                                placeholder="123">
                            @error('zip_code')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- City -->
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <select class="custom-select form-control" name="city">
                                <option selected disabled>Select City</option>
                                <option value="Surat">Surat</option>
                                <option value="Mumbai">Mumbai</option>
                                <option value="Rajkot">Rajkot</option>
                            </select>
                            @error('city')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- State -->
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <select class="custom-select form-control" name="state">
                                <option selected disabled>Select State</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Maharashtra">Maharashtra</option>
                            </select>
                            @error('state')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        @foreach($cart_items as $item)
                            <div class="d-flex justify-content-between">
                                <p>{{ $item->product->name }} ({{ $item->quantity }}) ({{ $item->product->price }})</p>
                                <p>${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                        <hr>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between">
                                <h5>Total</h5>
                                <h5>${{ number_format($total, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal"
                                    value="paypal">
                                <label class="custom-control-label" for="paypal">PayPal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="stripe"
                                    value="stripe">
                                <label class="custom-control-label" for="stripe">Stripe</label>
                            </div>
                        </div>
                    </div>
                    <div id="paypal-payment" class="card-body" style="display:none;">
                        <!-- PayPal payment details/form can go here -->
                        <h5>PayPal Payment Details</h5>
                        <p>Please complete the payment via PayPal.</p>
                    </div>
                    <div id="stripe-payment" class="card-body" style="display:none;">
                        <!-- Stripe payment details/form can go here -->
                        <h5>Stripe Payment Details</h5>
                        <p>Please complete the payment via Stripe.</p>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" id="place-order"
                            class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                            Order</button>
                    </div>



                </div>

            </div>
        </div>
    </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paypalRadio = document.getElementById('paypal');
        const stripeRadio = document.getElementById('stripe');
        const paypalPayment = document.getElementById('paypal-payment');
        const stripePayment = document.getElementById('stripe-payment');

        // Hide both payment forms initially
        paypalPayment.style.display = 'none';
        stripePayment.style.display = 'none';

        // Show the PayPal form when PayPal is selected
        paypalRadio.addEventListener('change', function() {
            if (paypalRadio.checked) {
                paypalPayment.style.display = 'block';
                stripePayment.style.display = 'none';
            }
        });

        // Show the Stripe form when Stripe is selected
        stripeRadio.addEventListener('change', function() {
            if (stripeRadio.checked) {
                stripePayment.style.display = 'block';
                paypalPayment.style.display = 'none';
            }
        });
    });
</script>

@endsection