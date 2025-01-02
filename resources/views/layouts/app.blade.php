

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-comm website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('admin/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<!-- Add Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <style>
        /* Basic reset for margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        /* Profile Container */
        .profile-container {
            width: 85%;
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Title */
        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
            color: #6c5b3e;
        }

        /* Profile Details */
        .profile-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 20px;
        }

        /* Profile Picture */
        .profile-picture {
            flex: 1;
            text-align: center;
        }

        .profile-picture img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #6c5b3e;
        }

        /* User Info */
        .user-info {
            flex: 2;
            margin-left: 20px;
        }

        .user-info p {
            font-size: 18px;
            margin-bottom: 15px;
            color: #555;
        }

        .user-info strong {
            font-weight: bold;
            color: #6c5b3e;
        }

        /* Edit Profile Button */
        .edit-button {
            display: inline-block;
            background-color: #6c5b3e;
            color: #fff;
            padding: 12px 25px;
            font-size: 18px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 30px;
        }

        .edit-button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        /* Input Fields */
        /* input[type="text"],
        input[type="email"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #6c5b3e;
            box-shadow: 0 0 8px rgba(108, 91, 62, 0.3);
        } */

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
        }

        /* Profile Picture Preview */
        .profile-picture-preview {
            margin-top: 20px;
            text-align: center;
        }

        .profile-picture-preview img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #6c5b3e;
            transition: transform 0.3s ease;
        }

        .profile-picture-preview img:hover {
            transform: scale(1.1);
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #D19C97;
            border-radius: 0;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .product-rating .stars i {
            color: #f39c12;
            font-size: 20px;
        }

        .review {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .review h5 {
            font-size: 15px;
            font-weight: 600;
        }

        .review p {
            font-size: 14px;
            color: #555;
        }

        .social-icons a {
            display: inline-block;
            font-size: 18px;
            color: #fff;
            border-radius: 100%;
            text-align: center;
        }

        .social-icons .btn-facebook {
            background-color: #3b5998;
        }

        .social-icons .btn-twitter {
            background-color: #00acee;
        }

        .social-icons .btn-instagram {
            background-color: #e4405f;
        }

        .social-icons .btn-pinterest {
            background-color: #e60023;
        }

        .social-icons a:hover {
            opacity: 0.8;
            color: white;
        }

        h4 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        h5 {
            font-size: 20px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container-fluid bg-light mb-5">
        <div class="row align-items-center py-3 px-xl-5">
            <!-- Logo -->
            <div class="col-lg-3 col-md-4">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper
                    </h1>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="col-lg-5">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                            <a href="{{route('product.index')}}" class="nav-item nav-link">Shop</a>
                            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-4 col-md-3 text-right d-flex justify-content-end align-items-center">
            <a href="{{ route('cart.page') }}" class="btn border mx-1">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge count text-dark">{{ $cartCount ?? 0 }}</span>
                </a>
                
                @if (session('user'))
                    @php
                        $user = session('user');
                    @endphp

                    @if ($user->profile_picture)
                        <a href="{{ route( 'user.profile') }}" class="btn  ">
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%;">
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary mx-1">Logout</button>
                        </form>
                    @else
                        <p>Complete your profile to upload a picture.</p>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary mx-1">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary mx-1">Register</a>
                @endif


                
               
            </div>
        </div>
    </div>
    @yield('content')
    @yield('script')
    @include('layouts.footer')