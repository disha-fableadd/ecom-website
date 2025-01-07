@extends('admin-layout.app')
@section('title', 'Order Details')
@section('content')

<div class="container-fluid">
    <!-- row -->
    <div class="row column1 mt-5">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Order Details</h2>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <!-- Order and Customer Information -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_details margin_bottom_30">
                            <div class="contact_blog">
                                <h4 class="brief">Customer Information</h4><br>
                                <div class="contact_inner">
                                    <div class="left">
                                        <h3>{{ $order->first_name }} {{ $order->last_name }}</h3>
                                        <p><strong>Email:</strong> {{ $order->email }}</p>
                                        <p><strong>Phone:</strong> {{ $order->mobile }}</p>
                                        <p><strong>Address:</strong> {{ $order->address_line_1 }}, {{ $order->city }}, {{ $order->state }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Items in Order -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin_bottom_30">
                            <div class="contact_blog">
                                <h4 class="brief">Ordered Products</h4><br><br>
                                <div class="contact_inner">
                                    <table class="table table-striped projects">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                            <th style="width: 2%">No</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Product Image</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                    <td>
                                                        @if ($item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product Image" width="100" height="100">
                                                        @else
                                                            <img src="{{ asset('images/default-product.png') }}" alt="Default Product" width="100" height="100">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        

                        <div class="bottom_list">
                            <div class="right_button">
                                <a href="{{ route('orders.index') }}" class="btn btn-xs text-white" style="background-color:#15283c">
                                    <i class="fa fa-list"></i> Back To Order List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

@endsection
