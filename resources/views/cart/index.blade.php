@extends('layouts.app')

@section('content')
<div class="container-fluid pt-5" id="cartContainer">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            @if($cartCount > 0)
                    <table class="table table-bordered text-center mb-0 ordertable" id="cartTable">
                        <thead class="bg-secondary text-dark">
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
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->product->name }}</td>
                                    <td class="align-middle">
                                        <img src="{{ asset('storage/' . json_decode($item->product->image)[0])  }}" alt="{{ $item->product->name }}"
                                            width="50">
                                    </td>
                                    <td class="align-middle">{{ number_format($item->product->price, 2) }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-primary decrease-qty" data-id="{{ $item->id }}"
                                            data-qty="{{ $item->quantity }}"> <i class="fa fa-minus"></i></button>
                                        <span class="mx-2">{{ $item->quantity }}</span>
                                        <button class="btn btn-sm btn-primary increase-qty" data-id="{{ $item->id }}"
                                            data-qty="{{ $item->quantity }}"> <i class="fa fa-plus"></i></button>
                                    </td>
                                    <td class="align-middle">{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-primary remove-item" data-id="{{ $item->id }}"><i
                                                class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="col-lg-4" id="cartSummary">
                    <form class="mb-5" action="">
                        <div class="input-group">
                            <input type="text" class="form-control p-4" placeholder="Coupon Code">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Apply Coupon</button>
                            </div>
                        </div>
                    </form>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                        </div>

                        <div class="card-body">
                            <!-- Cart Items in Summary -->
                            <div id="cartItemsSummary">
                                @foreach ($cartItems as $item)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ $item->product->name }} ({{ $item->quantity }})
                                            ({{ $item->product->price }})</span>
                                        <span>{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <hr>

                            <!-- Grand Total -->
                            <div class="d-flex justify-content-between mt-2" id="grandTotalContainer">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold"><span id="grandTotal">0.00</span></h5>
                            </div>
                        </div>

                        <div class="card-footer border-secondary bg-transparent">
                            <!-- Checkout Button -->
                            <button class="btn btn-block btn-primary my-3 py-3" id="submitOrder">
                                <a href="{{ route('checkout') }}" style="color:white; text-decoration: none;"> Proceed
                                    To
                                    Checkout</a>
                            </button>
                        </div>
                    </div>
                </div>

            @else
                <div class="col-lg-12">
                    <div id="emptyCartMessage" style="text-align:center; margin: auto;">
                        <div class="text-center ">
                            <h4 class="text-muted mb-3">Your cart is empty.</h4>
                            <p class="text-muted mb-3">It looks like you haven't added anything to your cart yet.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.increase-qty', function () {
        const cartId = $(this).data('id');
        const quantity = $(this).data('qty') + 1;

        updateCart(cartId, quantity);
    });

    // Decrease quantity
    $(document).on('click', '.decrease-qty', function () {
        const cartId = $(this).data('id');
        const quantity = $(this).data('qty') - 1;

        if (quantity > 0) {
            updateCart(cartId, quantity);
        }
    });

    // Update cart quantity
    function updateCart(cartId, quantity) {
        $.ajax({
            url: '{{ route("updateCart") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                quantity: quantity
            },
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Failed to update quantity.');
                }
            }
        });
    }

    $(document).on('click', '.remove-item', function () {
        const cartId = $(this).data('id');

        if (confirm('Are you sure you want to remove this item from your cart?')) {
            $.ajax({
                url: '{{ route("removeItem") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: cartId
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to remove item.');
                    }
                }
            });
        }
    });

    function updateCartTotal() {
        let total = 0;

        $('#cartTable tbody tr').each(function () {
            const price = parseFloat($(this).find('td:nth-child(3)').text());
            const quantity = parseInt($(this).find('td:nth-child(4) span').text());

            total += price * quantity;
        });

        $('#grandTotal').text(total.toFixed(2));


    }

    $(document).ready(function () {
        updateCartTotal();
    });
</script>
@endsection