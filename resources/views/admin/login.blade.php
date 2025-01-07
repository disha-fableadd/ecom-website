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
    <title>admin panel</title>
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
    <!-- calendar file css -->
    <link rel="stylesheet" href="{{asset('adminasset/js/semantic.min.css')}}" />

    <style>
        .logo_login::after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            background: #D19C97;
            top: 0px;
            left: 0;
        }



        .login_section {
            max-width: 500px;
            background: #fff;
            min-height: 500px;
            width: 100%;
            box-shadow: 0px 0 10px -8px #000;
            margin: 0px;
            padding: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .login_form {
            padding: 50px 30px;
            float: left;
            width: 100%;
        }

        .login_form form .field label.label_field {
            margin: 0 30px 0 0;
            width: 115px;
            line-height: 45px;
            text-align: right;
            height: 45px;
            font-weight: 400;
            font-size: 15px;
            color: #6c5b3e;
        }

       

        .login_form form .field input {

            display: block;
            width: 400px;
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
    </style>
</head>

<body class="inner_page login">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="login_section">
                    <div class="logo_login">
                        <div class="center" style="font-size:50px">
                            <a href="" class="text-decoration-none">
                                <h1 class="m-0 display-5 font-weight-semi-bold" style="color:#6c5b3e;">
                                    <span class=" font-weight-bold border px-3 mr-1"
                                        style="color:#6c5b3e">E</span>Shopper
                                </h1>
                            </a>
                        </div>
                    </div>
                    <div class="login_form">
                        <form action="{{ route('admin.login.submit') }}" method="POST">
                            @csrf
                            <fieldset>
                                <div class="field">
                                    <label class="label_field" style="margin-left:35px;font-sizw:20px">Email Address
                                        :</label>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail" />
                                </div>
                                <div class="field">
                                    <label class="label_field">Password :</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Password" />
                                </div>
                                <div class="field">
                                    <label class="label_field hidden">hidden label</label>

                                    <a class="forgot" href="">Forgotten Password?</a>
                                </div>
                                <div class="field margin_0">
                                    <label class="label_field hidden">hidden label</label>
                                    <button class="main_bt" style="background-color:#D19C97">Sing In</button>
                                </div>
                            </fieldset>
                        </form>
                        
                    </div>
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