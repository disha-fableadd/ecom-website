@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<div class="container-fluid mt-5">

    <!-- row -->
    <div class="row column4 graph">
        <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form-style">
            <h2 class="text-center mb-5" style="color:#6c5b3e">Add Product</h2>
            @csrf
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="category">Category</label>
                    <input type="text" class="form-control" name="category" id="category" placeholder="Enter product category">
                    @error('category')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter product price">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

              
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter product description"></textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="image">Product Image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Product</button>
        </form>

    </div>
</div>

@endsection
