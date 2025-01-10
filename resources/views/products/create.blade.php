@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<style>
    #image-preview {
        display: none;


    }

    #preview-img {
        width: 20%;
        height: 15%;
        border: 1px solid #ccc;
        margin-top: 10px;
    }
</style>
<div class="container-fluid mt-5">

    <!-- row -->
    <div class="row column4 graph">
        <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
            class="form-style">
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
                    <select class="form-control" name="category" id="category">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter product price">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                        placeholder="Enter product description"></textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="images">Product Images</label>
                    <!-- Image Previews Section -->
                    <div id="image-previews" class="mb-3"></div>
                    <input type="hidden" name="deleted_images" id="deleted_images">
                    <input type="file" class="form-control" name="images[]" id="images" accept="image/*" multiple
                        onchange="previewImages(event)">
                    @error('images')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <script>
                function previewImages(event) {
                    const files = event.target.files;
                    const previewContainer = document.getElementById('image-previews');

                    // Clear previous previews
                    previewContainer.innerHTML = '';

                    Array.from(files).forEach((file, index) => {
                        const reader = new FileReader();

                        reader.onload = function () {
                            // Create a wrapper div for each image preview
                            const wrapperDiv = document.createElement('div');
                            wrapperDiv.classList.add('image-preview-wrapper');
                            wrapperDiv.style.position = 'relative';
                            wrapperDiv.style.display = 'inline-block';
                            wrapperDiv.style.margin = '10px';

                            // Create an image element
                            const img = document.createElement('img');
                            img.src = reader.result;
                            img.alt = `Preview ${index + 1}`;
                            img.style.maxWidth = '150px';
                            img.style.height = 'auto';
                            img.style.border = '1px solid #ccc';
                            img.style.borderRadius = '5px';

                            // Create a delete button
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

                            // Attach delete functionality
                            deleteBtn.addEventListener('click', () => {
                                // Store the deleted image's filename
                                const deletedImagesField = document.getElementById('deleted_images');
                                const deletedImages = deletedImagesField.value ? JSON.parse(deletedImagesField.value) : [];

                                const imageName = file.name;  // This is just a placeholder, in your case, use the actual image path or filename
                                deletedImages.push(imageName);

                                deletedImagesField.value = JSON.stringify(deletedImages);

                                wrapperDiv.remove();  // Remove the image from preview
                            });

                            wrapperDiv.appendChild(img);
                            wrapperDiv.appendChild(deleteBtn);

                            previewContainer.appendChild(wrapperDiv);
                        };

                        reader.readAsDataURL(file);
                    });
                }

            </script>


            <button type="submit" class="btn btn-primary btn-block">Add Product</button>
        </form>

    </div>
</div>

@endsection