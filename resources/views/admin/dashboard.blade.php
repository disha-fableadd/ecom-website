@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')


<style>
    .heading1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    .view-products-btn {
        padding: 10px 20px;
        background-color: #214162;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 173px;
    }

    .view-products-btn1 {
        padding: 10px 20px;
        background-color: #214162;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 214px;
    }

    .view-products-btn3 {
        padding: 10px 20px;
        background-color: #214162;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 670px;
    }

    .view-products-btn:hover {
        background-color: #214162;
        color: white;
    }

    h2 {
        margin: 0;
    }
</style>
<div class="container-fluid">

    <div class="row column1 mt-5">
        <div class="col-md-6 col-lg-4">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <a href="{{route('users.index')}}"><i class="fa fa-user yellow_color"></i></a>

                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <p class="total_no">{{ $totalCustomers }}</p>
                        <p class="head_couter">Customers</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <a href="{{route('products.index')}}"> <i class="fa fa-briefcase blue1_color"></i></a>

                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <p class="total_no">{{ $totalProducts }}</p>
                        <p class="head_couter">Products</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <a href="{{route('orders.index')}}"> <i class="fa fa-clone green_color"></i></a>

                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <p class="total_no">{{ $totalOrders }}</p>
                        <p class="head_couter">Orders</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row column2 graph margin_bottom_30">
        <div class="col-md-6 col-lg-6">
            <div class="white_shd full">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Product Report </h2>
                        <a class="view-products-btn" href="{{route('products.index')}}"> View Products</a>
                    </div>
                </div>
                <div class="full graph_revenue">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <div class="area_chart">
                                    <canvas id="productChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="white_shd full">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Order Report</h2>
                        <a class="view-products-btn1" href="{{route('orders.index')}}"> View Ordes</a>
                    </div>
                </div>
                <div class="full graph_revenue">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <div class="area_chart">
                                    <canvas id="productOrderChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- graph -->
    <div class="row column2 graph margin_bottom_30">
        <div class="col-md-l2 col-lg-12">
            <div class="white_shd full">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Customers Report </h2>
                        <a class="view-products-btn3" href="{{route('users.index')}}"> View Customers</a>
                    </div>
                </div>
                <div class="full graph_revenue">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <div class="area_chart">
                                    <canvas id="userChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <div class="row column1 mt-5">
        <div class="col-md-6">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class=" d-flex heading1 margin_0">
                        <h2>Customers</h2>

                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table table-striped projects">
                                    <thead class="thead-dark text-center">
                                        <tr>

                                            <th>Profile_Picture</th>
                                            <th>Name</th>
                                            <th>Email</th>


                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($users as $index => $user)
                                            <tr>

                                                <td>
                                                    @if($user->profile_picture)
                                                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                            alt="Profile Picture"
                                                            style="width: 50px; height: 50px; border-radius: 50%;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <br>

                                <a href="{{ route('users.index') }}" class="btn btn-lg "
                                    style="background-color: #214162;color:white;float:right">All Customer</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="d-flex heading1 margin_0">
                        <h2> Products</h2>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table table-striped projects">
                                    <thead class="thead-dark text-center">
                                        <tr>

                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($products as $index => $product)
                                            <tr>

                                                <td>
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . json_decode($product->image)[0]) }}"
                                                            alt="Product Image"
                                                            style="width: 50px; height: 50px; border-radius: 5px;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>${{ number_format($product->price, 2) }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <a href="{{ route('products.index') }}" class="btn btn-lg "
                                    style="background-color: #214162;color:white;float:right">All Product</a>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>











</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('userChart').getContext('2d');
        const userChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        type: 'bar',
                        label: 'Customers',
                        data: @json($userCounts),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    },

                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Users'
                        },
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });


        //order chart

        const productCtx = document.getElementById('productOrderChart').getContext('2d');
        const productChart1 = new Chart(productCtx, {
            type: 'line',
            data: {
                labels: @json($labels),  // This will pass the labels (months) into the chart
                datasets: [
                    {
                        type: 'line',
                        label: 'Orders',
                        data: @json($orderCounts),  // This will pass the order counts into the chart
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        },
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                return value > 0 && Number.isInteger(value) ? value : '';
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });


        // product chart
        var productData = @json($productData);

        var allMonths = Array.from({ length: 12 }, (v, k) => k + 1);

        var months = allMonths.map(function (month) {
            return month;
        });

        var counts = months.map(function (month) {
            return productData[month] || 0;
        });

        // Array of month names
        var monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        var ctx1 = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: months.map(function (month) {
                    return monthNames[month - 1]; // Get the correct month name
                }),
                datasets: [{
                    data: counts,
                    backgroundColor: [
                        '#FFB3B3', '#B3FFB3', '#B3B3FF', '#FFEB99', '#FF9999', '#D1A7D9',
                        '#A8E6A1', '#A2C8E5', '#FFBB66', '#A3D5D1', '#BCC6D3', '#FFEC66'
                    ],
                    hoverBackgroundColor: [
                        '#FFB3B3', '#B3FFB3', '#B3B3FF', '#FFEB99', '#FF9999', '#D1A7D9',
                        '#A8E6A1', '#A2C8E5', '#FFBB66', '#A3D5D1', '#BCC6D3', '#FFEC66'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        // Display the legend items in a row
                        labels: {
                            boxWidth: 20, // Adjust size of legend box
                            padding: 10 // Add padding to space out legend items
                        },
                        // Set the legend to display in multiple rows if necessary
                        display: true,
                        align: 'center',
                        fullWidth: true,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' products';
                            }
                        }
                    }
                }
            }
        });

    });
</script>

@endsection