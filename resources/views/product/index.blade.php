@extends('layouts.app')

@section('content')

<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Filter Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                <form method="GET" id="filter-form" action="{{ route('product.index') }}">
                    <div>
                        <input type="radio" id="price-all" name="price" value="all" 
                            {{ $price_filter === 'all' ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                        <label for="price-all">All Prices</label>
                    </div>
                    <div>
                        <input type="radio" id="price-1" name="price" value="0-100" 
                            {{ $price_filter === '0-100' ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                        <label for="price-1">$0 - $100</label>
                    </div>
                    <div>
                        <input type="radio" id="price-2" name="price" value="100-200" 
                            {{ $price_filter === '100-200' ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                        <label for="price-2">$100 - $200</label>
                    </div>
                    <div>
                        <input type="radio" id="price-3" name="price" value="200-300" 
                            {{ $price_filter === '200-300' ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                        <label for="price-3">$200 - $300</label>
                    </div>
                    <div>
                        <input type="radio" id="price-4" name="price" value="300-400" 
                            {{ $price_filter === '300-400' ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                        <label for="price-4">$300 - $400</label>
                    </div>
                </form>
            </div>
            <!-- Price Filter End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <!-- Search Form -->
                        <form method="GET" id="searchForm">
                            <div class="input-group">
                                <!-- Search Input -->
                                <input type="text" class="form-control" id="searchName" name="search" value="{{ $search_keyword }}" placeholder="Search by name">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden fields to keep price and category filters when submitting the form -->
                            <input type="hidden" name="price" value="{{ $price_filter }}">
                            <input type="hidden" name="category" value="{{ $sort_option }}">
                        </form>


                        <!-- Sort by Dropdown -->
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="?page=1&price={{ $price_filter }}&search={{ $search_keyword }}&sort=all_categories">All Categories</a>
                                @foreach ($categories as $category)
                                    <a class="dropdown-item" href="?page=1&price={{ $price_filter }}&search={{ $search_keyword }}&sort=category_{{ urlencode($category->category) }}">
                                        {{ $category->category }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Products -->
                @forelse ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid" style="height:300px;width:300px" src="{{ asset('storage/' . $product->image) }}" alt="Product">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>${{ $product->price }}</h6>
                                    </div>
                                </div>
                                <div class="card-footer mx-auto">
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm text-dark p-0">
                                        <i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                   
                                </div>
                            </div>
                        </div>
                        @empty
                       <p class='text-center mt-5'>No products found that match your filters.</p>
                        @endforelse
            </div>

            <!-- Pagination -->
            <div class="col-12 pb-1">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->


@endsection

@push('scripts')
<script>
    document.querySelectorAll('#filter-form input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });
    });
</script>
@endpush