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
        <form id="productForm" action="" method="POST" enctype="multipart/form-data" class="form-style">
            <h2 class="text-center mb-5" style="color:#6c5b3e">Add Product</h2>
            @csrf
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name">
                    <div id="name-error" class="text-danger">enter product name</div>
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
                    <div id="category-error" class="text-danger">select category first</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter product price">
                    <div id="price-error" class="text-danger">enter product price</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                        placeholder="Enter product description"></textarea>
                    <div id="description-error" class="text-danger">enter description</div>
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
                    <div id="images-error" class="text-danger">select the image first</div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Product</button>
        </form>
    </div>
</div>

<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
        $j('.text-danger').hide();

        $j('#productForm').on('submit', function (event) {
            event.preventDefault(); 

            let formIsValid = true;

          
            $j('#name, #category, #price, #description, #images').each(function () {
                const field = $j(this);
                const fieldId = field.attr('id'); 
                const errorDiv = $j('#' + fieldId + '-error'); 

              
                errorDiv.hide();

                if (field.val().trim() === '') {
                    errorDiv.text('This field is required').show(); 
                    formIsValid = false;
                }
            });

            if (formIsValid) {
                const formData = new FormData(this);

                $j.ajax({
                    url: "{{ route('products.store') }}", 
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            window.location.href = "{{ route('products.index') }}"; 
                        } else {
                            if (response.errors) {
                                $j.each(response.errors, function (field, messages) {
                                    $j('#' + field + '-error').html(messages.join('<br>')).show();
                                });
                            }
                        }
                    }
                });
            }
        });
    });
    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('image-previews');

        previewContainer.innerHTML = '';

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function () {
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

                deleteBtn.addEventListener('click', () => {
                    const deletedImagesField = document.getElementById('deleted_images');
                    const deletedImages = deletedImagesField.value ? JSON.parse(deletedImagesField.value) : [];

                    const imageName = file.name;
                    deletedImages.push(imageName);

                    deletedImagesField.value = JSON.stringify(deletedImages);

                    wrapperDiv.remove();
                });

                wrapperDiv.appendChild(img);
                wrapperDiv.appendChild(deleteBtn);

                previewContainer.appendChild(wrapperDiv);
            };

            reader.readAsDataURL(file);
        });
    }

</script>

@endsection