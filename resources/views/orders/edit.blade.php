@extends('admin-layout.app')
@section('title', 'Edit Order')
@section('content')

<div class="container-fluid mt-5">
    <div class="row column4 graph">
        <form id="orderForm" action="{{ route('orders.update', $order->id) }}" method="POST"
            enctype="multipart/form-data" class="form-style">
            <h2 class="text-center mb-5" style="color:#6c5b3e">Edit Order</h2>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="customer_id">Customer</label>
                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                        value="{{ old('customer_name', $order->user ? $order->user->first_name . ' ' . $order->user->last_name : '') }}"
                        readonly>
                    @error('customer_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="product_id">Product</label>
                    <input type="text" class="form-control" name="product_name" id="product_name"
                        value="{{ old('product_name', $orderItem ? $orderItem->product->name : '') }}" readonly>
                    @error('product_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity"
                        value="{{ old('quantity', $order->orderItems->first()->quantity ?? 1) }}"
                        placeholder="Enter quantity" min="1">
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $order->user ? $order->user->email : '') }}" readonly>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" name="mobile" id="mobile"
                        value="{{ old('mobile', $order->user ? $order->user->mobile : '') }}" readonly>
                    @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="address_line_1">Address Line 1</label>
                    <input type="text" class="form-control" name="address_line_1" id="address_line_1"
                        value="{{ old('address_line_1', $order->address_line_1) }}" placeholder="Enter address">
                    @error('address_line_1')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="zip_code">Zip Code</label>
                    <input type="text" class="form-control" name="zip_code" id="zip_code"
                        value="{{ old('zip_code', $order->zip_code) }}" placeholder="Enter zip code">
                    @error('zip_code')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="city">City</label>
                    <select class="form-control" name="city" id="city">
                        <option value="">Select City</option>
                        <option value="surat" @if($order->city == 'surat') selected @endif>surat</option>
                        <option value="mumbai" @if($order->city == 'mumbai') selected @endif>mumbai</option>
                        <option value="rajkot" @if($order->city == 'rajkot') selected @endif>rajkot</option>
                    </select>
                    @error('city')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="state">State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
                        <option value="gujarat" @if($order->state == 'gujarat') selected @endif>gujarat</option>
                        <option value="maharashtra" @if($order->state == 'maharashtra') selected @endif>maharashtra</option>
                    </select>
                    @error('state')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>

            <br><br>
            <input type="hidden" id="total_price" name="total">
            <p style="float:right">Total Price: <span id="display_price">{{ old('total', $order->total) }}</span></p>
        </form>
    </div>
</div>

<script>
    document.getElementById('quantity').addEventListener('input', function () {
        const price = {{ $orderItem->product->price ?? 0 }};  // Add logic to fetch price of selected product
        const quantity = this.value || 0;
        const total = price * quantity;

        document.getElementById('total_price').value = total;
        document.getElementById('display_price').innerText = total.toFixed(2);
    });
</script>

@endsection
