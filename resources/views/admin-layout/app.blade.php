<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="{{asset('adminasset/images/fevicon.png')}}" type="image/png" />
   <!-- bootstrap css -->
   <link rel="stylesheet" href="{{asset('adminasset/css/bootstrap.min.css')}}" />
   <!-- site css -->
   <link rel="stylesheet" href="{{asset('adminasset/css/style.css')}}" />
   <!-- responsive css -->
   <link rel="stylesheet" href="{{asset('adminasset/css/responsive.css')}}" />
   <!-- color css -->
   <link rel="stylesheet" href="{{asset('adminasset/css/colors.css')}}" />
   <!-- select bootstrap -->
   <link rel="stylesheet" href="{{asset('adminasset/css/bootstrap-select.css')}}" />
   <!-- scrollbar css -->
   <link rel="stylesheet" href="{{asset('adminasset/css/perfect-scrollbar.css')}}" />
   <!-- custom css -->
   <link rel="stylesheet" href="{{asset('adminasset/css/custom.css')}}" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


   <style>
      .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #15283c;
    border-color: #15283c;
}
      select.form-control:not([size]):not([multiple]) {
         height: calc(2.25rem + 10px);
      }

      .sidebar_toggle {
         border: none;
         padding: 12px 26px 14px;
         font-size: 21px;
         background: white;
         margin-right: 0;
         cursor: pointer;
         float: left;
         color: black;
      }

      #sidebar ul li a {
         padding: 15px 25px;
         display: block;
         font-size: 16px;
         color: #ffffff;
         font-weight: 300;
      }

      .icon_info ul.user_profile_dd>li {
         width: auto;
         border-radius: 0;
         background: white;
         margin: 0;
         padding: 12px 0 12px 20px;
         height: auto;
         color: black;
      }



      .topbar {
         position: fixed;
         width: 100%;
         padding-left: 280px;
         z-index: 2;
         background: white !important;
         top: 0;
         transition: ease all 0.3s;
         left: 0;
      }

      .topbar .navbar {
         padding: 0;
         background: white;
         border: none;
         border-radius: 0;
      }


      .form-style {
         width: 70%;
         margin: 0 auto;
         padding: 20px;

         border-radius: 8px;
         background-color: #f9f9f9;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .form-style .form-group {
         margin-bottom: 15px;
      }

      .form-style .form-control {
         padding: 10px;
         font-size: 14px;
         border-radius: 5px;
         border: 1px solid #D19C97;
      }

      .form-style .btn {
         padding: 12px;
         font-size: 16px;
         font-weight: bold;
         background-color: #15283c;
         color: #fff;
         border: none;
         border-radius: 5px;
      }

      .form-style .btn:hover {
         background-color: #15283c;
      }

      .form-style label {
         font-size: 14px;
         font-weight: bold;
      }

      .form-style .text-danger {
         font-size: 12px;
         color: #dc3545;
      }

      .form-style select.form-control {
         height: auto;
      }

      @media (max-width: 767px) {
         .form-style {
            padding: 10px;
         }

         .form-style .btn {
            padding: 10px;
         }
      }
   </style>
</head>

<body class="dashboard dashboard_1">
   <div class="full_container">
      <div class="inner_container">
         <!-- Sidebar  -->
         @include('admin-layout.sidebar')
         <!-- end sidebar -->
         <!-- right content -->
         <div id="content">
            <!-- topbar -->
            @include('admin-layout.header')
            <!-- end topbar -->
            <!-- dashboard inner -->
            <div class="midde_cont">

               @yield('content')
               @yield('script')
               @include('admin-layout.footer')