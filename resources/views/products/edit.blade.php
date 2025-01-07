@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<div class="container-fluid mt-5">

    <!-- row -->
    <div class="row column4 graph">
        <form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form-style">
            @csrf
            @method('PUT') <!-- Method spoofing for PUT request -->
            <h2 class="text-center mb-5" style="color:#6c5b3e">Update Product</h2>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="category">Category</label>
                    <input type="text" class="form-control" name="category" id="category" placeholder="Enter product category" value="{{ old('category', $product->category) }}">
                    @error('category')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter product price" value="{{ old('price', $product->price) }}">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Display current image if available -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="image">Product Image</label>
                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Current Product Image" style="width: 150px; height: 150px; border-radius: 5px;">
                            <p>Current Image</p>
                        </div>
                    @endif
                    <input type="file" class="form-control" name="image" id="image" accept="image/*">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Update Product</button>
        </form>

    </div>
</div>

@endsection
