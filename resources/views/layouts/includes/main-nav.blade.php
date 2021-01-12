@include('layouts.includes.header')
<!-- Header -->
<header class="header fixed-top box-shadow-sm">
    <div class="container">
        <!-- Main Navbar -->
        <nav class="nav navbar-expand-md main-nav">
            <!-- App logo -->
            <span role="button" class="material-icons menu-btn" title="Toggle Sidebar">menu</span>
            <a href="/" class="navbar-brand font-700 ml-2">
                <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" class="targets-logo" width="35" alt=""> 
                <span class="mobile-brand brandname">{{ config('app.name') }}</span>
            </a>
            <!-- /.App logo -->

            <!-- Left Navbar Links -->
            <ul class="navbar-nav mr-auto d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link text-sm font-600 mega-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Occasions</a>
                    <div class="dropdown-menu mega-menu box-shadow-sm rounded-2">
                        <div class="container-fluid">
                            <div class="categories-grid">
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="anniversary-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/anniversary_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">anniversary</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/anniversary_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="birthday-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/birthday_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">Birthday</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/birthday_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="christmas-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/christmas_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">christmas</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/christmas_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="congrats-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/congrats_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">congrats</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/congrats_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="easter-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/easter_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">easter</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/easter_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="farewell-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/farewell_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">farewell</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/farewell_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="fathersday-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/for_him" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">father's day</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/for_him" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="getwell-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/getwell_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">get well</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/getwell_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="graduation-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/graduation_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">graduation</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/graduation_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="just-because-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/because_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">just because</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/because_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="mothersday-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/for_her" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">mother's day</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/for_her" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="newbaby-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/baby_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">new baby</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/baby_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="newhome-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/home_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">new home</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/home_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="newyear-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/newyear_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">new year</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/newyear_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="retirement-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/retirement_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">retirement</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/retirement_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="sympathy-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/sympathy_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">sympathy</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/sympathy_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="thanks-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/thanks_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">thank you</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/thanks_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="valentines-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/valentines_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">Valentine's</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/valentines_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="wedding-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/wedding_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">wedding</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/wedding_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
    
                                <!-- Occasion Card -->
                                <div class="occasion-card d-grid" id="workplace-card">
                                    <div class="occassion-text m-auto">
                                        <a href="/category/workplace_gifts" class="d-flex align-items-center">
                                            <h5 class="display-5 my-0 py-0 font-600 text-capitalize">workplace</h5>
                                            <span class="fa fa-caret-right go-there display-5 ml-2"></span>
                                        </a>
                                        <a href="/category/workplace_gifts" class="stretched-link"></a>
                                    </div>
                                </div>
                                <!-- Occasion Card -->
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <a class="nav-link text-sm font-600" href="/category/trending_gifts">Trending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-sm font-600" href="/category/hot_deals">Hot Deals</a>
                </li>
            </ul>
            <!-- /.Left Navbar Links -->

            <!-- Right Navbar Links -->
            <ul class="ml-auto justify-content-sm-around d-flex align-items-center m-0 p-0">
                <li class="nav-item d-none d-md-flex" title="Select currency">
                    <div class="usd-price d-none nav-link font-600 navbar-text">
                        <div class="dropdown dropdown-toggle d-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                            <span class="usd-total text-color-switch">$0.00</span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2 currency-dropdown-menu">
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="usDollar()">
                                <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">USD</span>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="zaRand()">
                                <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">ZAR</span>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="zwBond()">
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
                        <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2 currency-dropdown-menu">
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="usDollar()">
                                <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">USD</span>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="zaRand()">
                                <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">ZAR</span>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="zwBond()">
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
                        <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2 currency-dropdown-menu">
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="usDollar()">
                                <img src="{{ asset('img/app/usflag.png') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">USD</span>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="zaRand()">
                                <img src="{{ asset('img/app/sa.jpg') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">ZAR</span>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2 cursor" onclick="zwBond()">
                                <img src="{{ asset('img/app/zimflag.png') }}" height="15" width="22" alt="">
                                <span class="font-600 ml-1">ZWL</span>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Shopping Cart -->
                <li class="nav-item dropdown ml-3">
                    <a href="#" class="nav-link icon-link" id="shopping-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-dropbox icon-md giftbox-empty"></i>
                        <i class="material-icons giftbox-filled d-none">redeem</i>
                        <span class="badge nav-badge gift-count"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right rounded-2 box-shadow-sm cart-menu mt-0 py-0">
                        <div class="shopping-bag rounded-2">
                            <!-- Shopping Cart details will be shown here -->
                        </div>
                        <!-- Cart Details -->
                        <li class="list-group-item w-100 lh-100 font-600 text-sm rounded-bottom-2" id="cart-action-btns">
                            <!-- Cart Subtotal -->
                            <div class="usd-price">
                                <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                    <span class="text-capitalize">Subtotal Amount:</span>
                                    <span class="usd-subtotal">US$0.00</span>
                                </h6>
                            </div>
                            <div class="zar-price d-none">
                                <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                    <span class="text-capitalize">Subtotal Amount:</span>
                                    <span class="zar-subtotal">R0.00</span>
                                </h6>
                            </div>
                            <div class="zwl-price d-none">
                                <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                    <span class="text-capitalize">Subtotal Amount:</span>
                                    <span class="zwl-subtotal">ZW$0.00</span>
                                </h6>
                            </div>
                            <!-- /.Cart Subtotal -->

                            <!-- Delivery charges -->
                            @if (session()->has('shipping_costs'))
                                <div class="usd-price">
                                    <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                        <span class="text-capitalize">Delivery Costs:</span>
                                        <span class="usd-delivery-cost">US${{ session()->get('shipping_costs')['usd_delivery_cost'] ?? 0 }}</span>
                                    </h6>
                                </div>
                                <div class="zar-price d-none">
                                    <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                        <span class="text-capitalize">Delivery Costs:</span>
                                        <span class="zar-delivery-cost">R{{ session()->get('shipping_costs')['zar_delivery_cost'] ?? 0 }}</span>
                                    </h6>
                                </div>
                                <div class="zwl-price d-none">
                                    <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                        <span class="text-capitalize">Delivery Costs:</span>
                                        <span class="zwl-delivery-cost">ZW${{ session()->get('shipping_costs')['zwl_delivery_cost'] ?? 0 }}</span>
                                    </h6>
                                </div>
                                <!-- /.Delivery Charges -->
                            @endif
                            <!-- /.Delivery Charges -->

                            <!-- Taxes & Discounts -->
                            @if (session()->has('coupon'))
                                <div class="usd-price">
                                    <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                        <span class="text-capitalize">Discount:</span>
                                        <span class="usd-discount">US${{ session()->get('coupon')['usd_value'] }}</span>
                                    </h6>
                                </div>
                                <div class="zar-price d-none">
                                    <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                        <span class="text-capitalize">Discount:</span>
                                        <span class="zar-discount">R{{ session()->get('coupon')['zar_value'] }}</span>
                                    </h6>
                                </div>
                                <div class="zwl-price d-none">
                                    <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                        <span class="text-capitalize">Discount:</span>
                                        <span class="zwl-discount">ZW${{ session()->get('coupon')['zwl_value'] }}</span>
                                    </h6>
                                </div>
                                <hr class="my-1">
                            @endif
                            <!-- /.Taxes & Discounts -->

                            <!-- Cart Total -->
                            <div class="usd-price">
                                <h6 class="font-600 d-flex justify-content-between align-items-center my-0 py-0">
                                    <span class="text-capitalize">Cart Total:</span>
                                    <span class="usd-total">US$0.00</span>
                                </h6>
                            </div>
                            <div class="zar-price d-none">
                                <h6 class="font-600 d-flex justify-content-between align-items-center my-0 py-0">
                                    <span class="text-capitalize">Cart Total:</span>
                                    <span class="zar-total">R0.00</span>
                                </h6>
                            </div>
                            <div class="zwl-price d-none">
                                <h6 class="font-600 d-flex justify-content-between align-items-center my-0 py-0">
                                    <span class="text-capitalize">Cart Total:</span>
                                    <span class="zwl-total">ZW$0.00</span>
                                </h6>
                            </div>
                            <!-- /.Cart Total -->

                            {{-- Hidden Inputs --}}
                            <input type="hidden" name="cart-usd-subtotal" id="cart-usd-subtotal">
                            <input type="hidden" name="cart-zar-subtotal" id="cart-zar-subtotal">
                            <input type="hidden" name="cart-zwl-subtotal" id="cart-zwl-subtotal">
                            <input type="hidden" name="cart-usd-total" id="cart-usd-total">
                            <input type="hidden" name="cart-zar-total" id="cart-zar-total">
                            <input type="hidden" name="cart-zwl-total" id="cart-zwl-total">
                            {{-- /.Hidden Inputs --}}

                            <!-- Action Buttons -->
                            <div class="cart-action-btns">
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <button class="btn btn-warning btn-sm btn-block font-600 d-flex align-items-center justify-content-center clear-cart mr-1">
                                        <i class="material-icons mr-1">delete_sweep</i>
                                        Clear Cart
                                    </button>
                                    @auth
                                        <a role="button" href="/checkout" class="btn btn-primary btn-sm btn-block font-600 d-flex align-items-center justify-content-center checkout-btn m-0">
                                            <i class="material-icons mr-1">directions_run</i> Checkout
                                        </a>
                                    @endauth
                                    @guest
                                        <a role="button" href="/login" class="btn btn-primary btn-sm btn-block font-600 d-flex align-items-center justify-content-center checkout-btn m-0">
                                            <i class="material-icons mr-1">directions_run</i> Checkout
                                        </a>
                                    @endguest
                                </div>
                            </div>
                            <!-- /.Action Buttons -->
                        </li>
                        <!-- /.Cart Details -->
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
                        <div class="dropdown-menu dropdown-menu-right user-menu box-shadow-sm rounded-2 px-3" id="visitor-menu">
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
                        <a href="{{ route('wishlist') }}" class="nav-link icon-link wishlist">
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
                        <div class="dropdown-menu notification-menu dropdown-menu-right rounded-2 box-shadow-sm" id="notifications">
                            <!-- Notifications will show up here -->
                        </div>
                    </li>
                    <!-- /.Notifications -->
                    <!-- Signed-in User -->
                    <li class="nav-item dropdown ml-3" title="Account Settings">
                        <img src="/storage/users/{{ Auth::user()->profile_pic }}" height="30" width="30" alt="{{ Auth::user()->name }}" class="rounded-circle prof-pic d-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right user-menu box-shadow-sm rounded-2">
                            <div class="text-center pb-2">
                                <form action="/profile_pic" method="post">
                                    @csrf
                                    <label class="mb-0 d-cursor" for="profile-pic" onclick="triggerClick()">
                                        <input class="d-none" type="file" name="profile-pic" id="profile-pic" onchange="displayImg(this)" accept="image/*">
                                        <img src="/storage/users/{{ Auth::user()->profile_pic }}" id="profile-image" class="rounded-circle mt-2 prof-pic" height="80" width="80" alt="{{ Auth::user()->name }}">
                                        <span role="button" class="fa fa-camera circled-icon"></span>
                                    </label>
                                </form>
                                <div class="d-block lh-100 rounded-0 mb-1" style="margin-top: -1rem">
                                    <h6 class="font-weight-bold mb-0 text-capitalize text-navy">
                                        {{ Auth::user()->name }}
                                    </h6>
                                    <small class="text-faded">
                                        {{ Auth::user()->email }}
                                    </small>
                                </div>
                            </div>
                            <a class="dropdown-item border-top font-500" href="/account/{{ username() }}">
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
                                @csrf
                            </form>
                            <div class="d-flex my-2 justify-content-center align-items-center">
                                <a href="/terms" class="text-faded text-sm">Privacy Policy</a>
                                <i class="fa fa-circle mx-2 text-faded text-xs"></i>
                                <a href="/terms" class="text-faded text-sm">Terms of Service</a>
                            </div>
                        </div>
                    </li>
                    <!-- /.Signed-in User -->
                @endauth
    
                <li class="nav-item d-md-flex ml-3" id="app-settings" title="See more settings">
                    <a class="toggle-settings nav-link icon-link material-icons">settings</a>
                </li>
            </ul>
            <!-- /.Right Navbar Links -->

            <!-- Search Form -->
            <form method="get" action="/search" id="search-form" class="bg-whitesmoke">
                <div class="form-group icon-form-group" id="search-bar">
                    <i class="material-icons icon text-faded">search</i>
                    <input type="search" name="search" id="search" class="form-control" placeholder="Search...">
                    <ul class="list-group search-list rounded-bottom-2 d-none">
                        @for ($i = 0; $i < 5; $i++)
                            <!-- Search results loading -->
                            <li class="list-group-item rounded-0 lh-100 px-1 py-2 cart-menu-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex w-100">
                                        <!-- Product Item -->
                                        <div class="media align-items-center">
                                            <div class="cart-item-img-placeholder rounded-2 align-self-center mr-2"></div>
        
                                            <!-- Product Item Details -->
                                            <div class="media-body cart-details-placeholder">
                                                <div class="content-placeholder cart-item-name-placeholder"></div>
                                                <div class="content-placeholder cart-category-placeholder"></div>
                                                <div class="cart-rating-placeholder content-placeholder"></div>
                                                <div class="content-placeholder cart-stock-placeholder"></div>
                                            </div>
                                            <!-- Product Item Details -->
                                        </div>
                                        <!-- /.Product Item -->
                                    </div>
                                    <div class="d-block text-center">
                                        <p class="content-placeholder my-0 pt-0 pb-1 cart-item-price"></p>
                                        <button class="btn btn-cart-placeholder pt-1"></button>
                                    </div>
                                </div>
                            </li>
                            <!-- /.Search Results Loading -->
                        @endfor
                        <!-- Search results will be shown here -->
                    </ul>
                </div>
            </form>
            <!-- /.Search Form -->
        </nav>
        <!-- Main Navbar -->
    </div>
</header>
<!-- /.Header -->