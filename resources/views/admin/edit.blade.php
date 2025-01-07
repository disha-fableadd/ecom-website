@extends('admin-layout.app')
@section('title', 'Edit Customer')
@section('content')

<div class="container-fluid mt-5">
    <div class="row column4 graph">
        <form id="registerForm" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="form-style">
            @csrf
            @method('PUT')  <!-- Method spoofing for PUT request -->
            <h2 class="text-center mb-5" style="color:#6c5b3e">Edit Customer</h2>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Enter your first name">
                    @error('first_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
                <div class="row">
                <div class="col-md-12 form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Enter your last name">
                    @error('last_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Enter your email">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" name="age" id="age" value="{{ old('age', $user->age) }}" placeholder="Enter your age">
                    @error('age')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 form-group">
                    <label for="gender">Gender</label>
                    <div class="form-control">
                        <label class="radio-inline mb-0">
                        <input type="radio" name="gender" value="male" {{$user->gender == 'male' ? 'checked' : '' }} id="male"> Male
                        </label>
                        <label class="radio-inline mb-0">
                        <input type="radio" name="gender" value="female" {{ $user->gender == 'female' ? 'checked' : '' }} id="female"> Female
                        </label>
                        <label class="radio-inline mb-0">
                        <input type="radio" name="gender" value="other" {{ $user->gender == 'other' ? 'checked' : '' }} id="other"> Other
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
                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile', $user->mobile) }}" placeholder="Enter your mobile number">
                    @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="image">Profile Picture</label>
                    @if($user->profile_picture)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Product Image" style="width: 150px; height: 150px; border-radius: 5px;">
                            <p>Current Image</p>
                        </div>
                    @endif
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            

            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
    </div>
</div>

@endsection
