@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="text-success">Payment Successful!</h1>
    <p>{{ $message }}</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
</div>
@endsection
