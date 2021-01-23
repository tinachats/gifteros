<div class="gift-categories">
    <div id="card-carousel" class="carousel slide carousel-fade" data-ride="carousel" data-delay="5000">
        <div class="carousel-inner">
            <div class="carousel-item active targets-banner">
                <a href="sub-category.php?id=41&slug=printed t-shirts" class="stretched-link">
                    <div class="showcase-item-content">
                        <h3>
                            <span class="display-3 font-weight-bold text-light animated animate-slow bounceInDown delay-1s">#trending</span>
                            <br>
                            <div class="ml-2 d-flex align-items-center text-light animated animate-slow fadeInUpBig">
                                Customized Couple Clothes 
                                <i class="fa fa-angle-right ml-1"></i>
                            </div>
                        </h3>
                        <h5 class="font-600 ml-2 animated animate-slow swing delay-2s">From only $16.99</h5>
                        <button class="btn btn-dark rounded-0 d-flex align-items-center justify-content-center px-5 font-600 animated animate-slow slideInUp delay-4s ml-2">
                            <span class="text-white">Shop now</span>
                            <i class="material-icons ml-1 text-white">keyboard_arrow_right</i>
                        </button>
                    </div>
                    <img src="{{ asset('img/backgrounds/couple-t-shirts.jpg') }}" class="d-block w-100 showcase-product-img">
                </a>
            </div>
            <div class="carousel-item targets-banner">
                <a href="sub-category.php?id=127&slug=Make-up Brushes">
                    <div class="showcase-item-content">
                        <h3>
                            <span class="display-3 font-weight-bold text-light animated animate-slow bounceInDown delay-1s">#killerlooks</span>
                        </h3>
                        <p class="text-justify lead text-white animated animate-slow delay-1s slideInRight w-75 ml-2">
                            Look amazing with these amazing eyelashes and makeup kits
                        </p>
                        <h2 class="display-5 ml-2 text-warning animated animate-slow delay-2s slideInLeft">Starting from $19.99</h2>
                        <button class="btn btn-dark rounded-0 d-flex align-items-center justify-content-center px-5 font-600 animated animate-slow bounceInDown delay-4s">
                            <span class="text-white">Shop now</span>
                            <i class="material-icons ml-1 text-white">keyboard_arrow_right</i>
                        </button>
                    </div>
                    <img src="{{ asset('img/backgrounds/changing-face.gif') }}" class="d-block w-100 showcase-product-img">
                </a>
            </div>
            <div class="carousel-item targets-banner">
                <a href="sub-category.php?id=130&slug=customized bracelets" class="stretched-link">
                    <div class="showcase-item-content">
                        <h3>
                            <span class="display-3 font-weight-bold text-light animated animate-slow bounceInDown delay-1s">#trending</span>
                            <br>
                            <div class="ml-2 d-flex align-items-center text-light animated animate-slow delay-1s slideInRight">
                                see more 
                                <i class="fa fa-angle-right ml-1"></i>
                            </div>
                        </h3>
                        <h5 class="display-5 ml-2 animated animate-slow delay-2s slideInLeft text-white">Customized Bracelets and Necklaces</h5>
                        <h5 class="font-600 ml-2 animated animate-slow delay-3s slideInRight">From only $15.99</h5>
                        <button class="btn btn-dark rounded-0 d-flex align-items-center justify-content-center px-5 font-600 animated animate-slow slideInUp delay-4s ml-2">
                            <span class="text-white">Shop now</span>
                            <i class="material-icons ml-1 text-white">keyboard_arrow_right</i>
                        </button>
                    </div>
                    <img src="{{ asset('img/backgrounds/gifted-couple.jpg') }}" class="d-block w-100 showcase-product-img">
                </a>
            </div>
            <div class="carousel-item">
                <a href="sub-category.php?id=79&slug=comforters">
                    <img src="{{ asset('img/backgrounds/comforters.jpg') }}" class="d-block w-100 showcase-product-img showcase-ad">
                    <p class="text-white showcase-overlay w-100 animated animate-slow slideInLeft delay-1s">
                        Get premium savings on this stylish yet luxurious cotton blend duvet set. 
                        This Urban Collection print style will produce a bold style in your room space.
                    </p>
                    
                </a>
            </div>
        </div>
    </div>
    {{-- Showcase trending gifts and Actions --}}
    <div class="action-bars w-100 d-md-none">
        @guest
            {{-- Sign In --}}
            <div class="box-shadow bg-whitesmoke my-2 p-2">
                <h5 class="text-faded">
                    Sign in for the best experience
                    <a href="/login" class="btn bg-switch btn-lg btn-block text-white my-2">
                        Sign in
                    </a>
                </h5>
                <a href="/register">Create an account</a>
            </div>
            {{-- Sign In --}}
        @endguest
    </div>
    {{-- /.Showcase trending gifts and Actions --}}
    <div class="supporting-cards">
        <div class="display-shelf">
            <a href="/category/for_her">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="{{ asset('img/backgrounds/FOR-HER.jpg') }}" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">For Her</h6>
                    </div>
                </div>
            </a>
            <a href="/category/for_him">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="{{ asset('img/backgrounds/FOR-HIM.jpg') }}" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">For Him</h6>
                    </div>
                </div>
            </a>
            <a href="/category/kid_gifts">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="{{ asset('img/backgrounds/FOR-KIDS.jpg') }}" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">For Kids</h6>
                    </div>
                </div>
            </a>
            <a href="/category/baby_gifts">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="{{ asset('img/backgrounds/FOR-BABIES.jpg') }}" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">For Babies</h6>
                    </div>
                </div>
            </a>
            <a href="/category/27/flowers" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/categories/flower-gifts.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Flowers</h6>
                    </div>
                </div>
            </a>
            <a href="/category/34/combo" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/categories/flowers-chocolates.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Combo Gifts</h6>
                    </div>
                </div>
            </a>
            <a href="/category/9/kitchenware" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/categories/kitchenware.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Kitchenware</h6>
                    </div>
                </div>
            </a>
            <a href="/category/25/customizable" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/categories/customized.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Customizable</h6>
                    </div>
                </div>
            </a>
            <a href="/category/confectioneries" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/sub-categories/668652163.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Sweet Treats</h6>
                    </div>
                </div>
            </a>
            <a href="/category/12/personal care" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/sub-categories/1087731911.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Personal Care</h6>
                    </div>
                </div>
            </a>
            <a href="/category/8/appliances" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/sub-categories/1591895958.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Appliances</h6>
                    </div>
                </div>
            </a>
            <a href="/category/trending_gifts" class="d-sm-inline d-md-none">
                <div class="category-card p-1 bg-whitesmoke">
                    <div class="text-center p-2">
                        <img src="/storage/sub-categories/810Oc47Sv7L._AC_UL320_.jpg" height="100" width="100" alt="">
                    </div>
                    <div class="text-center">
                        <h6 class="font-weight-bold">Trending</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
    