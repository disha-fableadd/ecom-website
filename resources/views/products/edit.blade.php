@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<div class="container-fluid mt-5">

    <!-- row -->
    <div class="row column4 graph">
        <form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data" class="form-style">
            @csrf
            @method('PUT') <!-- Method spoofing for PUT request -->
            <h2 class="text-center mb-5" style="color:#6c5b3e">Update Product</h2>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name"
                        value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">Select a Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter product price"
                        value="{{ old('price', $product->price) }}">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                        placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

          <!-- Display old images if available -->
          <div class="row">
    <div class="col-md-12 form-group">
        <label for="image">Product Images</label>

        @if($product->image)
            @php
                $images = json_decode($product->image, true);
            @endphp
            @if(is_array($images))
                <div class="mb-3" style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @foreach($images as $image)
                        <div class="old-image" style="position: relative; display: inline-block; margin: 10px;">
                            <img src="{{ asset('storage/' . $image) }}" alt="Old Product Image"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                            <button type="button" class="delete-btn"
                                    data-image="{{ $image }}"
                                    style="position: absolute; top: 5px; right: 5px; background-color: #ff4d4d; color: white; border: none; border-radius: 3px; padding: 2px 5px; cursor: pointer;">
                                Delete
                            </button>
                            <input type="hidden" name="deleted_images[]" value="{{ $image }}" class="deleted-image-input">
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <!-- Input for new images with preview -->
        <input type="file" class="form-control" name="images[]" id="image" accept="image/*" multiple onchange="previewImages(event)">
        @error('images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div id="image-previews" class="mb-3"></div>

<script>
    // Handle deleting old images (only when the delete button is clicked)
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const imageInput = this.closest('.old-image').querySelector('.deleted-image-input');
            imageInput.value = this.getAttribute('data-image'); // Set the image to be deleted
            this.closest('.old-image').remove(); // Remove the image element from the page
        });
    });

    // Handle new image previews (and ensure delete button works correctly)
    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('image-previews');
        previewContainer.innerHTML = ''; // Clear existing previews

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function () {
                const wrapperDiv = document.createElement('div');
                wrapperDiv.classList.add('image-preview-wrapper');
                wrapperDiv.style.position = 'relative';
                wrapperDiv.style.display = 'inline-block';
                wrapperDiv.style.margin = '10px';

                const img = document.createElement('img');
                img.src = reader.result;
                img.alt = `Preview ${index + 1}`;
                img.style.maxWidth = '150px';
                img.style.height = 'auto';
                img.style.border = '1px solid #ccc';
                img.style.borderRadius = '5px';

                const deleteBtn = document.createElement('button');
                deleteBtn.textContent = 'Delete';
                deleteBtn.style.position = 'absolute';
                deleteBtn.style.top = '5px';
                deleteBtn.style.right = '5px';
                deleteBtn.style.backgroundColor = '#ff4d4d';
                deleteBtn.style.color = 'white';
                deleteBtn.style.border = 'none';
                deleteBtn.style.borderRadius = '3px';
                deleteBtn.style.padding = '2px 5px';
                deleteBtn.style.cursor = 'pointer';

                // Dynamically reattach the delete button event listener
                deleteBtn.addEventListener('click', () => {
                    wrapperDiv.remove(); // Remove the image preview when delete is clicked
                });

                wrapperDiv.appendChild(img);
                wrapperDiv.appendChild(deleteBtn);
                previewContainer.appendChild(wrapperDiv);
            };

            reader.readAsDataURL(file);
        });
    }
</script>


            <button type="submit" class="btn btn-primary btn-block">Update Product</button>
        </form>

    </div>
</div>

@endsection