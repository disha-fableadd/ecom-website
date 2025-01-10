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

                                <a href="{{ route('users.index') }}" class="btn btn-lg " style="background-color: #214162;color:white;float:right">All Customer</a>

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
                                                        <img src="{{ asset('storage/' .  json_decode($product->image)[0]) }}" alt="Product Image"
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
                                <a href="{{ route('products.index') }}" class="btn btn-lg " style="background-color: #214162;color:white;float:right">All Product</a>




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



        // product chart
        const productCtx = document.getElementById('productChart').getContext('2d');
        const productChart = new Chart(productCtx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        type: 'line',
                        label: 'Products',
                        data: @json($productCounts),
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
                            text: 'Number of Products'
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


        //order chart

        const productOrderCtx = document.getElementById('productOrderChart').getContext('2d');

        // Define dynamic colors, adding more as needed
        const colors = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)'
        ];

        // Dynamic dataset for products and counts fetched from the database
        const orderData = @json($orderData);  // Order data now in array format

        // Extract product names and counts
        const productNames = orderData.map(item => item.name);
        const productCounts = orderData.map(item => item.count);

        // Ensure we only provide as many colors as there are products
        const backgroundColors = productCounts.map((_, index) => colors[index % colors.length]);
        const borderColors = backgroundColors.map(color => color.replace('0.5', '1'));  // Border color slightly darker

        // Create the pie chart with dynamic data
        const productOrderChart = new Chart(productOrderCtx, {
            type: 'pie',
            data: {
                labels: productNames,  // Dynamic product names from the database
                datasets: [{
                    data: productCounts,  // Dynamic counts for each product from the database
                    backgroundColor: backgroundColors,  // Dynamic colors for slices based on available data
                    borderColor: borderColors,  // Slightly darker borders
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    });
</script>

@endsection