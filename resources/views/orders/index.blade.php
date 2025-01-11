@extends('admin-layout.app')
@section('title', 'Order Items')
@section('content')

<div class="container-fluid">
    <!-- row -->
    <div class="row column1 mt-5">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="d-flex heading1 margin_0">
                        <h2>All Order </h2>
                        <a href="{{ route('products.create') }}" class="btn btn-lg"
                        style="margin-left: 785px; background-color:#15283c; color:white">Add New Order</a>
                    </div>
                </div>

                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <form action="{{ route('orders.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search products"
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-lg"
                                            style="margin-left:4px;background-color:#15283c; color:white"
                                            type="submit">Search</button>
                                        <!-- Reset Button -->
                                        <a href="{{ route('orders.index') }}" class="btn btn-lg"
                                            style=" margin-left:5px;background-color:#d9534f; color:white;">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table table-striped projects">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th style="width: 2%">No</th>
                                            <th>Customer Name</th>
                                            <th>Order ID</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">
                                        @foreach($orderItems as $index => $item)
                                            <tr>
                                                <td>{{ ($orderItems->currentPage() - 1) * $orderItems->perPage() + $loop->iteration }}
                                                </td>

                                                <td>{{ $item->order->first_name }} {{ $item->order->last_name }}</td>
                                                <td>{{ $item->order_id }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                <td>

                                                    <a href="{{ route('orders.show', $item->order_id) }}"
                                                        class="btn btn-info btn-sm" title="View Order">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('orders.edit', $item->order_id) }}"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('orders.destroy', $item->order_id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this order?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br><br>

                                <!-- Pagination links -->
                                <div class="d-flex justify-content-center">
                                    {{ $orderItems->links('pagination::bootstrap-5') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>

@endsection