<!doctype html>
<html lang="en">
<head>
    <title>Login to your account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('template/landwind-main/css/style.css') }}">
    <style>
        body{
            background-image: url("{{ asset('template/landwind-main/images/pexels-pixabay-315938.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            overflow: hidden;
        }
        .container {
         transform: translateY(-40px);
         background-color: rgba(255, 255, 255, 0.6); /* white background with 50% opacity */
         border-radius: 10px; /* rounded corners */
         max-width: 60%; /* not covering the full page in width */ 
         margin-top: 0px; /* center the box */
         padding: 20px; /* space around the content */
         /* other styles */
     }
     .form-control{
        border: 1px solid black;
        -webkit-text-fill-color: black;
     }
     .btn-signin {
       background-color: #9061f9;
       border-color: #9061f9;   
   }
   .checkbox-wrap .checkbox-primary{
    color: #9061f9;
    -webkit-text-fill-color: black;
   }
   .checkbox-wrap .checkbox-primary label a{
    color: white;
 }  

 .checkbox-wrap input[type="checkbox"] {
    background-color: black;
 }
    </style>
</head>
<body class="img js-fullheight">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
                <img src="{{ asset('template/landwind-main/images/logo2.png') }}" alt="logo" width="200px" height="200px" class="heading-section">
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <h3 class="mb-4 text-center">Log In to your Account</h3>
                    <form method="POST" action="{{ route('login') }}" class="signin-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" name="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group" style="display: flex; justify-content: center;">
                            <button type="submit" class="sign-in-btn">Sign In</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
                                <label>Remember Me
                                    <input type="checkbox" name="remember">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="{{ route('password.request') }}" style="color: #fff">Forgot Password</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('template/landwind-main/js/jquery.min.js') }}"></script>
<script src="{{ asset('template/landwind-main/js/popper.js') }}"></script>
<script src="{{ asset('template/landwind-main/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/landwind-main/js/main.js') }}"></script>
</body>
</html>