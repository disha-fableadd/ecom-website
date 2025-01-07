@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<style>
    .contact_card {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .contact_inner {
        display: flex;
        justify-content: space-between;
    }

    .contact_inner .left {
        flex: 1;
        padding-right: 10px;
    }

    .contact_inner .right {
        flex: 0 0 150px;
    }

    .bottom_list {
        text-align: center;
        margin-top: 10px;
    }

    .right_button .btn {
        background-color: #007bff;
        color: #fff;
    }
</style>


<div class="container-fluid">

    <!-- row -->
    <div class="row column1 mt-5">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Product Information</h2>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <!-- column contact -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_details margin_bottom_30">
                            <div class="contact_blog">
                                <h4 class="brief">Product Info</h4>
                                <div class="contact_inner">
                                    <div class="left">
                                        <h3>{{ $product->name }}</h3>
                                        <p><strong>Category:</strong> {{ $product->category }}</p>
                                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                                        <p><strong>Description:</strong> {{ $product->description }}</p>
                                    </div>
                                    <div class="right">
                                        <div class="product_image">
                                            @if ($product->image)
                                                <img class="img-responsive"
                                                    src="{{ asset('storage/' . $product->image) }}"
                                                    alt="Product Image" width="150" height="150" />
                                            @else
                                                <img class="img-responsive" src="{{ asset('images/default-product.png') }}"
                                                    alt="Default Product" width="150" height="150" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom_list">
                                    <div class="right_button">
                                        <a href="{{ route('products.index') }}" class="btn  btn-xs"  style="background-color:#15283c">
                                            <i class="fa fa-list"></i>  Back To Product List
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end column contact blog -->

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- footer -->

@endsection
