@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<div class="container-fluid mt-5">

    <div class="row column4 graph">
        <form id="registerForm" action="" method="POST" enctype="multipart/form-data" class="form-style">
            <h2 class="text-center mb-5" style="color:#6c5b3e">Add Customer</h2>
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                        placeholder="Enter your first name">
                    <div id="first_name-error" class="text-danger">enter customer firstname</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                        placeholder="Enter your last name">
                    <div id="last_name-error" class="text-danger">enter customer lastname</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                    <div id="email-error" class="text-danger">enter email address</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Enter a password">
                    <div id="password-error" class="text-danger">enter password</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" name="age" id="age" placeholder="Enter your age">
                    <div id="age-error" class="text-danger">enter customer age</div>
                </div>

                <div class="col-md-6 form-group">
                    <label for="gender">Gender</label>
                    <div class="form-control">
                        <label class="radio-inline mb-0">
                            <input type="radio" name="gender" value="Male" id="male"> Male
                        </label>
                        <label class="radio-inline  mb-0">
                            <input type="radio" name="gender" value="Female" id="female"> Female
                        </label>
                        <label class="radio-inline mb-0">
                            <input type="radio" name="gender" value="Other" id="other"> Other
                        </label>
                    </div>
                    <div id="gender-error" class="text-danger">select the gender first</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*"
                        onchange="previewImage(event)">
                    <div id="image_preview" style="margin-top: 10px;  width: 20%;
        height: 15%;"></div>
                    <div id="profile_picture-error" class="text-danger">select the profile image</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" class="form-control" name="mobile" id="mobile"
                        placeholder="Enter your mobile number">
                    <div id="mobile-error" class="text-danger">enter customer mobile number</div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

    </div>
</div>

<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function() {
        // Initially hide all error messages
        $j('.text-danger').hide();

        // Handle form submission
        $j('#registerForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let formIsValid = true; // Assume form is valid initially

            // Validate each required field
            $j('#first_name, #last_name, #email, #password, #age, #gender, #mobile').each(function() {
                const field = $j(this); // Get current field
                const fieldId = field.attr('id'); // Get field's ID
                const errorDiv = $j('#' + fieldId + '-error'); // Corresponding error div

                // Clear any previous error for this field
                errorDiv.hide();

                // Check if the field is empty
                if (field.val().trim() === '') {
                    errorDiv.text('This field is required').show(); // Show error message
                    formIsValid = false; // Mark form as invalid
                }
            });

            // If form is valid, proceed with AJAX submission
            if (formIsValid) {
                const formData = new FormData(this); // Collect form data

                $j.ajax({
                    url: "{{ route('users.store') }}", // Replace with your form submission route
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "{{ route('users.index') }}"; // Redirect on success
                        } else {
                            if (response.errors) {
                                // Display server-side validation errors
                                $j.each(response.errors, function(field, messages) {
                                    $j('#' + field + '-error').html(messages.join('<br>')).show();
                                });
                            }
                        }
                    }
                });
            }
        });
    });

    // Preview uploaded image
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewContainer = document.getElementById('image_preview');
            previewContainer.innerHTML = `<img src="${e.target.result}" alt="Profile Picture" style="max-width: 100%; height: auto;"/>`;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>


@endsection