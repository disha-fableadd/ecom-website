@extends('layouts.app')


@section('content')

<div class="container-fluid pt-5">
    <div class="row justify-content-center px-xl-5">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="card border-0 shadow-lg p-4">
                <h3 class="text-center mb-4">Login</h3>
                <form id="loginForm" action="{{ url('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ url('register') }}">Register here</a></p>
                </div>
              

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection