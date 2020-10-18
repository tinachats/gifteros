<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Tinashe. M. Chaterera">
        <title>{{ $title ?? config('app.name', 'Gifteros')}}</title>
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
        <!-- Owl-Carousel -->
        <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel/dist/assets/owl.theme.default.min.css') }}">
        <!-- AnimatesCSS -->
        <link rel="stylesheet" href="{{ asset('plugins/animate.css/animate.min.css') }}">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <!-- iziToast -->
        <link rel="stylesheet" href="{{ asset('plugins/iziToast/css/iziToast.min.css') }}">
        <!-- SweetAlert -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/package/dist/sweetalert2.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
        <!-- DatePicker -->
        <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/gijgo.min.css') }}"/>
        <!-- RateYo -->
        <link rel="stylesheet" href="{{ asset('plugins/rateYo/jquery.rateyo.min.css') }}">
        <!-- Gifteros -->
        <link rel="stylesheet" href="{{ asset('css/gifteros.min.css') }}">
    </head>
    <body>
        <!-- Progress Indicator -->
        <div class="line">
            <div class="inner"></div>
        </div>
        <!-- /.Progress Indicator -->

        <!-- Main Content -->
        <div class="content mb-5 pb-5">
            <!-- Page Backdrop -->
            <div class="app-backdrop d-none"></div>

            <!-- Floating Action Buttons -->
            <div class="toggled-actions">
                <div class="floating-action bg-brick-red mb-3" title="System settings" onclick="userTheme()">
                    <i class="material-icons text-white m-auto">brightness_medium</i>
                </div>
                <div class="range-slider-settings">
                    <div class="floating-action bg-secondary mb-3" id="toggle-filters" title="Filter products">
                        <i class="material-icons text-white m-auto">tune</i>
                    </div>
                </div>
                <div class="floating-action bg-success mb-3" id="toggle-whatsapp" title="WhatsApp">
                    <i class="fa fa-whatsapp fa-2x text-white m-auto"></i>
                </div>
                <div class="floating-action bg-purple mb-3" onclick="topFunction()" title="Scroll to top">
                    <i class="material-icons text-white m-auto">arrow_upward</i>
                </div>
            </div>
            <div class="floating-action toggle-actions bg-primary" title="Click to toggle actions">
                <img src="{{ asset('img/app/gear.svg') }}" alt="" class="img-fluid m-auto">
            </div>
            <!-- /.Floating Action Buttons -->

            <!-- Header -->
            <header class="header fixed-top" id="header">
                <!-- Navbar -->
                <nav class="nav navbar-expand-md main-nav box-shadow-sm py-0 px-md-5">
                    <span role="button" class="material-icons menu-btn" title="Toggle Sidebar">menu</span>
                    <a href="/" class="navbar-brand font-700 ml-2">
                        <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" class="targets-logo" width="35" alt=""> 
                        <span class="mobile-brand brandname">{{ config('app.name') }}</span>
                    </a>
                    <ul class="navbar-nav mr-auto d-none d-md-flex">
                        <li class="nav-item dropdown">
                            <a class="nav-link text-sm font-600 mega-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Occasions</a>
                            <div class="dropdown-menu mega-menu box-shadow-sm">
                                <div class="container-fluid">
                                    <h4 class="display-5 my-2 font-600">Shop by Occasion</h4>
                                    <div class="categories-grid">
                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="anniversary-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=anniversary" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">anniversary</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=anniversary" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="birthday-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=birthday" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">Birthday</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=birthday" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="christmas-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=christmas" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">christmas</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=christmas" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="congrats-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=congrats" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">congrats</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=congrats" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="easter-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=easter" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">easter</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=easter" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="farewell-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=farewell" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">farewell</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=farewell" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="fathersday-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=fathers" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">father's day</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=fathers" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="getwell-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=getwell" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">get well</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=getwell" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="graduation-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=graduation" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">graduation</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=graduation" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="just-because-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=just because" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">just because</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=just because" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="mothersday-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=mothers" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">mother's day</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=mothers" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="newbaby-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=new-baby" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">new baby</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=new-baby" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="newhome-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=new-home" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">new home</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=new-home" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="newyear-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=new-year" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">new year</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=new-year" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="retirement-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=retirement" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">retirement</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=retirement" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="sympathy-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=sympathy" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">sympathy</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=sympathy" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="thanks-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=thanks" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">thank you</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=thanks" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="valentines-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=valentines" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">Valentine's</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=valentines" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="wedding-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=wedding" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">wedding</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=wedding" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->

                                        <!-- Occasion Card -->
                                        <div class="occasion-card d-grid" id="workplace-card">
                                            <div class="occassion-text m-auto">
                                                <a href="occasion.php?slug=workplace" class="d-flex align-items-center">
                                                    <h5 class="display-5 my-0 py-0 font-600 text-capitalize">workplace</h5>
                                                    <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                                </a>
                                                <a href="occasion.php?slug=workplace" class="stretched-link"></a>
                                            </div>
                                        </div>
                                        <!-- Occasion Card -->
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-none d-lg-inline">
                            <a class="nav-link text-sm font-600" href="/trending">Trending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-sm font-600" href="/deals">Hot Deals</a>
                        </li>
                    </ul>
                    <ul class="ml-auto justify-content-sm-around d-flex align-items-center m-0 p-0">
                        <li class="nav-item d-none d-md-flex" title="Select currency">
                            <div class="usd-price d-none nav-link font-600 navbar-text">
                                <div class="dropdown dropdown-toggle d-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                    <span class="usd-total text-color-switch">$0.00</span>
                                </div>
                                <div class="dropdown-menu currency-dropdown-menu box-shadow-sm dropdown-menu-right rounded-0">
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="usDollar()">
                                        <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">USD</span>
                                    </div>
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="zaRand()">
                                        <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">ZAR</span>
                                    </div>
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="zwBond()">
                                        <img src="{{ asset('img/app/zimflag.png') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">ZWL</span>
                                    </div>
                                </div>
                            </div>
                            <div class="zar-price d-none nav-link font-600 navbar-text">
                                <div class="dropdown dropdown-toggle d-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                    <span class="zar-total text-color-switch">R0.00</span>
                                </div>
                                <div class="dropdown-menu currency-dropdown-menu box-shadow-sm dropdown-menu-right rounded-0">
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="usDollar()">
                                        <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">USD</span>
                                    </div>
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="zaRand()">
                                        <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">ZAR</span>
                                    </div>
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="zwBond()">
                                        <img src="{{ asset('img/app/zimflag.png') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">ZWL</span>
                                    </div>
                                </div>
                            </div>
                            <div class="zwl-price d-none nav-link font-600 navbar-text">
                                <div class="dropdown dropdown-toggle d-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('img/app/zimflag.png') }}" height="15" width="22" alt="">
                                    <span class="zwl-total text-color-switch">$0.00</span>
                                </div>
                                <div class="dropdown-menu currency-dropdown-menu box-shadow-sm dropdown-menu-right rounded-0">
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="usDollar()">
                                        <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">USD</span>
                                    </div>
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="zaRand()">
                                        <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">ZAR</span>
                                    </div>
                                    <div class="dropdown-item d-flex align-items-center py-2" onclick="zwBond()">
                                        <img src="{{ asset('img/app/zimflag.png') }}" height="15" width="22" alt="">
                                        <span class="font-600 ml-1">ZWL</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Shopping Cart -->
                        <li class="nav-item dropdown ml-3">
                            <a href="#" class="nav-link icon-link" id="shopping-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">redeem</i>
                                <span class="badge nav-badge gift-count"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right rounded-0 box-shadow-sm cart-menu">
                                <div class="shopping-bag">
                                    <!-- Shopping Cart details will be shown here -->
                                </div>
                                <!-- Cart Subtotal -->
                                <li class="list-group-item rounded-0 lh-100 font-600 text-sm" id="cart-action-btns">
                                    <div class="usd-price">
                                        <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                            <span class="text-capitalize">Subtotal Amount:</span>
                                            <span class="usd-total"></span>
                                        </h6>
                                    </div>
                                    <div class="zar-price d-none">
                                        <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                            <span class="text-capitalize">Subtotal Amount:</span>
                                            <span class="zar-total"></span>
                                        </h6>
                                    </div>
                                    <div class="zwl-price d-none">
                                        <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                            <span class="text-capitalize">Subtotal Amount:</span>
                                            <span class="zwl-total"></span>
                                        </h6>
                                    </div>
                                    <div class="cart-action-btns">
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <button class="btn btn-warning btn-sm btn-block font-600 d-flex align-items-center justify-content-center clear-cart mr-1">
                                                <i class="material-icons mr-1">delete_sweep</i>
                                                Clear Cart
                                            </button>
                                            {{-- Checkout button will be show here --}}
                                        </div>
                                    </div>
                                </li>
                                <!-- /.Cart Subtotal -->
                            </ul>
                        </li>
                        <!-- /.Shopping Cart -->
                        @guest
                        <!-- Visitor -->
                        <li class="nav-item dropdown ml-3">
                            <div class="d-flex align-items-center d-cursor font-600 dropdown-toggle text-color-switch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Toggle Sign-in Form">
                                <i class="material-icons text-color-switch">person_outline</i>
                                <span class="ml-1 d-none d-md-inline text-color-switch">Account</span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right user-menu box-shadow-sm rounded-0 px-3" id="visitor-menu">
                                <div class="d-flex justify-content-center align-items-center text-skyblue font-600">
                                    <?= greetingIcon().greeting(); ?>
                                </div>
                                <p class="text-faded text-sm text-center font-600">
                                    Sign in for a personalized shopping experience.
                                </p>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                            
                                    <div class="form-group mb-1 pb-1">
                                        <label for="email" class="mb-0 font-600 text-sm">Email</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
                                        @enderror
                                    </div>
                            
                                    <div class="form-group mb-1 pb-1">
                                        <label for="password" class="mb-0 font-600 text-sm">Password</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="password">
                                        @error('password')
                                            <small class="invalid-feedback font-600" id="nameError">{{ $message }}</small>
                                        @enderror
                                    </div>
                            
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="custom-control custom-checkbox d-flex align-items-center">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">
                                                <small> {{ __('Remember Me') }}</small>
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-sm font-600">Forgot password?</a>
                                        @endif
                                    </div>
                            
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill lead font-600 btn-block">
                                        <span class="text-white">Sign in</span>
                                    </button>
                                </form>
                            
                                <div class="flex-column justify-content-center">
                                    <div class="division-block">
                                        <hr class="divider d-flex justify-content-center">
                                        <strong class="divider-title text-uppercase text-muted">or</strong>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center mt-0">
                                        <a role="button" href="" class="btn btn-outline-primary btn-sm social-login-btn" title="Sign-in with Facebook">
                                            <i class="fa fa-facebook text-primary-inverse"></i>
                                        </a>
                                        <a role="button" href="" class="btn btn-outline-primary btn-sm mx-3 social-login-btn" title="Sign-in with Google">
                                            <i class="fa fa-google text-primary-inverse"></i>
                                        </a>
                                        <a role="button" href="" class="btn btn-outline-primary btn-sm social-login-btn mr-3" title="Sign-in with Twitter">
                                            <i class="fa fa-twitter text-primary-inverse"></i>
                                        </a>
                                        <a role="button" href="" class="btn btn-outline-primary btn-sm social-login-btn" title="Sign-in with LinkedIn">
                                            <i class="fa fa-linkedin text-primary-inverse"></i>
                                        </a>
                                    </div>
                                </div>
                                <hr class="mb-0 pb-0">
                                <div class="d-flex align-items-center w-100 mb-2">
                                    Don't have an account? <a href="/register" class="ml-1 d-flex align-items-center">Sign-Up <i class="fa fa-caret-right ml-1"></i></a>
                                </div>
                            </div>
                        </li>
                        <!-- /.Visitor -->
                        @endguest

                        @auth
                            <!-- Signed-in User -->
                            <!-- Wishlist -->
                            <li class="nav-item dropdown ml-3" title="View your Wishlist">
                                <a href="wishlist.php" class="nav-link icon-link wishlist">
                                    <i class="material-icons">favorite_border</i>
                                    <span class="badge nav-badge" id="count-wishlist"></span>
                                </a>
                            </li>
                            <!-- /.Wishlist -->
                            <!-- Notifications -->
                            <li class="nav-item dropdown ml-3 notification-link">
                                <a href="#" class="nav-link icon-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons notifications">notifications_none</i>
                                    <span class="badge nav-badge notifications-counter"></span>
                                </a>
                                <div class="dropdown-menu notification-menu dropdown-menu-right rounded-0 box-shadow-sm" id="notifications">
                                <!-- Notifications will show up here -->
                                </div>
                            </li>
                            <!-- /.Notifications -->
                            <!-- Signed-in User -->
                            <li class="nav-item dropdown ml-3" title="Account Settings">
                                <img src="/storage/users/{{ Auth::user()->profile_pic }}" height="30" width="30" alt="{{ Auth::user()->name }}" class="rounded-circle prof-pic d-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="dropdown-menu dropdown-menu-right user-menu box-shadow-sm rounded-0">
                                    <div class="text-center pb-2">
                                        <label class="mb-0 d-cursor" for="profile-pic" onclick="triggerClick()">
                                            <img src="/storage/users/{{ Auth::user()->profile_pic }}" id="profile-image" class="rounded-circle mt-2 prof-pic" height="80" width="80" alt="{{ Auth::user()->name }}">
                                            <span role="button" class="fa fa-camera circled-icon"></span>
                                        </label>
                                        <input class="d-none" type="file" name="profile-pic" id="profile-pic" onchange="displayImg(this)" accept="image/*">
                                        <div class="d-block lh-100 rounded-0 mb-1" style="margin-top: -1rem">
                                            <h6 class="font-weight-bold mb-0 text-capitalize text-navy">
                                                {{ Auth::user()->name }}
                                            </h6>
                                            <small class="text-faded">
                                                {{ Auth::user()->email }}
                                            </small>
                                        </div>
                                    </div>
                                    <a class="dropdown-item border-top font-500" href="/account">
                                        <div class="d-flex align-items-center text-faded">
                                            <i class="nav-icon material-icons mr-3">person_outline</i> Account Settings
                                        </div>
                                    </a>
                                    <a class="dropdown-item font-500" href="/orders">
                                        <div class="d-flex align-items-center text-faded">
                                            <i class="nav-icon material-icons mr-3">local_shipping</i> My Orders
                                        </div>
                                    </a>
                                    <a class="dropdown-item font-500" href="/account#reviews">
                                        <div class="d-flex align-items-center text-faded">
                                            <i class="nav-icon material-icons mr-3">forum</i> My Reviews
                                        </div>
                                    </a>
                                    @if(Auth::user()->user_type === 'admin')
                                    <a class="dropdown-item font-500" href="/blog_posts/create">
                                        <div class="d-flex align-items-center text-faded">
                                            <i class="nav-icon material-icons mr-3">chat</i> My Blog Posts
                                        </div>
                                    </a>
                                    @endif
                                    <a class="dropdown-item font-500" href="wishlist.php">
                                        <div class="d-flex align-items-center text-faded">
                                            <i class="nav-icon material-icons mr-3">favorite_border</i> My Wishlist
                                        </div>
                                    </a>
                                    <a class="dropdown-item font-500" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <div class="d-flex align-items-center text-faded">
                                            <i class="nav-icon material-icons mr-3">power_settings_new</i> Sign Out
                                        </div>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf~
                                    </form>
                                </div>
                            </li>
                            <!-- /.Signed-in User -->
                        @endauth

                        <li class="nav-item d-md-flex" id="app-settings" title="See more settings">
                            <a class="toggle-settings nav-link material-icons">more_horiz</a>
                        </li>
                    </ul>
                </nav>
                <!-- /.Navbar -->

                <!-- Search Form -->
                <form method="post" id="search-form" class="bg-whitesmoke">
                    <div class="form-group icon-form-group" id="search-bar">
                        <i class="material-icons icon text-faded">search</i>
                        <input type="search" name="search" id="search" class="form-control" placeholder="What are you looking for?" onkeyup="searchItem(this)">
                        <ul class="list-group" id="search-list">
                            <!-- Search results will be shown here -->
                        </ul>
                    </div>
                </form>
                <!-- /.Search form -->

            </header>
            <!-- /.Header -->

        