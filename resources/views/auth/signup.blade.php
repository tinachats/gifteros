<?php 
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);
    if(!empty($GET['redirect'])){
        $_SESSION['redirect'] = $GET['redirect'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/app/visionaries-logo.png') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Material-Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/material-design-icons/iconfont/material-icons.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- AnimatesCSS -->
    <link rel="stylesheet" href="{{ asset('plugins/animate.css/animate.min.css') }}">
    <!-- iziToast -->
    <link rel="stylesheet" href="{{ asset('plugins/iziToast/css/iziToast.min.css') }}">
    <!-- Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/targets.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.min.css') }}">
    <style>
        .registration-box {
            width: 25rem;
        }
        
        .birth-date>select {
            color: #fff
        }
        
        .birth-date>i,#date, #month, #year{
            color: #fff !important
        }

        @media screen and (device-aspect-ratio: 40/71) {
            .form-control{
                width: 80% !important
            }
        }
        
        @media(max-width: 700px) {
            .justify-content-sm-center {
                justify-content: center;
            }
            .wrapper{
                margin-right: auto;
                margin-left: auto;
            }
            .terms-section{
                width: 80%;
            }
            .form-control, .custom-select{
                width: 93%
            }
        }
    </style>
</head>

<body class="account-page">
    <div class="container">
        <div class="wrapper">
            <div class="row align-items-md-center justify-content-md-between justify-content-sm-center m-auto">
                <div class="col-12 col-md-6 d-none d-md-block main-content">
                    <div class="row justify-content-center">
                        <a role="button" href="index.php" class="d-flex align-items-center text-white font-700 ml-2">
                            <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> 
                            <h3 class="display-5 font-600 text-white my-0 py-0 ml-1">Targets</h3>
                        </a>
                    </div>
                    <h5 class="lead lead-2x font-600 text-white mt-md-5">
                        Create a Targets customer account to get access to exclusive product deals.
                    </h5>
                    <p class="font-400 text-white">Get a personalized shopping experience from products and services near you.</p>
                    <div class="text-center">
                        <p class="font-500 text-white">Already have a Targets account?</p>
                        <a role="button" href="index.php?redirect=index.php" class="btn btn-sm btn-outline-light rounded-pill px-3 font-600">Sign in now</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 success-message d-none">
                    <div class="text-center">
                        <i class="material-icons text-success fa-3x">check_circle</i>
                        <h5 class="lead lead-2x font-600 text-white">Congratulations!</h5>
                        <p class="font-400 text-white">
                            Your account has been successfully created. You can now sign in and start sending
                            and receiving gifts with your friends.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="registration-box">
                        <!-- Progress Indicator -->
                        <div class="line w-100">
                            <div class="inner"></div>
                        </div>
                        <!-- /.Progress Indicator -->
                        <div class="account-box container-fluid p-3">
                            <h6 class="text-uppercase text-left font-600 mt-2">sign up</h6>
                            <form method="post" id="signup-form" action="{{ route('register') }}" class="needs-validation" novalidate>
                                @csrf
                                
                                <div class="form-group icon-form-group">
                                    <i class="material-icons text-white icon pl-1">person</i>
                                    <input type="text" name="name" id="name" class="form-control font-500 text-capitalize text-white @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group icon-form-group">
                                    <i class="material-icons text-white icon pl-1">email</i>
                                    <input type="email" name="email" id="email" class="form-control font-500 text-capitalize text-white @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <small class="invalid-feedback font-600" id="emailError">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group icon-form-group">
                                    <i class="material-icons text-white icon pl-1">phone_iphone</i>
                                    <input type="text" name="phone" id="phone" class="form-control font-500 text-capitalize text-white @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Your cell number" data-inputmask='"mask": "999999999999"' data-mask>
                                    @error('phone')
                                        <small class="invalid-feedback font-600" id="phoneError">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group icon-form-group">
                                    <i class="material-icons text-white icon pl-1">lock</i>
                                    <input type="password" name="password" id="password" class="form-control font-500 text-capitalize text-white @error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="password" placeholder="Password">
                                    @error('password')
                                        <small class="invalid-feedback font-600" id="passwordError">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group icon-form-group">
                                    <i class="material-icons text-white icon pl-1">lock</i>
                                    <input type="password" name="password-confirm" id="password-confirm" class="form-control font-500 text-capitalize text-white @error('password-confirm') is-invalid @enderror" value="{{ old('password-confirm') }}" required autocomplete="password" placeholder="Confirm Password">
                                    @error('password-confirm')
                                        <small class="invalid-feedback font-600" id="passwordError">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input text-primary" type="radio" name="gender" id="male" value="male">
                                    <label class="form-check-label text-white" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input text-primary" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label text-white" for="female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input text-primary" type="radio" name="gender" id="other" value="other">
                                    <label class="form-check-label text-white" for="other">Other</label>
                                </div>
                                <div class="d-flex align-items-center my-2">
                                    <div class="form-check toggle-switch">
                                        <input type="checkbox" class="form-check-input switch-btn" id="subscription" name="subscription" value="subscribed">
                                    </div>
                                    <span class="font-500 ml-2 text-white">Receive Newsletter</span>
                                </div>
                                <input type="hidden" name="action" value="create-account">
                                <input type="hidden" name="user-type" value="customer">
                                <div class="text-center mt-2">
                                    <button class="btn btn-primary font-500 text-uppercase px-3">Create an account</button>
                                </div>
                                <hr>
                                <div class="text-center my-1 terms-section">
                                    <p class="text-sm my-0 py-0 text-white">By clicking the "Create an Account" button you agree with our </p>
                                    <a class="text-sm" href="/terms">Terms & Conditions</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- iziToast -->
    <script src="{{ asset('plugins/iziToast/js/iziToast.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- Core JS -->
    <script src="{{ asset('js/account.min.js') }}"></script>
    <script>
        $('[data-mask]').inputmask();
    </script>
</body>

</html>