@extends('admin-layout.app')
@section('title', 'Edit Customer')
@section('content')

<div class="container-fluid mt-5">
    <div class="row column4 graph">
        <form id="registerForm" action="{{ route('users.update', $userr->id) }}" method="POST" enctype="multipart/form-data" class="form-style">
            @csrf
            @method('PUT') 
            <h2 class="text-center mb-5" style="color:#6c5b3e">Edit Customer</h2>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $userr->first_name) }}" placeholder="Enter your first name">
                    @error('first_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
                <div class="row">
                <div class="col-md-12 form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $userr->last_name) }}" placeholder="Enter your last name">
                    @error('last_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $userr->email) }}" placeholder="Enter your email">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" name="age" id="age" value="{{ old('age', $userr->age) }}" placeholder="Enter your age">
                    @error('age')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="gender">Gender</label>
                    <div class="form-control">
                        <label class="radio-inline mb-0">
                        <input type="radio" name="gender" value="Male" {{$userr->gender == 'Male' ? 'checked' : '' }} id="male"> Male
                        </label>
                        <label class="radio-inline mb-0">
                        <input type="radio" name="gender" value="Female" {{ $userr->gender == 'Female' ? 'checked' : '' }} id="female"> Female
                        </label>
                        <label class="radio-inline mb-0">
                        <input type="radio" name="gender" value="Other" {{ $userr->gender == 'Other' ? 'checked' : '' }} id="other"> Other
                        </label>
                    </div>
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile', $userr->mobile) }}" placeholder="Enter your mobile number">
                    @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            

            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
    </div>
</div>

@endsection
