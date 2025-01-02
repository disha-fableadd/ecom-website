@extends('layouts.app')

@section('content')

<!-- Product Details Start -->
<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img class="img-fluid" src="{{ asset('storage/' . $products->image) }}" alt="{{ $products->name }}" style="width: 500px;height:500px;">
        </div>
        
        <!-- Product Info -->
        <div class="col-md-6">
            <h2>{{ $products->name }}</h2>
            <p><strong>Description:</strong> {{ $products->description }}</p>
            <div class="d-flex justify-content-start">
                <h3>${{ $products->price }}</h3>
            </div>
            
            <!-- Rating Section -->
            <div class="product-rating mt-3">
                <h5>Customer Ratings:</h5>
                <div class="stars">
                @php
                        $rating = 4; // Example rating
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                    @endfor
                </div>
                <p>Based on 120 reviews</p>
            </div>
            @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
            
            <form action="{{ route('addToCart') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $products->id }}">
                <input type="hidden" name="user_id" value="{{ session('user') ? session('user')->id : 0 }}"> 
                <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
            </form>
            <h4 class="mt-3" style="font-size: 12px;">Share this product:</h4>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" class="btn btn-facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank" class="btn btn-twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com" target="_blank" class="btn btn-instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://pinterest.com" target="_blank" class="btn btn-pinterest"><i class="fab fa-pinterest"></i></a>
            </div>
            <br><br><br>
            <div id="message"></div>

        </div>
       
    </div>

    <!-- Extra Description & Reviews -->
    <div class="row mt-5">
        <div class="col-lg-12">
            <h4>Extra Information</h4>
            <p>Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet sit clita ea. Sanc invidunt ipsum et, labore clita lorem magna lorem ut. Erat lorem duo dolor no sea nonumy. Accus labore stet, est lorem sit diam sea et justo, amet at lorem et eirmod ipsum diam et rebum kasd rebum.</p>
        </div>
    </div>
    
    <!-- Customer Reviews -->
    <div class="row mt-5">
        <div class="col-lg-12">
            <h4>Customer Reviews</h4>
            <div class="review">
                <h5>John Doe</h5>
                <p style="color:#f39c12; font-size:18px"><strong style="color:black;font-size:14px">Rating:</strong> ★★★★☆</p>
                <p>This product is amazing! The quality is top-notch and it fits perfectly.</p>
            </div>
            <div class="review">
                <h5>Jane Smith</h5>
                <p style="color:#f39c12; font-size:18px"><strong style="color:black;font-size:14px">Rating:</strong> ★★★☆☆</p>
                <p>Good product, but the size was a bit smaller than expected. Still, a great buy!</p>
            </div>
        </div>
    </div>
    
</div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault(); 

        var form = $(this);
        var productId = form.find('input[name="product_id"]').val();
        var quantity = 1;

        $.ajax({
            url: '{{ route('addToCart') }}', 
            method: 'POST',
            data: form.serialize(), 
            dataType: "json",
            success: function(response) {
                $('#cartMessageModal').modal('show');

                if (response.status === 'success') {
                    $('#cartMessageBody').html('<div class="alert alert-success">' + response.message + '</div>');
                } else {
                    $('#cartMessageBody').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#cartMessageBody').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                $('#cartMessageModal').modal('show');
            }
        });
    });
});
</script>

@endsection
<div class="modal fade" id="cartMessageModal" tabindex="-1" role="dialog" aria-labelledby="cartMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartMessageModalLabel">Cart Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cartMessageBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{ route('cart.page') }}" class="btn btn-primary">Go to Cart</a>
      </div>
    </div>
  </div>
</div>


