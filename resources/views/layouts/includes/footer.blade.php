       <!-- Main Sidebar -->
        @include('layouts.includes.sidebar')
        <!-- /.Main Sidebar -->

        <!-- Settings Sidebar -->
        @include('layouts.includes.settings')
        <!-- /.Setting Sidebar -->
        </div>
        <!-- /.Main Content -->

        <!-- Comparing Panel -->
        <div class="comparison-pane d-none mt-2">
            <span role="button" class="material-icons" id="close-panel" title="Close panel">keyboard_arrow_down</span>
            <div class="compare-panel">
                <form action="" class="compare-products" method="post" id="compare-form">
                    <!-- Placeholder Product Pane -->
                    <div class="product-pane empty box-shadow-sm">
                        <div class="empty-content text-center p-2">
                            <p class="text-sm mb-0 pb-0 text-white">
                                Add product to compare
                            </p>
                            <div class="row justify-content-center">
                                <div class="d-flex align-items-center text-white rounded-0 mt-1">
                                    <i class="material-icons mr-1">compare_arrows</i> Compare
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.Placeholder Product Pane -->
                    <!-- Placeholder Product Pane -->
                    <div class="product-pane empty box-shadow-sm">
                        <div class="empty-content text-center p-2">
                            <p class="text-sm mb-0 pb-0 text-white">
                                Add another product
                            </p>
                            <div class="row justify-content-center">
                                <div class="d-flex align-items-center text-white rounded-0 mt-1">
                                    <i class="material-icons mr-1">compare_arrows</i> Compare
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.Placeholder Product Pane -->
                    <!-- Placeholder Product Pane -->
                    <div class="product-pane empty box-shadow-sm">
                        <div class="empty-content text-center p-2">
                            <p class="text-sm mb-0 pb-0 text-white">
                                Add another product
                            </p>
                            <div class="row justify-content-center">
                                <div class="d-flex align-items-center text-white rounded-0 mt-1">
                                    <i class="material-icons mr-1">compare_arrows</i> Compare
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.Placeholder Product Pane -->
                    <div class="d-grid mx-3">
                        <button type="submit" class="btn btn-warning rounded-pill font-600 m-auto" id="submit-comparisons" disabled>Compare Selected</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.Comparing Panel -->

        <!-- Ad Panel -->
        @include('layouts.includes.banners')
        <!-- /.Ad Panel -->

        <!-- Footer -->
        <footer class="footer d-flex flex-column bg-meshgrid box-shadow-sm">
            <!-- Newsletter -->
            <div class="newsletter d-flex justify-content-center align-items-center w-100">
                <div class="d-block text-center w-50 mr-0 pr-0">
                    <h2 class="lead text-white font-400 text-uppercase my-0 py-0">subscribe our newsletter</h2>
                    <p class="text-white my-0 py-0">Stay up to date with our latest news and properties</p>
                </div>
                <div class="subscription-info text-center w-50 mx-5">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Your email address" aria-label="Your email address" id="toggle-mailing-list">
                        <div class="input-group-append">
                            <span class="input-group-text text-dark text-uppercase" id="subscribe">subscribe</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.Newsletter -->

            <hr class="bg-white my-0 py-0">

            <!-- Copyright -->
            <div class="copyrights">
                <div class="container my-2">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-column justify-content-center order-md-2">
                            <div class="d-flex justify-content-center align-items-center navbar-brand">
                                <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" class="mr-2" alt="">
                                <span class="text-white font-700">{{ config('app.name') }}</span>
                            </div>
                            <div class="d-flex app-earnings">
                                <div class="d-inline-block text-center">
                                    <h5 class="font-500 mb-0 pb-0 text-white items-sold">0</h5>
                                    <p class="text-sm mt-0 pt-0 text-faded">items sold</p>
                                </div>
                                <div class="d-inline-block text-center ml-4">
                                    <h5 class="font-500 mb-0 pb-0 text-white">US$<span class="total-sales text-white">0.00</span></h5>
                                    <p class="text-sm mt-0 pt-0 text-faded">total earnings</p>
                                </div>
                            </div>
                        </div>
                        <ul id="app-footer-links" class="list-inline align-self-center order-md-1">
                            <li class="list-inline-item text-sm agreement" data-value="strongly-disagree">
                                <a href="about.php">About {{ config('app.name') }}</a>
                            </li>
                            <li class="list-inline-item text-sm agreement" data-value="strongly-disagree">
                                <a href="/blog">Blog</a>
                            </li>
                            <li class="list-inline-item text-sm agreement" data-value="strongly-disagree">
                                <a href="">Become an affiliate</a>
                            </li>
                            <li class="list-inline-item text-sm agreement" data-value="strongly-disagree">
                                <a href="terms.php">Terms</a>
                            </li>
                            <li class="list-inline-item text-sm agreement" data-value="strongly-disagree">
                                <a href="">Help Center</a>
                            </li>
                            <li class="list-inline-item text-sm agreement" data-value="strongly-disagree">
                                <a href="contact-us.php">Site map</a>
                            </li>
                        </ul>
                    </div>
                    <div id="footer-bar" class="row justify-content-between align-items-center text-sm agreement" data-value="strongly-disagree">
                        <div class="text-white">
                            <span class="text-white d-none d-md-inline">Copyright</span> <i class="fa fa-copyright"></i> {{ date('Y') }} {{ config('app.name') }} Inc. All rights reserved.
                        </div>
                        <a class="text-white" href="https://twitter.com/TinaKing92">Designed & Developed by @TinaKing92</a>
                    </div>
                </div>
            </div>
            <!-- /.Copyright -->
        </footer>
        <!-- /.footer -->

        <!-- App-Rating -->
        <div class="app-rating-box p-2 box-shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <a href="index.php" class="navbar-brand font-700 ml-2">
                    <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> Targets
                </a>
                <span role="button" class="material-icons toggle-ratingbox" id="close-ratingbox">cancel</span>
            </div>
            <div class="rating-content mt-2">
                <h5 class="font-600 mb-0 pb-0">
                    Help us improve - how are we doing?
                </h5>
                <form method="post" id="targets-rating" class="needs-validation" novalidate>
                    <div class="form-group">
                        <p class="mt-0 pt-0">
                            I'm confident in {{ config('app.name') }}'s ability to perform well.
                        </p>
                        <span class="form-error text-danger text-sm p-ratingError">Performance rating required.</span>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="rating-ball performance-rating d-grid" data-value="1">
                                <span class="rating-score m-auto lead font-600">1</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="2">
                                <span class="rating-score m-auto lead font-600">2</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="3">
                                <span class="rating-score m-auto lead font-600">3</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="4">
                                <span class="rating-score m-auto lead font-600">4</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="5">
                                <span class="rating-score m-auto lead font-600">5</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="6">
                                <span class="rating-score m-auto lead font-600">6</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="7">
                                <span class="rating-score m-auto lead font-600">7</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="8">
                                <span class="rating-score m-auto lead font-600">8</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="9">
                                <span class="rating-score m-auto lead font-600">9</span>
                            </div>
                            <div class="rating-ball performance-rating d-grid" data-value="10">
                                <span class="rating-score m-auto lead font-600">10</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between my-1">
                            <span class="text-sm agreement" data-value="strongly-disagree">strongly disagree</span>
                            <span class="text-sm agreement" data-value="strongly-agree">strongly agree</span>
                        </div>
                        <p>
                            {{ config('app.name') }}'s will respond constructively if I have any problems.
                        </p>
                        <span class="form-error text-danger text-sm r-ratingError">Response rating required.</span>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="rating-ball response-rating d-grid" data-value="1">
                                <span class="rating-score m-auto lead font-600">1</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="2">
                                <span class="rating-score m-auto lead font-600">2</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="3">
                                <span class="rating-score m-auto lead font-600">3</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="4">
                                <span class="rating-score m-auto lead font-600">4</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="5">
                                <span class="rating-score m-auto lead font-600">5</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="6">
                                <span class="rating-score m-auto lead font-600">6</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="7">
                                <span class="rating-score m-auto lead font-600">7</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="8">
                                <span class="rating-score m-auto lead font-600">8</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="9">
                                <span class="rating-score m-auto lead font-600">9</span>
                            </div>
                            <div class="rating-ball response-rating d-grid" data-value="10">
                                <span class="rating-score m-auto lead font-600">10</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between my-1">
                            <span class="text-sm agreement" data-value="strongly-disagree">strongly disagree</span>
                            <span class="text-sm agreement" data-value="strongly-agree">strongly agree</span>
                        </div>
                        <div class="form-group">
                            <label for="app-review" class="font-600 mb-0">
                                Add your app review
                            </label>
                            <textarea type="text" cols="30" rows="5" name="app-review" id="app-review" class="form-control font-500" placeholder="Write your review" required></textarea>
                            <span class="form-error text-danger text-sm" id="app-comment-error">Please write something</span>
                        </div>
                        <input type="hidden" name="p-rating" id="p-rating">
                        <input type="hidden" name="r-rating" id="r-rating">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary font-600 px-3">Done</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.App-Rating -->

        <!-- Processing Modal -->
        <div class="modal fade" id="processing-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h6 class="font-600">Processing please wait...</h6>
                        <img src="{{ asset('img/app/animated-spinner.svg') }}" height="80" width="80">
                    </div>
                </div>
            </div>
            </div>
        <!-- /.Processing Modal -->

        <!-- Feedback Success Modal -->
        <div class="modal p-0" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="success-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center">
                        <i class="material-icons fa-5x text-white" id="success-icon">check_circle</i>
                        <h4 class="display-5 font-600 text-white">Thank you</h4>
                        <p class="text-white" id="success-message">Your feedback helps others in purchasing this gift.</p>
                        <button role="button" class="btn btn-primary rounded-pill px-5" id="dismiss-success-modal">Okay. Great!</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Feedback Success Modal -->

        <!-- Checkout Modal -->
        <div class="modal fade rounded-0" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="checkout-modal" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header pt-0 pb-1 shadow-sm">
                        <div class="modal-title d-block" id="wishlist-modalLabel">
                            <h6 class="mb-0 p-3">You're not Signed in.</h6>
                            <small class="mt-0 review-modal-title text-capitalize">
                            </small>
                        </div>
                        <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-justify" id="wishlist-modal-text">
                            You need to be signed in with your account to Checkout.
                        </p>
                        <div class="row justify-content-center w-100 px-0 mx-0">
                            <div class="col">
                                <a role="button" href="index.php?redirect=http://<?= $_SERVER['HTTP_HOST']; ?>/targets/checkout.php" class="btn border-primary text-primary btn-sm btn-block font-600">
                                    Sign in
                                </a>
                            </div>
                            <div class="col">
                                <a role="button" href="signup.php?redirect=http://<?= $_SERVER['HTTP_HOST']; ?>/targets/checkout.php" class="btn btn-primary btn-sm btn-block ml-1">
                                    Sign up
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Checkout Modal -->

        <!-- Wishlist Modal -->
        <div class="modal fade rounded-0" id="wishlist-modal" tabindex="-1" role="dialog" aria-labelledby="wishlist-modal" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header pt-0 pb-1 shadow-sm">
                        <div class="modal-title d-block" id="wishlist-modalLabel">
                            <h6 class="mb-0 p-3">You're not Signed in.</h6>
                            <small class="mt-0 review-modal-title text-capitalize">
                            </small>
                        </div>
                        <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-justify" id="wishlist-modal-text">
                            You need to be signed in with your account to add <span class="text-capitalize text-primary" id="visitor-wish-item"></span> to your Wishlist.
                        </p>
                        <div class="row justify-content-center w-100 px-0 mx-0">
                            <div class="col">
                                <a role="button" href="/login" id="wishlist-modal-signin" class="btn border-primary text-primary btn-sm btn-block font-600">
                                    Sign in
                                </a>
                            </div>
                            <div class="col">
                                <a role="button" href="/register" id="wishlist-modal-signup" class="btn btn-primary btn-sm btn-block text-white ml-1">
                                    Sign up
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Wishlist Modal -->

        <!-- Mailing List -->
        <div class="modal fade rounded-0" id="mailing-list" tabindex="-1" role="dialog" aria-labelledby="mailing-list" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header pt-0 pb-1 shadow-sm">
                        <div class="modal-title d-block" id="mailing-modalLabel">
                            <h6 class="mb-0 p-3 font-600">Join the mailing list</h6>
                            <small class="mt-0 review-modal-title text-capitalize">
                            </small>
                        </div>
                        <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-justify" id="mailing-modal-text">
                            Our emails are filled with the latest news, offers and product launches from {{ config('app.name') }}. We may target communications
                            based on your location, interests, other information you provide and the types of products you purchase from us. You can unsubscribe at any
                            time by clicking the link in the email we send to you or by visiting the preference settings once you've an account setup with us.
                        </p>
                        <hr class="my py-0">
                        <form class="needs-validation" method="post" id="subscription-form" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group subscription-fg">
                                        <label class="text-sm font-600 mb-0 text-faded" for="fullname">Full name</label>
                                        <i class="material-icons text-faded">person</i>
                                        <input type="text" class="form-control subscription-input text-capitalize" id="fullname" name="fullname" value="{{ Auth::user()->name ?? '' }}" placeholder="Your name" required spellcheck="false">
                                        <span class="invalid-feedback">Please provide your name.</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group subscription-fg">
                                        <label class="text-sm font-600 mb-0 text-faded" for="email-address">Email address</label>
                                        <i class="material-icons text-faded">email</i>
                                        <input type="email" class="form-control subscription-input" id="email-address" name="email-address" value="{{ Auth::user()->email ?? '' }}" placeholder="name@example.com" required spellcheck="false">
                                        <span class="invalid-feedback">Please provide your email.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group subscription-fg">
                                        <label class="text-sm font-600 mb-0 text-faded" for="mobile-number">Mobile No.</label>
                                        <div class="row no-gutters align-items-center w-100">
                                            <div class="phone-code bg-transparent col-4 col-md-3">
                                                <img src="{{ asset('img/country-flag/flag-of-Zimbabwe.png') }}" alt="" height="15" width="25" class="country-flag">
                                                <input type="text" name="country-code" id="country-code" class="form-control subscription-input text-primary country-code bg-transparent" value="263" disabled>
                                            </div>
                                            <div class="phone-number col-8 col-md-9">
                                                <input type="text" class="form-control mobile-number" id="mobile-number" name="mobile-number" placeholder="Mobile Number" data-inputmask='"mask": "999999999"' value="{{ Auth::user()->mobile_phone ?? '' }}" required data-mask>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback">9 digit mobile no. required</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group subscription-fg">
                                        <label class="text-sm font-600 mb-0 text-faded" for="customer-location">Location</label>
                                        <i class="material-icons text-faded">person_pin_circle</i>
                                        <input type="text" class="form-control text-capitalize subscription-input" id="customer-location" name="customer-location" placeholder="123 First St, Warren Hills, Harare" value="{{ Auth::user()->address ?? '' }}" required>
                                        <span class="invalid-feedback">Please provide your location.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="birthday" class="mb-0 text-sm font-600 text-faded">Birthday</label>
                                        {!! birthdayPicker() !!}
                                        <span class="invalid-feedback text-sm">Birthday required!</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="text-sm font-600 mb-0 text-faded" for="gender">Gender</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>
                                    <span class="invalid-feedback">Please provide your gender.</span>
                                </div>
                            </div>
                            <p class="text-sm agreement" data-value="strongly-disagree">
                                By subscribing to receive emails you agree to our <a href="terms.php">terms and policy.</a>
                            </p>
                            <input type="hidden" name="action" value="subscribe">
                            <div class="row justify-content-center my-1">
                                <a href="#" class="btn btn-link font-600" data-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary px-md-5 font-600" id="subscribe-btn">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Mailing List -->

        <!-- Subscribe Newsletter -->
        <div class="modal fade rounded-0" id="subscribed-modal" tabindex="-1" role="dialog" aria-labelledby="subscribed-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content box-shadow-sm">
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <a href="#" class="navbar-brand font-700">
                                <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> {{ config('app.name') }}
                            </a>
                        </div>
                        <h5 class="lead my-2">You're part of our newsletter!</h5>
                        <p class="text-sm text-justify">
                            You subscribed to our mailing list to receive latest news, offers and product launches based on your location. 
                            @auth
                            You can unsubscribe at any time by visiting the preference settings in your account settings page. 
                            @endauth
                            @guest
                                You can unsubscribe at any time by visiting the preference settings once you've an account setup with us. 
                            @endguest
                        </p>
                        <div class="row justify-content-center my-1">
                            <button class="btn btn-primary btn-sm rounded-pill px-3" data-dismiss="modal">Close</button>
                            @auth
                                <a href="/account/{{ username() }}" class="btn btn-link d-flex align-items-center ml-2">
                                    Go to Account Settings 
                                    <i class="material-icons ml-1">arrow_forward</i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Subscribe Newsletter -->

        <!-- Greeting Card Modal -->
        @auth
            <div class="modal" id="greeting-card-modal" tabindex="-1" role="dialog" aria-labelledby="greeting-card-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content box-shadow-sm rounded-0">
                        <form method="post" id="greeting-card" class="needs-validation" enctype="multipart/form-data" novalidate>
                            <div class="left-controls modal-controls d-none">
                                <i role="button" class="fa fa-arrow-circle-left text-primary fa-3x prev-step"></i>
                            </div>
                            <div class="right-controls modal-controls">
                                <i role="button" class="fa fa-arrow-circle-right text-primary fa-3x next-step"></i>
                            </div>
                            <div class="note-counter d-none">
                                <div class="d-flex align-items-center justify-content-around w-100">
                                    <div class="d-inline-flex font-600">
                                        <i class="material-icons text-muted mr-1">format_shapes</i>
                                        <span class="text-warning mr-1" id="character-count">0</span>
                                        <span class="d-none d-md-inline">characters</span>
                                    </div>
                                    <div class="d-inline-flex font-600">
                                        <i class="material-icons text-muted mr-1">record_voice_over</i>
                                        <span class="text-warning mr-1" id="word-count">0</span>
                                        <span class="d-none d-md-inline">words</span>
                                    </div>
                                    <div class="d-inline-flex font-600">
                                        <i class="material-icons text-muted mr-1">format_list_numbered</i>
                                        <span class="text-warning mr-1" id="sentence-count">0</span>
                                        <span class="d-none d-md-inline">sentences</span>
                                    </div>
                                    <i role="button" class="material-icons text-danger" data-dismiss="modal" title="Close" title="Close">cancel</i>
                                </div>
                            </div>
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front">
                                        <label for="upload-greeting-card" class="w-100 p-2">
                                            <div class="d-block initiate-upload text-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons fa-3x mr-1">local_library</i>
                                                    <h4 class="cursive my-0 py-0" id="card-type">Greeting Cards</h4>
                                                </div>
                                                <h5 class="font-600 text-white card-info-text mt-5">
                                                    Click the next-icon button to add your personal note
                                                </h5>
                                            </div>
                                        </label>
                                        <input type="file" class="d-none" name="upload-greeting-card" id="upload-greeting-card" onchange="displayGreetingCard(this)" accept="image/*" required>
                                        <img src="/storage/gifts/a58e93d5-ac91-4c41-a7b6-2da258a55467._CR0,0,1251,1251_PT0_SX300__.jpg" class="w-100" id="custom-greeting-card" height="400">
                                    </div>
                                    <div class="flip-card-back bg-whitesmoke">
                                        <div class="form-group">
                                            <textarea name="greeting-note" id="greeting-note" cols="30" class="form-control font-600 lead-2x rounded-0 bg-whitesmoke" placeholder="Your personal note goes here..." autofocus required onkeyup="wordCounter(this)"></textarea>
                                            <!-- Hidden Inputs -->
                                            <input type="hidden" name="characters" id="characters">
                                            <input type="hidden" name="words" id="words">
                                            <input type="hidden" name="sentences" id="sentences">
                                            <input type="hidden" name="card-image" id="card-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <!-- SigninFirst Modal -->
            <div class="modal text-sm p-0" id="greeting-card-modal" tabindex="-1" role="dialog" aria-labelledby="greeting-card-modal" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content p-0">
                        <div class="modal-header pt-0 pb-1 shadow-sm">
                            <div class="modal-title d-block" id="exampleModalLabel">
                                <h5 class="mb-0 p-3">Want to customize?</h5>
                                <small class="mt-0 write-review-title text-capitalize">
                                </small>
                            </div>
                            <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-justify">
                                You need to be signed in with your account to customize this greeting card.
                            </p>
                            <div class="row justify-content-center w-100 px-0 mx-0">
                                <div class="col">
                                    <a role="button" href="index.php?redirect=" class="btn border-primary text-primary btn-sm btn-block font-600">
                                        Sign in
                                    </a>
                                </div>
                                <div class="col">
                                    <a role="button" href="signup.php?redirect=" class="btn btn-primary btn-sm btn-block font-600 ml-1">
                                        Sign up
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.signin-first modal -->
        @endguest
        <!-- /. Greeting Card Modal -->

        <!-- Gift Customizing Modal -->
        @auth
            <div class="modal p-0" id="customizing-modal" tabindex="-1" role="dialog" aria-labelledby="customizing-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content box-shadow-sm rounded-0">
                        <form method="post" id="customization-form" class="needs-validation container-fluid" enctype="multipart/form-data" novalidate>
                            <div class="modal-body m-0 p-0">
                                <h4 class="font-600 text-center my-2">Customize this gift</h4>
                                <div class="d-grid grid-2 grid-p-1 m-xl-2">
                                    <div class="first-section">
                                        <label for="gift-custom-img" class="w-100 custom-img-pane">
                                            <div class="d-block d-cursor initiate-upload text-center">
                                                <div class="d-none" id="add-custom-image" onclick="selectCustomImg()">
                                                    <i class="material-icons fa-3x text-white card-info-icon">add_a_photo</i>
                                                    <h5 class="font-600 text-white card-info-text">
                                                        Click to upload your own custom image or logo
                                                    </h5>
                                                </div>
                                                <h4 class="lead-2x font-600 text-white custom-text-screen d-none"></h4>
                                            </div>
                                            <input type="file" class="d-none" name="gift-custom-img" id="gift-custom-img" onchange="showCustomImg(this)" accept="image/*" required>
                                            <img src="/storage/gifts/15f479f840ad60.jpg" height="350" class="customizable-gift-img w-100" id="user-custom-file">
                                            <div id="toggle-custom-settings" class="d-none">
                                                <button role="button" class="btn btn-sm rounded-pill px-3 text-warning font-600" id="toggle-custom-text">
                                                    Add custom text
                                                </button>
                                            </div>
                                        </label>
                                        <!-- Custom Colors -->
                                        <div class="container-fluid color-selection-pane my-2">
                                            <h6 class="font-600 text-uppercase">Choose your custom color</h6>
                                            <div class="row justify-content-around w-100">
                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm" title="Red or Maroon">
                                                    <div class="color-inset bg-brick-red">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm">
                                                    <div class="color-inset bg-orange" title="Orange">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm">
                                                    <div class="color-inset bg-warning" title="Yellow">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm" title="Green">
                                                    <div class="color-inset bg-success">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm" title="Purple">
                                                    <div class="color-inset bg-purple">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm" title="White">
                                                    <div class="color-inset bg-white">
                                                        <i class="text-success material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm" title="Grey">
                                                    <div class="color-inset bg-light-grey">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->

                                                <!-- Custom Color Picker -->
                                                <div class="custom-color shadow-sm" title="Blue">
                                                    <div class="color-inset bg-primary">
                                                        <i class="text-white material-icons color-selected-icon">done</i>
                                                    </div>
                                                </div>
                                                <!-- Custom Color Picker -->
                                            </div>
                                        </div>
                                        <!-- /.Custom Colors -->
                                        <!-- Gift Sizes -->
                                        <div class="container-fluid color-selection-pane my-2">
                                            <h6 class="font-600 text-uppercase">Choose your size</h6>
                                            <div class="row justify-content-around w-100">
                                                <a role="button" class="btn btn-link gift-sizes font-600" id="small-size">S</a>
                                                <a role="button" class="btn btn-link gift-sizes font-600">M</a>
                                                <a role="button" class="btn btn-link gift-sizes font-600">L</a>
                                                <a role="button" class="btn btn-link gift-sizes font-600">XL</a>
                                                <a role="button" class="btn btn-link gift-sizes font-600">XXL</a>
                                            </div>
                                        </div>
                                        <!-- /.Gift Sizes -->
                                    </div>
                                    <div class="second-section text-center">
                                        <div class="custom-header lh-100">
                                            <h5 class="font-600 text-uppercase mb-0 pb-0">Customizable Cutting Board</h5>
                                            <h6 class="font-600 text-capitalize text-sm mb-0 pb-0 text-faded">Customizable Kitchenware</h6>
                                            <ul class="list-inline align-items-center ml-2 my-0 py-0">
                                                <li class="list-inline-item star-rating text-warning">&starf;</li>
                                                <li class="list-inline-item star-rating text-warning">&starf;</li>
                                                <li class="list-inline-item star-rating text-warning">&starf;</li>
                                                <li class="list-inline-item star-rating text-warning">&starf;</li>
                                                <li class="list-inline-item star-rating text-faded">&star;</li>
                                                <span class="text-sm text-faded font-600">(128)</span>
                                            </ul>
                                        </div>
                                        <div class="d-block my-2">
                                            <h6 class="font-600 text-uppercase">Choose customization type</h6>
                                            <div class="d-flex w-100 align-items-center justify-content-around custom-type" id="custom-image-option">
                                                <div class="d-inline-flex align-items-center">
                                                    <!-- Custom Type -->
                                                    <div class="custom-type-radio custom-color shadow-sm">
                                                        <div class="color-inset">
                                                            <i class="material-icons color-selected-icon">done</i>
                                                        </div>
                                                    </div>
                                                    <!-- /.Custom Type -->
                                                    <h6 class="my-0 py-0 font-600 ml-2">Add custom image</h6>
                                                </div>
                                                <i class="material-icons fa-2x text-muted">collections</i>
                                            </div>
                                            <div class="d-flex w-100 align-items-center justify-content-around custom-type mt-1" id="custom-text-option">
                                                <div class="d-inline-flex align-items-center">
                                                    <!-- Custom Type -->
                                                    <div class="custom-type-radio custom-color shadow-sm">
                                                        <div class="color-inset">
                                                            <i class="material-icons color-selected-icon">done</i>
                                                        </div>
                                                    </div>
                                                    <!-- /.Custom Type -->
                                                    <h6 class="my-0 py-0 font-600 ml-2">Add custom text</h6>
                                                </div>
                                                <i class="material-icons fa-2x text-muted">format_shapes</i>
                                            </div>
                                        </div>
                                        <div class="form-group my-3 d-0" id="custom-text-form">
                                            <textarea name="custom-text" id="custom-text" cols="30" rows="4" class="form-control font-600 lead-2x" placeholder="Your custom text here..." autofocus onkeyup="giftCustomText(this)"></textarea>
                                        </div>
                                        <div class="d-block mt-2">
                                            <h3 class="display-5 font-600 text-faded">R125.28</h3>
                                            <button class="btn btn-warning font-600 rounded-pill px-3" id="save-changes-btn" disabled>Customize & Buy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <!-- SigninFirst Modal -->
            <div class="modal text-sm p-0" id="customizing-modal" tabindex="-1" role="dialog" aria-labelledby="customizing-modal" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content p-0">
                        <div class="modal-header pt-0 pb-1 shadow-sm">
                            <div class="modal-title d-block" id="exampleModalLabel">
                                <h5 class="mt-1 mb-0 p-1">Want to customize?</h5>
                            </div>
                            <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 class="text-justify">
                                You need to be signed in with your account to customize
                                <span class="text-primary text-capitalize custom-gift-title"></span>.
                            </h6>
                            <div class="row justify-content-center w-100 px-0 mx-0">
                                <div class="col">
                                    <a role="button" id="customize-signin-btn" class="btn border-primary text-primary btn-sm btn-block font-600">
                                        Sign in
                                    </a>
                                </div>
                                <div class="col">
                                    <a role="button" id="customize-signup-btn" class="btn btn-primary btn-sm text-white btn-block font-600 ml-1">
                                        Sign up
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.signin-first modal -->
        @endguest
        <!-- /. Customizing Modal -->

        <!-- Wrapper Customizing Modal -->
        @auth
            <div class="modal p-0" id="wrapper-customizing-modal" tabindex="-1" role="dialog" aria-labelledby="wrapper-customizing-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content box-shadow-sm rounded-2">
                        <img class="modal-header-img" id="wrapper-header-img" height="60" width="60" class="rounded-circle" src="">
                        <div class="modal-body mt-4">
                            <div class="text-center">
                                <h5 class="font-600">Do you have your own wrapper?</h5>
                                <h6 class="my-0 py-0 text-justify">
                                    Upload a snapshot of the type of wrapper you want to wrap your order with.
                                    Additional costs may apply.
                                </h6>
                            </div>
                            <form method="post" id="wrapper-form" class="needs-validation" enctype="multipart/form-data" novalidate>
                                <div class="container">
                                    <div class="row justify-content-center w-100">
                                        <div class="col-6 my-2">
                                            <div class="customizing-box upload-file rounded d-grid" id="wrapper-file-upload" onclick="uploadCustomImg()">
                                                <input type="file" class="d-none print-image" id="custom-wrapper" name="print-image" onchange="displayCustomImg(this)" accept="image/*" required>
                                                <div class="customizing-content m-auto">
                                                    <div class="row justify-content-center">
                                                        <div class="accessory-icon rounded-circle d-grid">
                                                            <i class="material-icons bg-white fa-3x text-whitesmoke m-auto">add</i>
                                                        </div>
                                                    </div>
                                                    <p class="mt-2 py-0 text-center px-2">Click to upload your custom wrapper</p>
                                                </div>
                                            </div>
                                            <!-- /.File Upload -->
                                        </div>
                                        <div class="col-6 my-2 d-none display-img">
                                            <img src="{{ asset('img/app/spinner.svg') }}" height="200" alt="" class="rounded w-100 uploaded-print-img">
                                        </div>
                                    </div>
                                </div>
                                <!-- Wrapper Hidden Details -->
                                <input name="card-product-id" id="card-product-id" type="hidden">
                                <input id="wrapper-name" type="hidden">
                                <input name="print-text" id="print-text" type="hidden">
                                <input name="card-image" id="card-image" type="hidden">
                                <input name="card-usd-price" id="card-usd-price" type="hidden">
                                <input name="card-zar-price" id="card-zar-price" type="hidden">
                                <input name="card-zwl-price" id="card-zwl-price" type="hidden">
                                <input name="print-usd-price" id="print-usd-price" type="hidden">
                                <input name="print-zar-price" id="print-zar-price" type="hidden">
                                <input name="print-zwl-price" id="print-zwl-price" type="hidden">
                                <input id="wrapper-sale-usd-price" type="hidden">
                                <input id="wrapper-sale-zar-price" type="hidden">
                                <input id="wrapper-sale-zwl-price" type="hidden">
                                <input id="wrapper-end-time" type="hidden">
                                <input id="wrapper-category-name" type="hidden">
                                <input id="wrapper-product-units" type="hidden">
                                <input value="1" id="wrapper-quantity" type="hidden">
                                <input id="wrapper-sale-end-date" type="hidden">
                                <input id="wrapper-description" type="hidden">
                                <!-- /.Wrapper Hidden Details -->
                                <input type="hidden" class="text-capitalize" name="product-name" id="product-name">
                                <input type="hidden" name="text-chars" id="text-chars">
                                <input type="hidden" name="text-sentences" id="text-sentences">
                                <input type="hidden" name="text-words" id="text-words">
                                <input type="hidden" name="print-cost" id="print-cost">
                                <input type="hidden" name="action" id="action" value="gift-customization">
                                <div class="d-flex align-items-center justify-content-sm-center justify-content-md-end mt-2">
                                    <a role="button" href="#" class="btn btn-link font-600" data-dismiss="modal">Cancel</a>
                                    <button class="btn btn-primary btn-sm px-3 ml-2 font-600 rounded-pill buy-wrapper">No, I want this one</button>
                                    <button type="submit" class="btn btn-outline-primary btn-sm px-3 ml-2 font-600 rounded-pill">Upload new wrapper</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <!-- SigninFirst Modal -->
            <div class="modal text-sm p-0" id="wrapper-customizing-modal" tabindex="-1" role="dialog" aria-labelledby="wrapper-customizing-modal" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content p-0">
                        <div class="modal-header pt-0 pb-1 shadow-sm">
                            <div class="modal-title d-block" id="exampleModalLabel">
                                <h5 class="mb-0 p-3">Want to use your own wrapper?</h5>
                                <small class="mt-0 write-review-title text-capitalize">
                                </small>
                            </div>
                            <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-justify">
                                You need to be signed in with your account to customize this wrapper.
                            </p>
                            <div class="row justify-content-center w-100 px-0 mx-0">
                                <div class="col">
                                    <a role="button" href="index.php?redirect=" class="btn border-primary text-primary btn-sm btn-block font-600">
                                        Sign in
                                    </a>
                                </div>
                                <div class="col">
                                    <a role="button" href="signup.php?redirect=" class="btn btn-primary btn-sm btn-block font-600 ml-1">
                                        Sign up
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.signin-first modal -->
        @endguest
        <!-- /. Wrapper Customizing Modal -->

        <!-- Upload Progress Modal -->
        <div class="modal p-0 upload-progress-modal" tabindex="-1" role="dialog" aria-labelledby="upload-progress-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body row justify-content-center">
                        <div class="app-loading">
                            <div class="media">
                                <img src="" height="80" width="80" class="align-self-center mr-2 rounded uploaded-custom-img">
                                <div class="media-body">
                                    <h3 class="lead font-600 mb-0 py-0 text-capitalize text-white" id="wrapper-title"></h3>
                                    <h6 class="my-0 py-0 text-white font-500">Custom Image</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-sm text-white mb-0 pb-0">File Uploading...</small>
                                        <span id="uploaded-status" class="text-white">0%</span>
                                    </div>
                                    <!-- Loading Progressbar -->
                                    <div class="d-block">
                                        <div class="progress progress-xxs mt-1">
                                            <div class="progress-bar progress-bar-animated" role="progressbar" id="progress-upload" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" style="width: 0%">
                                                <span class="sr-only">0%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Upload Progress Modal -->

        <!-- Glass Toast Animation Modal -->
        <div class="modal p-0 glass-toast-modal" tabindex="-1" role="dialog" aria-labelledby="glass-toast-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body row justify-content-center">
                        <p class="toast-title">Cheers!</p>
                        <div class="cheersLine1"></div>
                        <div class="cheersLine2"></div>
                        <div class="cheersLine3"></div>
                        <div class="glass-left">
                            <div class="stem"></div>
                        </div>
                        <div class="glass-right">
                            <div class="stem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Glass Toast Animation Modal -->

        <!-- Animated Card Modal -->
        <div class="modal p-0" id="animated-card-modal" tabindex="-1" role="dialog" aria-labelledby="animated-card-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center">
                        <h4 class="font-600 text-warning d-flex justify-content-center align-items-center">
                            <i class="material-icons fa-2x mr-1">mood</i>
                            <span class="display-4 text-warning">Lovely!</span>
                        </h4>
                        <img src="{{ asset('img/backgrounds/animated-card.gif') }}" class="img-fluid">
                        <h5 class="text-white my-2" id="animated-card-msg">A customized greeting card will be added in your order. Now select the gift wrapper.</h5>
                        <button role="button" class="btn btn-primary rounded-pill px-5" id="go-to-wrappers">Okay. Great!</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Animated Card Modal -->

        <!-- Animated Box Modal -->
        <div class="modal p-0" id="animated-box-modal" tabindex="-1" role="dialog" aria-labelledby="animated-card-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center">
                        <h4 class="font-600 text-warning d-flex justify-content-center align-items-center">
                            <i class="material-icons fa-2x mr-1">mood</i>
                            <span class="display-4 text-warning">Wonderful!</span>
                        </h4>
                        <img src="{{ asset('img/backgrounds/box-animation.gif') }}" class="img-fluid">
                        <h5 class="text-white my-2">Your customized wrapper has been successfully added. Now add accessories.</h5>
                        <button role="button" class="btn btn-primary rounded-pill px-5" id="go-to-accessories">Okay. Great!</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Animated Box Modal -->

        <!-- Animated Gift Added -->
        <div class="modal p-0" id="gift-added-modal" tabindex="-1" role="dialog" aria-labelledby="gift-added-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center">
                        <h2 class="font-600 text-white d-flex justify-content-center align-items-center animated animate-slow bounceInDown">
                            <i class="material-icons fa-2x mr-1">add_shopping_cart</i>
                            <span class="display-5 text-white">Added into giftbox</span>
                        </h2>
                        <div class="gift-box-container">
                            <div class="animated-count-ball d-grid animated bounceInUp">
                                <div class="m-auto">
                                    +<span class="gift-count"></span>
                                </div>
                            </div>
                            <img src="{{ asset('img/backgrounds/giftbox-animation.gif') }}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Animated Gift Added -->

        <!-- Animated Box Emptied -->
        <div class="modal p-0" id="empty-giftbox-modal" tabindex="-1" role="dialog" aria-labelledby="empty-giftbox-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center">
                        <i class="fa fa-dropbox fa-5x text-white animated animate-slow bounceInDown"></i>
                        <h3 class="font-600 text-white animate-slow bounceInUp">Your giftbox has been emptied!</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Animated Box Emptied -->

        <!-- Accessory Animation Modal -->
        <div class="modal p-0" id="accessory-animation-modal" tabindex="-1" role="dialog" aria-labelledby="accessory-animation-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center">
                        <div class="d-flex align-items-center justify-content-center animated bounceInDown delay-1s my-1">
                            <i class="material-icons fa-2x text-white">check_circle</i>
                            <h4 class="display-5 font-600 text-white my-0 py-0" id="animation-title"></h4>
                        </div>
                        <img src="" alt="" height="140" width="140" class="animated slideInLeft animate-slow rounded" id="original-image">
                        <i class="material-icons text-white fa-2x">link</i>
                        <img src="" alt="" height="140" width="140" class="animated slideInRight animate-slow rounded uploaded-custom-img">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Accessory Animation Modal -->

        <!-- Get user's geolocation details -->
        <input type="hidden" name="address" class="address">
        <input type="hidden" name="city" class="city">
        <input type="hidden" name="country-sn" id="country-sn">
        <input type="hidden" name="country-name" class="country-name">
        <!-- /.Geolocation details -->

        <!-- Cookie Policy Banner -->
        <div class="policy-banner container-fluid box-shadow-lg bg-whitesmoke d-grid d-none">
            <div class="m-auto">
                <div class="row align-items-md-center">
                    <div class="col-12 col-md-9">
                        <h6 class="text-justify">
                            This site uses cookies and other tracking technologies to assist with navigation and your ability to provide feedback, analyse your use of our products and services, assist with our promotional and marketing efforts, and provide content from third parties.
                        </h6>
                    </div>
                    <div class="col-12 col-md-3 text-right" id="banner-buttons">
                        <button class="btn btn-warning btn-sm px-3 font-600 cookie-policy-btn">Accept Cookies</button>
                        <button class="btn btn-light btn-sm font-600 cookie-policy-btn d-inline-flex align-items-center justify-content-center" title="Close">
                            <i class="material-icons">close</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JQuery -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- OwlCarousel -->
        <script src="{{ asset('plugins/OwlCarousel/dist/owl.carousel.min.js') }}"></script>
        <!-- AOS -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <!-- iziToast -->
        <script src="{{ asset('plugins/iziToast/js/iziToast.min.js') }}"></script>
        <!-- Sweet Alert -->
        <script src="{{ asset('plugins/sweetalert2/package/dist/sweetalert2.min.js') }}"></script>
        <!-- InputMask -->
        <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
        <!-- ElevateZoom -->
        <script src="{{ asset('plugins/elevatezoom/jquery.elevateZoom-3.0.8.min.js') }}"></script>
        <!-- RateYo -->
        <script src="{{ asset('plugins/rateYo/jquery.rateyo.min.js') }}"></script>
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
        <!-- DatePicker -->
        <script src="{{ asset('plugins/datepicker/js/gijgo.min.js') }}" type="text/javascript"></script>
        <!-- Gifteros -->
        <script src="{{ asset('js/gifteros.min.js') }}"></script>
        <!-- Elfsight -->
        <script src="https://apps.elfsight.com/p/platform.js" defer></script>
        <!-- Show the user login dropdown sign in form if user has been redirected -->
        @auth
            <script>
                // wishlist();
                // notifications();
            </script>
        @endauth
        <!-- <div class="elfsight-app-019c0e60-b4a1-4b1f-bd14-04f718ab31e9"></div> -->
    </body>
</html>