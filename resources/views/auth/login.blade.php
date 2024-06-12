<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login - VelocityCo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    body {
        background: #f6f9fc;
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .account-block {
        padding: 0;
        background-image: url(https://bootdey.com/img/Content/bg1.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        height: 100%;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .account-block .overlay {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        position: absolute;
        top: 0;
        bottom: 0;
        left: -20px; /* Move 20px towards the left */
        right: 0;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .account-block .account-testimonial {
        text-align: center;
        color: #fff;
        padding: 0 1.75rem;
    }
    .text-theme {
        color: #5521b5 !important;
    }
    .btn-theme {
        background-color: #5521b5;
        border-color: #5521b5;
        color: #fff;
    }
    .container {
        max-width: 100%;
        padding: 0;
    }
    .row {
        height: 100vh;
        margin: 0;
    }
    .card {
        height: 100%;
    }
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .custom-col-lg-6 {
        padding: 0;
    }
</style>
</head>
<body>
<div id="main-wrapper" class="container-fluid">
    <div class="row no-gutters">
        <div class="col-lg-6 custom-col-lg-6 d-none d-lg-inline-block">
            <div class="account-block rounded-left">
                <div class="overlay rounded-left"></div>
                <div class="account-testimonial">
                    <img src="/front/img/logo4.png" alt="" height="250px" width="250px">
                    <h4 class="text-white mb-4">Velocity Co</h4>
                    <p class="lead text-white">"The cars we drive say a lot about us"</p>
                    <p>- Alexandra Paul</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 form-container">
            <div class="p-5 w-100">
                <div class="mb-5">
                    <h3 class="h4 font-weight-bold text-theme">Login</h3>
                </div>
                <h6 class="h5 mb-0">Welcome back!</h6>
                <p class="text-muted mt-2 mb-5">Enter your email address and password to access the dealership dashboard.</p>
                <div>
                    <x-validation-errors class="mb-4" />
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ isset($guard) ? url($guard.'/login') : route('login') }}">
                        @csrf
                        <div class="form-group">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>
                        <div class="form-group mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        </div>
                        <div class="form-group form-check mt-4">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            <button type="submit" class="btn btn-theme">{{ __('Log in') }}</button>
                        </div>
                    </form>
                </div>
                <p class="text-muted text-center mt-3 mb-0">Don't have an account? <a href="#" class="text-primary ml-1">Register</a></p>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
