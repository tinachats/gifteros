<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- Description of The Site for SEO --}}
        <meta name="description" content="{{ config('app.name') }} is the best online shop in Zimbabwe for buying gifts for any of relationship and for all occasions.">
        <meta name="author" content="Tinashe. M. Chaterera">
        <title>{{ $title ?? config('app.name', 'Gifteros')}}</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('img/app/visionaries-logo.png') }}" type="image/x-icon">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
        <!-- Bootstrap-Icons -->
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-icons-1.2.2/font/bootstrap-icons.css') }}">
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
                    {{-- Mobile Action Buttons --}}
                    <div class="d-md-none">
                        <div class="floating-action box-shadow-sm action-btn bg-purple to-top" onclick="scrollToTop()" title="Scroll to top">
                            <div class="m-auto d-flex flex-column justify-content-center lh-100">
                                <i class="material-icons text-white my-0">arrow_upward</i>
                                <small class="text-white font-600 my-0">Top</small>
                            </div>
                        </div>
                        <div class="floating-action box-shadow-sm action-btn bg-brick-red" title="Theme mode" onclick="userTheme()">
                            <i class="material-icons text-white m-auto">brightness_medium</i>
                        </div>
                        <div class="floating-action box-shadow-sm action-btn bg-success" id="toggle-whatsapp" title="WhatsApp">
                            <i class="fa fa-whatsapp fa-2x text-white m-auto"></i>
                        </div>
                        <div class="floating-action box-shadow-sm toggle-actions bg-primary" title="Click to toggle actions">
                            <i class="material-icons m-auto text-white">add</i>
                        </div>
                    </div>
                    {{-- /.Mobile Action Buttons --}}

                    {{-- Chat Icon --}}
                    <div class="d-sm-none d-md-block">
                        <div class="floating-action box-shadow-sm bg-primary" title="Click to toggle actions">
                            <i class="material-icons m-auto text-white">chat</i>
                        </div>
                    </div>
                    {{-- /.Chat Icon --}}
                </div>
                <!-- /.Floating Action Buttons -->

                {{-- Side Action Panel --}}
                <div class="d-sm-none d-md-block">
                    <div class="navigation-panel bg-meshgrid d-flex flex-column justify-content-around align-items-center">
                        <ul class="panel-lists d-flex flex-column align-items-center">
                            <li class="panel-icon w-100 py-1">
                                <a href="#" role="button" class="bi bi-geo-fill icon-md text-white" data-toggle="tooltip" data-placement="left" data-animation="true" data-delay="100" title="Trending In Your Area"></a>
                            </li>
                            <li class="panel-icon w-100 py-1">
                                <a href="#" role="button" class="bi bi-clock-history icon-md text-white" data-toggle="tooltip" data-placement="left" data-animation="true" data-delay="100" title="Viewed Gifts"></a>
                            </li>
                            <li class="panel-icon w-100 py-1">
                                <a href="#" role="button" class="bi bi-truck icon-md text-white" data-toggle="tooltip" data-placement="left" data-animation="true" data-delay="100" title="Track Your Order"></a>
                            </li>
                            <li class="panel-icon w-100 py-1">
                                <a href="#" role="button" class="bi bi-receipt icon-md text-white" data-toggle="tooltip" data-placement="left" data-animation="true" data-delay="100" title="Coupons"></a>
                            </li>
                        </ul>
                        <ul class="panel-lists d-flex flex-column align-items-center">
                            <li class="panel-icon w-100 py-1">
                                <a href="#" role="button" class="bi bi-share-fill icon-md text-white" data-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu sharing-menu pl-3">
                                    <li class="dropdown-menu-item d-flex align-items-center mb-2">
                                        <div class="social-login-btn bg-aqua" title="Share on Twitter">
                                            <i class="fa fa-twitter text-white"></i>
                                        </div>
                                        <span class="ml-1 text-sm">Twitter</span>
                                    </li>
                                    <li class="dropdown-menu-item d-flex align-items-center mb-2">
                                        <div class="social-login-btn bg-danger" title="Share on Instagram">
                                            <i class="fa fa-instagram text-white"></i>
                                        </div>
                                        <span class="ml-1 text-sm">Instagram</span>
                                    </li>
                                    <li class="dropdown-menu-item d-flex align-items-center mb-2">
                                        <div class="social-login-btn bg-primary" title="Share on Facebook">
                                            <i class="fa fa-facebook text-white"></i>
                                        </div>
                                        <span class="ml-1 text-sm">Facebook</span>
                                    </li>
                                    <li class="dropdown-menu-item d-flex align-items-center">
                                        <div class="social-login-btn bg-primary" title="Share on LinkedIn">
                                            <i class="fa fa-linkedin text-white"></i>
                                        </div>
                                        <span class="ml-1 text-sm">LinkedIn</span>
                                    </li>
                                </ul>
                            </li>
                            <li class="panel-icon w-100 py-1">
                                <a href="#" role="button" class="bi bi-question-circle icon-md text-white" data-toggle="tooltip" data-placement="left" data-animation="true" data-delay="100" title="Help and Feedback"></a>
                            </li>
                            <li class="panel-icon w-100 py-1 to-top">
                                <a href="#" role="button" class="bi bi-arrow-up-circle icon-md text-white" onclick="scrollToTop();" data-toggle="tooltip" data-placement="left" data-animation="true" data-delay="100" title="Back to Top"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- /.Side Action Panel --}}
