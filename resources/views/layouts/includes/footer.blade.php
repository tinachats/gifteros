                <!-- Main Sidebar -->
                @include('layouts.includes.sidebar')
                <!-- /.Main Sidebar -->

                <!-- Settings Sidebar -->
                @include('layouts.includes.settings')
                <!-- /.Setting Sidebar -->
            </div>
        </div>
        <!-- /.Main Content -->

        <!-- App Footer -->
        <footer class="footer bg-meshgrid mt-5">
            <div class="container my-2">
                <div class="row align-items-md-center">
                    <div class="col-12 col-md-4">
                        <h5 class="font-600 text-white">Be the first to know</h5>
                        <p class="text-sm text-white">
                            Be the first to know of all our gift offers, sales, discounts, events and many more. 
                            Subscribe to our mailing list and you'll be notified of our exclusive deals.
                        </p>
                        <form method="post" class="needs-validation" novalidate>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your email address" aria-label="Your email address" id="toggle-mailing-list">
                                <div class="input-group-append">
                                    <span class="input-group-text text-white text-uppercase bg-primary" id="subscribe">subscribe</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-4 d-md-flex justify-content-md-center border-left border-white">
                        <div class="media">
                            <i class="fa fa-map-marker fa-2x align-self-center text-white mr-2"></i>
                            <div class="media-body text-left">
                                <h5 class="font-600 text-white">Gifts Finder</h5>
                                <p class="text-sm text-white">Find gifts trending nearby</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 d-md-flex justify-content-md-center border-left border-white">
                        <div class="media">
                            <i class="material-icons fa-2x align-self-center text-white mr-2">record_voice_over</i>
                            <div class="media-body text-left">
                                <h5 class="font-600 text-white">Customer Services</h5>
                                <p class="text-sm text-white">Contact us here</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-between">
                    <div class="col-6 col-md-3">
                        <h6 class="font-600 text-white">Discover Gifteros</h6>
                        <ul>
                            <li>
                                <a href="/about-us">About us</a>
                            </li>
                            <li>
                                <a href="/blog">Blog</a>
                            </li>
                            <li>
                                <a href="/careers">Careers</a>
                            </li>
                            <li>
                                <a href="/partner">Become a Partner</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6 class="font-600 text-white">Shopping with us</h6>
                        <ul>
                            <li>
                                <a href="#">Gift Customizations</a>
                            </li>
                            <li>
                                <a href="#">Making Payments</a>
                            </li>
                            <li>
                                <a href="#">Delivery Options</a>
                            </li>
                            <li>
                                <a href="/return-and-exchanges">Return & Exchanges</a>
                            </li>
                            <li>
                                <a href="/order-tracking">Order Tracking</a>
                            </li>
                            <li>
                                <a href="/refunds">Refunds</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6 class="font-600 text-white">Legal</h6>
                        <ul>
                            <li>
                                <a href="/terms-and-conditions">Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="/cookie-policy">Cookies</a>
                            </li>
                            <li>
                                <a href="/privacy">Privacy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6 class="font-600 text-white">Help</h6>
                        <ul>
                            <li>
                                <a href="/contact-us">Contact Us</a>
                            </li>
                            <li>
                                <a href="/faq">FAQ</a>
                            </li>
                            <li>
                                <a href="/brands">Brands</a>
                            </li>
                            <li>
                                <a href="/site-map">Site map</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-md-between">
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center">
                            <a href="#">
                                <i class="fa icon-md text-white fa-facebook-official" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa icon-md text-white fa-twitter ml-2" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa icon-md text-white fa-instagram ml-2" aria-hidden="true"></i>
                            </a>
                            <a href="#">
                                <i class="fa icon-md text-white fa-whatsapp mx-2" aria-hidden="true"></i>
                            </a>
                            <h6 class="text-muted text-sm font-600 my-0">&copy; {{ date('Y') }} Gifteros Inc. All Rights Reserved.</h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-md-right">
                        <a href="/developer/tinashe.chaterera" class="text-sm">
                            <h6 class="font-600 text-faded">Designed & Developed by TinaKing</h6>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.App footer -->

        @auth
            @if (newbieCoupon(Auth::user()->id) == 0)
                <!-- Coupon Modal -->
                <div class="modal fade" id="newbie-modal" tabindex="-1" role="dialog" aria-labelledby="newbie-modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header py-2 box-shadow-sm">
                                <div class="modal-title d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt="{{ config('app.name') }}'s Logo">
                                        <h6 class="font-600 my-0 ml-1">{{ config('app.name') }}</h6>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="material-icons" aria-hidden="true">close</span>
                                </button>
                            </div>
                            <div class="modal-body pb-4">
                                <div class="row justify-content-center mt-0">
                                    <div class="col-12 text-center">
                                        <i class="material-icons fa-5x text-warning"></i>
                                    </div>
                                    <div class="col-12 text-center">
                                        <h5 class="font-600">New to {{ config('app.name') }}?</h5>
                                        <p>
                                            Coupons and hot deals on new customers. Get your $2.00 discount now.
                                        </p>
                                        <h2 class="display-4 font-600">$2.00</h2>
                                        <button class="btn btn-danger rounded-pill" id="newbie-coupon">
                                            Get your coupon now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Coupon Modal -->
            @endif
        @endauth

        <!-- Comparing Panel -->
        <div class="comparison-pane d-none mt-2">
            <span role="button" class="material-icons" id="close-panel" title="Close panel">keyboard_arrow_down</span>
            <div class="compare-panel">
                <form class="compare-products" method="post" id="compare-form">
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
                        <a href="/compare_page" role="button" class="btn btn-warning rounded-pill font-600 m-auto" id="submit-comparisons" disabled="true">Compare Selected</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.Comparing Panel -->

        <!-- App-Rating -->
        <div class="app-rating-box p-2 box-shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <a class="navbar-brand font-700 ml-2">
                    <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> {{ config('app.name') }}
                </a>
                <span role="button" class="material-icons toggle-ratingbox" id="close-ratingbox">cancel</span>
            </div>
            <div class="rating-content mt-2">
                <h5 class="font-600 mb-0 pb-0">
                    Help us improve - how are we doing?
                </h5>
                <form method="post" id="app-rating" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                        <p class="mt-0 pt-0">
                            I'm confident in {{ config('app.name') }}' ability to perform well.
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
                            {{ config('app.name') }}' will respond constructively if I have any problems.
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
                            <textarea type="text" cols="30" rows="4" name="app-review" id="app-review" class="form-control font-500" placeholder="Write your review" required></textarea>
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

        <!-- Shirt Sizes Modal -->
        <div class="modal fade" id="shirt-sizes-modal" tabindex="-1" role="dialog" aria-labelledby="shirt-sizes-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-ccontent-between">
                        <h6 class="text-sm my-0">
                            Measurement <i class="fa fa-question-circle"></i>
                        </h6>
                        <i role="button" class="material-icons fa-2x" data-dismiss="modal"></i>
                    </div>
                    <div class="modal-body text-center">
                        <ul class="nav nav-tabs mr-auto" id="nav-tab" role="tablist">
                            <li class="nav-item m-0">
                                <a role="button" class="nav-link btn btn-default custom-size active font-600" id="nav-cm-tab" data-toggle="tab" href="#nav-cm" role="tab" aria-controls="nav-cm" aria-selected="true">CM</a>
                            </li>
                            <li class="nav-item m-0">
                                <a role="button" class="nav-link btn btn-default custom-size font-600" id="nav-in-tab" data-toggle="tab" href="#nav-in" role="tab" aria-controls="nav-in" aria-selected="false">Customer Reviews ({{ countRatings($id) }})</a>
                            </li>
                        </ul>
                        <h6>Sizes Chart</h6>
                        <div class="tab-content main-pane box-shadow-sm bg-whitesmoke p-2" id="nav-tabContent" id="sizes-tabContent">
                            <div class="tab-pane fade show active" id="nav-cm" role="tabpanel" aria-labelledby="nav-cm-tab">
                                <div class="table-responsive table-sm">
                                    <table class="table-bordered table-hover">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>Size</th>
                                                <th>Chest Width</th>
                                                <th>Length</th>
                                                <th>Shoulder</th>
                                                <th>Sleeve Length</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="bg-light">S</td>
                                                <td>92</td>
                                                <td>64</td>
                                                <td>43</td>
                                                <td>17</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light">M</td>
                                                <td>96</td>
                                                <td>65</td>
                                                <td>44</td>
                                                <td>18</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light">L</td>
                                                <td>100</td>
                                                <td>67</td>
                                                <td>46</td>
                                                <td>19</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light">XL</td>
                                                <td>104</td>
                                                <td>69</td>
                                                <td>47</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light">XXL</td>
                                                <td>108</td>
                                                <td>71</td>
                                                <td>50</td>
                                                <td>21</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light">XXL</td>
                                                <td>110</td>
                                                <td>73</td>
                                                <td>54</td>
                                                <td>22</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light">XL</td>
                                                <td>112</td>
                                                <td>75</td>
                                                <td>57</td>
                                                <td>23</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <img src="" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-in" role="tabpanel" aria-labelledby="nav-in-tab">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <!-- /.Shirt Sizes Modal -->

        <!-- Processing Modal -->
        <div class="modal fade" id="processing-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h6 class="font-600 text-faded">Processing please wait...</h6>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content box-shadow-sm">
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <a class="navbar-brand font-700">
                                <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> {{ config('app.name') }}
                            </a>
                        </div>
                        <h5 class="lead my-2">Want to add to your Wishlist?</h5>
                        <p class="text-sm text-justify">
                            You need to be signed in with your account to add 
                            <span class="text-primary text-capitalize" id="visitor-wish-item"></span> to your Wishlist.
                        </p>
                        <div class="row justify-content-end mr-2 my-1">
                            <a href="#" class="btn btn-link" data-dismiss="modal">Close</a>
                            <a href="/login" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center ml-2">
                                Sign in 
                            </a>
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
                            <a class="navbar-brand font-700">
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

        <!-- Toast Notifications -->
        <div class="toast bg-whitesmoke" id="shopping-alerts" data-delay="5000">
            <div class="toast-header">
                <img src="{{ asset('img/app/visionaries-logo.png') }}" class="rounded mr-2" alt="{{ config('app.name') }}" height="25" width="25">
                <strong class="mr-auto brandname">{{ config('app.name') }}</strong>
                <small class="text-color-switch">11 mins ago</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <div class="media">
                    <img src="{{ asset('img/app/order-map.PNG') }}" height="50" width="50" alt="Map" class="d-flex align-items-center mr-2 rounded">
                    <div class="media-body">
                        <p class="my-0 py-0">
                            <strong class="my-0 py-0 text-capitalize">Takudzwa bozhiwa</strong> from <strong class="text-capitalize">highfield</strong> 
                            just purchased a teddy bear.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast" id="settings-alert" data-autohide="false">
            <div class="toast-header">
                <div class="d-flex align-items-center">
                    <i class="material-icons mr-2">settings</i>
                    <span class="font-600 my-0 py-0">App custom settings</span>
                </div>
                <button type="button" class="ml-auto mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <p class="text-faded text-justify">
                    Looking for a little more control? Now you can choose your currency, theme or sorting order. 
                    Just click the settings <i class="material-icons my-0 py-0 mx-1">settings</i> button on top.
                </p>
                <button class="btn btn-primary px-2" id="dispose-toast">Okay. Got it!</button>
            </div>
        </div>
        <!-- /.Toast Notifications -->

        <!-- Gift Customizing Modal -->
        @auth
        <div class="modal p-0" id="customizing-modal" tabindex="-1" role="dialog" aria-labelledby="customizing-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content box-shadow-sm rounded-2">
                    <form method="post" id="customization-form" class="needs-validation container-fluid" enctype="multipart/form-data" novalidate>
                        <div class="modal-body m-0 p-0">
                            <div class="d-grid grid-2 grid-p-1 m-xl-2">
                                <div class="first-section">
                                    <label for="gift-custom-img" class="w-100 custom-img-pane">
                                        <div class="d-block d-cursor initiate-upload text-center">
                                            <div class="cursor" id="add-custom-image" onclick="selectCustomImg()">
                                                <input type="file" class="d-none" name="gift-custom-img" id="gift-custom-img" onchange="showCustomImg(this)" accept="image/*" required>
                                                <i class="material-icons fa-3x text-white card-info-icon">add_a_photo</i>
                                                <h5 class="font-600 text-white card-info-text">
                                                    Click to upload your own custom image or logo
                                                </h5>
                                            </div>
                                            <h4 class="lead-2x font-600 text-white custom-text-screen d-none"></h4>
                                        </div>
                                        <img src="/storage/gifts/15f479f840ad60.jpg" height="350" class="customizable-gift-img w-100" id="user-custom-file">
                                        <div id="toggle-custom-settings" class="d-none w-100">
                                            <div class="d-flex align-items-center justify-content-center text-center">
                                                <button role="button" class="btn btn-sm rounded-pill px-3 text-warning font-600" id="toggle-custom-text">
                                                    Add custom text <i class="material-icons animated infinite slideInLeft ml-4">arrow_forward</i>
                                                </button>
                                            </div>
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
                                    <div class="container-fluid color-selection-pane my-2 d-none" id="clothing-sizes">
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
                                    <div class="d-block my-2">
                                        <h5 class="font-600 text-uppercase lead" id="custom-gift-name">Customizable Gift Item</h5>
                                        <p class="mt-0 font-600 text-faded">Customize your gift</p>
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
                                        <textarea name="custom-text" id="custom-text" cols="30" rows="3" class="form-control font-600 lead-2x" placeholder="Your custom text here..." autofocus onkeyup="giftCustomText(this)"></textarea>
                                    </div>
                                    <div class="d-block mt-2">
                                        <input type="hidden" name="custom-gift-id" id="custom-gift-id">
                                        <h3 class="display-5 font-600 text-faded ">
                                            <span class="text-faded usd-price">US$<span class="text-faded" id="gift-usd-price">0.00</span></span>
                                            <span class="text-faded zar-price d-none">R<span class="text-faded" id="gift-zar-price">0.00</span></span>
                                            <span class="text-faded zwl-price d-none">ZW$<span class="text-faded" id="gift-zwl-price">0.00</span></span>
                                        </h3>
                                    </div>
                                    <button class="btn btn-warning font-600 rounded-pill px-3 mt-md-2" id="save-changes-btn" disabled>Customize & Buy</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.Cart Options Modal -->
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
                $(function(){
                    userInfo();
                    // Fetch user's notifications
                    notifications();
                });
            </script>
        @endauth
        <!-- <div class="elfsight-app-019c0e60-b4a1-4b1f-bd14-04f718ab31e9"></div> -->
    </body>
</html>