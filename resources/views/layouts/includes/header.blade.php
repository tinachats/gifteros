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
        <div id="main-page-content">
            <div class="content mb-0 pb-0">
                <!-- Page Backdrop -->
                <div class="app-backdrop d-none"></div>

                <!-- Floating Action Buttons -->
                <div class="fabs d-flex align-items-center flex-column justify-content-around">
                    <div class="floating-action box-shadow-sm action-btn bg-brick-red" title="Theme mode" onclick="userTheme()">
                        <i class="material-icons text-white m-auto">brightness_medium</i>
                    </div>
                    <div class="floating-action box-shadow-sm action-btn bg-success" id="toggle-whatsapp" title="WhatsApp">
                        <i class="fa fa-whatsapp fa-2x text-white m-auto"></i>
                    </div>
                    <div class="floating-action box-shadow-sm action-btn bg-purple" onclick="topFunction()" title="Scroll to top">
                        <i class="material-icons text-white m-auto">arrow_upward</i>
                    </div>
                    <div class="floating-action box-shadow-sm toggle-actions bg-primary" title="Click to toggle actions">
                        <i class="material-icons m-auto text-white">add</i>
                    </div>
                </div>
                <!-- /.Floating Action Buttons -->
