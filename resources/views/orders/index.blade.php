@extends('admin-layout.app')
@section('title', 'Orders')
@section('content')

<div class="container-fluid">
    <!-- row -->
    <div class="row column1 mt-5">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="d-flex heading1 margin_0">
                        <h2> Orders</h2>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table table-striped projects">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th style="width: 2%">No</th>
                                            <th>Customer Name</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($orders as $index => $order)
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                    <td>{{$item->quantity }}</td>
                                                    <td>${{ number_format($order->total, 2) }}</td>
                                                    <td>
                                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                      
                                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br><br>

                                <!-- Pagination links -->
                                <div class="d-flex justify-content-center">
                                    {{ $orders->links('pagination::bootstrap-5') }}
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
