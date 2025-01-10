@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<div class="container-fluid mt-5">

    <!-- row -->
    <div class="row column4 graph">
        <form id="registerForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
            class="form-style">
            <h2 class="text-center mb-5" style="color:#6c5b3e">Add Customer</h2>
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                        placeholder="Enter your first name">
                    @error('first_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>



                <div class="col-md-6 form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                        placeholder="Enter your last name">
                    @error('last_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Enter a password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" name="age" id="age" placeholder="Enter your age">
                    @error('age')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*"
                        onchange="previewImage(event)">
                    <div id="image_preview" style="margin-top: 10px;">
                        <!-- Image will be displayed here -->
                    </div>
                    @error('profile_picture')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <script>
                function previewImage(event) {
                    const file = event.target.files[0];
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const previewContainer = document.getElementById('image_preview');
                        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Profile Picture" style="max-width: 100%; height: auto;"/>`;
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                }
            </script>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" class="form-control" name="mobile" id="mobile"
                        placeholder="Enter your mobile number">
                    @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

    </div>
</div>






















@endsection