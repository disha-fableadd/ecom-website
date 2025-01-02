@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <div class="d-flex justify-content-center align-items-center flex-column">
        <i class="fa fa-check-circle text-success" style="font-size: 100px;"></i>
        <h1 class="mt-4">Order Placed Successfully!</h1>
        <p class="mt-3">Thank you for your order.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
</div>
@endsection