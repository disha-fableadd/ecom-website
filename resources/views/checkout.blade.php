@extends('layouts.app')

@section('content')

<form id="checkout-form" method="POST" action="{{ route('placeorder') }}">
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
                            <input class="form-control" type="text" name="address" placeholder="123 Street">
                            @error('address_line_1')
                            <div class="error-message" style="color: red;">{{ $message }}</div> @enderror
                        </div>
                        <!-- ZIP Code -->
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" name="zip_code" placeholder="123">
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

                    <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Cash On Delivery</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                    <button type="submit" id="place-order"
                    class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>
@endsection