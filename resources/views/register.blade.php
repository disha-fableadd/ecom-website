@extends('layouts.app')

@section('content')

<div class="container-fluid pt-5">
    <div class="row justify-content-center px-xl-5">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card border-0 shadow-lg p-4">
                <h3 class="mb-4">Register</h3>
                <form id="registerForm" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                @csrf    
                <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                placeholder="Enter your first name" >
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                placeholder="Enter your last name" >
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="col-md-6 form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter your email" >
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter a password" >
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="col-md-6 form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" name="age" id="age" placeholder="Enter your age"
                                >
                                @error('age')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                       
                        <div class="col-md-6 form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender" >
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="col-md-6 form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control" name="profile_picture" id="profile_picture"
                                accept="image/*">
                                @error('profile_picture')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                    
                        <div class="col-md-6 form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" id="mobile"
                                placeholder="Enter your mobile number" >
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                <div class="mt-4">
                    <p>Already have an account? <a href="{{ url('login') }}">Login here</a></p>
                </div>
            </div>
            <div id="message" class=""></div>
        </div>
    </div>
</div>

@endsection
