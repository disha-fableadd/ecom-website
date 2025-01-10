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

</head>

<body class="inner_page error_404">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="error_page">
                    <div class="center">
                        <div class="error_icon">
                            <img class="img-responsive" src="{{asset('adminasset/images/layout_img/error.png')}}" alt="#">
                        </div>
                    </div>
                    <br>
                    <h3>PAGE NOT FOUND !</h3>
                    <P>YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</P>
                    <div class="center"><a class="main_bt" href="{{route('admin.dashboard')}}">Go To Home Page</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{asset('adminasset/js/jquery.min.js')}}"></script>
    <script src="{{asset('adminasset/js/popper.min.js')}}"></script>
    <script src="{{asset('adminasset/js/bootstrap.min.js')}}"></script>
    <!-- wow animation -->
    <script src="{{asset('adminasset/js/animate.js')}}"></script>
    <!-- select country -->
    <script src="{{asset('adminasset/js/bootstrap-select.js')}}"></script>
    <!-- nice scrollbar -->
    <script src="{{asset('adminasset/js/perfect-scrollbar.min.js')}}"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <!-- custom js -->
    <script src="{{asset('adminasset/js/custom.js')}}"></script>
</body>

</html>