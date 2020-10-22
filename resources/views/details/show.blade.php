@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="details-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">{{ $gift->gift_name }}</h5>
                <ol class="breadcrumb float-sm-right d-flex justify-content-between align-items-center bg-transparent">
                    <li class="breadcrumb-item d-none d-md-inline">
                        <a href="/" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                            <span class="d-none d-md-inline text-primary">Home</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="/category/{{ $gift->category_id }}/{{ $category_name }}" class="text-capitalize">{{ $category_name }}</a>
                    </li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5 main-page">
        <div class="row">
            <div class="col-12 col-xl-8 details-section">
                <!-- Product Info -->
                <div class="row no-gutters">
                    <div class="col-12 col-md-6 product-gallery">
                        <!-- Product Images -->
                        <div class="product-images">
                            <img class="border border-warning" id="product-img" src="/storage/gifts/{{ $gift->gift_image }}" data-zoom-image="/storage/gifts/{{ $gift->gift_image }}" />
                            <!-- Show preview images here -->
                        </div>
                        <!-- /.Product Images -->
                    </div>
                    <!-- Product Details -->
                    <div class="col-12 col-md-6 pl-md-5 product-details">
                        <div class="d-block info-section">
                            <h5 class="font-500 lead lead-2x text-capitalize font-600 mb-0 pb-0 ml-md-2" id="product-title">{{ $gift->gift_name }}</h5>
                            <a href="/category/{{ $gift->category_id }}/{{ $category_name }}" class="text-capitalize ml-md-2 my-0 py-0">{{ $category_name }}</a>
                            <p class="text-capitalize text-faded my-0 py-0 ml-md-2">{{ $gift->units }} In stock</p>
                            <div class="customizing-link ml-md-2 bg-transparent">
                                <!-- Customization link -->
                            </div>
                            <div class="d-flex align-items-center w-100">
                                <div class="media customization-details customized-gift">
                                    <!-- Customized gift info will show up here -->
                                </div>
                                <div class="greeting-card ml-auto" id="greeting-card-added">
                                    <!-- Greeting card info will be shown here -->
                                </div>
                            </div>
                            <div class="d-flex justify-content-around border-top border-bottom py-1">
                                <div class="d-block justify-content-center text-center" id="product-star-rating">
                                    <!-- Gift star rating will show up here -->
                                    {!!dpStarRating($gift->id)!!}
                                </div>
                                <div class="border-right mr-1"></div>
                                <div class="d-block text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="material-icons text-primary">add_shopping_cart</i>
                                        <span class="text-primary font-600">{{ giftsSold($gift->id) }}</span>
                                    </div>
                                    <p class="text-sm text-faded my-0 py-0">total purchases</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center w-100 mt-2" id="product-prices">
                                <!-- Product Prices will show up here -->
                                <div class="us-prices text-center w-50">
                                    <p class="font-600 text-sm text-uppercase text-faded my-0 py-0">price in usd</p>
                                    <h5 class="lead font-600 my-0 py-0">US${{ number_format($gift->usd_price, 2) }}</h5>
                                </div>
                                <div class="border-right mx-3"></div>
                                <div class="zar-prices text-center w-50">
                                    <p class="font-600 text-sm text-uppercase text-faded my-0 py-0">price in zar</p>
                                    <h5 class="lead font-600 my-0 py-0">R{{ number_format($gift->zar_price, 2) }}</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-around" id="change-btns">
                                <!-- Incremental Butons will show up here -->
                                <span role="button" class="material-icons text-success decrease-qty action-icons">remove_circle</span>
                                <span class="product-quantity display-4 font-500 text-success">0</span>
                                <span role="button" class="material-icons text-success increase-qty action-icons">add_circle</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-around mt-3" id="action-btns">
                                <!-- Action Buttons will show up here -->
                                @guest
                                    <button class="btn btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center mr-1 visitor-wishes" id="4" data-name="customiized_mug">
                                        <i class="material-icons text-primary mr-1">favorite_border</i>
                                        <span class="text-primary">Wishlist</span>
                                    </button>
                                @endguest
                                @auth
                                    {!!wishlistBtn($gift->id, Auth::user()->id)!!}
                                @endauth
                                <button class="btn btn-primary btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center m-0" disabled>
                                    <i class="material-icons mr-1">accessible</i> Disabled
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.Product Details -->
                </div>
                <!-- /.Product Info -->

                <!-- Product Ratings & Reviews -->
                <div class="row w-100 border-top pt-2 mt-2">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="font-600 my-0 py-0 text-uppercase text-faded">Customer ratings</h6>
                            <h6>
                                <a class="d-flex align-items-center" href="">
                                    <i class="fa fa-info-circle mr-1"></i> Review policy
                                </a>
                            </h6>
                        </div>
                        <div class="d-grid align-items-center review-metrics grid-p-1">
                            <div class="d-grid text-center">
                                <div class="m-md-auto rating">
                                    <h5 class="display-4 font-600 m-0 p-0 rating-score">{{  number_format(giftRating($gift->id), 1) ?? number_format(0, 1) }}</h5>
                                    <div class="d-md-block d-sm-flex">
                                        <div class="m-0 p-0" id="product-rating"></div>
                                        <div class="d-flex justify-content-center text-muted align-items-center">
                                            <i class="material-icons text-muted mr-1">people</i> <span class="total-ratings text-muted mr-1">{{ countRatings($gift->id) }}</span> total
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block" id="progress-rating">
                                {!!progressBarRating($gift->id)!!}
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3 pb-3">
                            <button class="btn btn-sm btn-inverse rounded-pill font-600 d-flex align-items-center px-5" id="show-write-review">
                                <i class="material-icons mr-1">edit</i>
                                Write a review
                            </button>
                        </div>
                        <div class="border-top pt-3">
                            <h6 class="font-600 my-0 py-0 text-uppercase text-faded">Gift Description</h6>
                            <p class="text-justify">
                                {{ $gift->description }}
                            </p>
                        </div>
                        <div class="border-top pt-3">
                            <h6 class="font-600 my-0 py-0 text-uppercase text-faded">Disclaimer</h6>
                            <ul class="bulleted-list px-3">
                                <li>Delivered product might vary slightly from the image shown.</li>
                                <li>The date of delivery is provisional as it is transported through third party courier partners.</li>
                                <li>We try to get the gift delivered close to the provided date. However, your gift may be delivered prior or after the selected date of delivery.</li>
                                <li>To maintain the element of surprise on gift arrival, our courier partners do not call prior to delivering an order, so we request that you provide an address at which someone will be present to receive the package.</li>
                                <li>Delivery may not be possible on Sundays and National Holidays.</li>
                                <li>For out of Harare deliveries, custom charges might be levied which are payable by the recipient.</li>
                            </ul>
                        </div>
                        <div class="row no-gutters border-top py-3">
                            <div class="d-flex align-items-center w-100">
                                <h6 class="font-600 my-0 py-0 text-uppercase text-faded">Customer reviews</h6>
                                @if($reviews->count() > 5)
                                <h6 class="text-inverse font-500 ml-auto my-0 py-0 toggle-reviews">
                                    <a class="view-reviews" href="javascript:void()">
                                        <span class="d-flex align-items-center text-faded font-600">
                                            See less
                                            <i class="ion ion-chevron-up mt-1 ml-2 mr-1"></i>
                                        </span>
                                    </a>
                                    <a class="view-reviews d-none" href="javascript:void()">
                                        <span class="d-flex align-items-center text-faded font-600">
                                            See more
                                            <i class="ion ion-chevron-down mt-1 ml-2 mr-1"></i>
                                        </span>
                                    </a>
                                </h6>
                                @endif
                            </div>
                            <div id="product-reviews" class="col-12 col-md-10 mt-md-3">
                                @if (count($reviews) > 0)
                                    <!-- Product reviews will be shown here -->
                                    @foreach ($reviews as $review)
                                        <!-- Product Review -->
                                        <div class="media review-post">
                                            <img src="/storage/users/{{ $review->profile_pic }}" alt="{{ $review->name }}" height="40" width="40" class="rounded-circle align-self-start mt-2 mr-2">
                                            <div class="media-body">
                                                <div class="d-block user-details">
                                                    <p class="font-500 text-capitalize my-0 py-0">{{ $review->name }}</p>
                                                    {{ verifiedPurchase($review->gift_id, $review->user_id)  }}
                                                    {!! customerRating($review->id, $review->gift_id, $review->user_id) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- User\'s Post -->
                                        <div class="customer-post">
                                            <p class="text-justify text-faded">
                                                {{ $review->customer_review }}
                                            </p>
                                            <p class="text-sm text-faded">
                                                {!! reviewLikes($review->id, $review->gift_id) !!}
                                            </p>
                                            <div class="mt-2 post-actions border-top border-bottom w-100 py-2">
                                                <span>
                                                    @auth
                                                        {!! helpful_btn($review->id, $review->gift_id, Auth::user()->id) !!}
                                                    @endauth
                                                    @guest
                                                        <div class="d-flex d-cursor align-items-center text-sm mx-md-4 text-faded review-action" data-url="" data-toggle="modal" href="#write-review">
                                                            <i class="tiny material-icons mr-1">thumb_up</i>
                                                            <span class="d-none d-md-inline">helpful</span>
                                                        </div>
                                                    @endguest
                                                </span>
                                                <span class="mx-md-4">
                                                    @auth
                                                        {!! unhelpful_btn($review->id, $review->gift_id, Auth::user()->id) !!}
                                                    @endauth
                                                    @guest
                                                        <div class="d-flex d-cursor align-items-center text-sm mx-md-4 text-faded review-action" data-url="" data-toggle="modal" href="#write-review">
                                                            <i class="tiny material-icons mr-1">thumb_down</i>
                                                            <span class="d-none d-md-inline">unhelpful</span>
                                                        </div>
                                                    @endguest
                                                </span>
                                                <div class="d-flex d-cursor align-items-center text-sm text-faded review-action toggle-comments" data-post_id="{{ $review->id }}" data-user_id="{{ $review->user_id }}">
                                                    <i class="tiny material-icons mr-1">sms</i> comment
                                                </div>
                                                <div class="d-flex d-cursor align-items-center text-sm text-faded ml-md-auto toggle-comments" data-post_id="{{ $review->id }}" data-user_id="{{ $review->user_id }}">
                                                    <i class="tiny material-icons mr-1">forum</i> <span class="d-none d-md-inline mr-1">Comments</span> ({{ countReviewComments($review->id) }})
                                                </div>
                                            </div>
                                            <!-- Commend section -->
                                            <div class="comment-section my-2" id="comment-box{{ $review->id }}">
                                                <div id="old-comments{{ $review->id }}">
                                                    <!-- Review comments will show up here -->
                                                </div>
                                                @auth
                                                    <!-- Comment form -->
                                                    <div class="d-flex align-items-center">
                                                        <img src="/storage/users/{{ Auth::user()->profile_pic }}" height="30" width="30" alt="" class="rounded-circle mr-1">
                                                        <input type="text" class="form-control form-control-sm comment-input rounded-pill" placeholder="Press enter to submit comment" name="add-comment" id="add-comment{{ $review->id }}" data-post_id="{{ $review->id }}" data-user_id="{{ $review->user_id }}" required>
                                                        <div class="send-btn d-sm-inline-block d-md-none" id="send-btn{{ $review->id }}">
                                                            <button type="button" class="btn btn-primary btn-sm rounded-circle ml-1 comment-btn d-grid" id="send-btn{{ $review->id }}" data-post_id="{{ $review->id }}" data-user_id="{{ $review->user_id }}">
                                                                <i class="material-icons text-white m-auto">send</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- /.comment form -->
                                                @endauth
                                            </div>
                                            <!-- /.Commend section -->
                                        </div>
                                        <!-- /.User\'s Post -->
                                        <!-- /.Product review -->
                                    @endforeach
                                @else
                                    <div class="row justify-content-center my-5">
                                        <div class="col-10 col-md-12 text-center no-content">
                                            <i class="material-icons text-muted lead">forum</i>
                                            <h5 class="font-600">There are no gift reviews to show at the moment.</h5>
                                            @auth
                                                <p class="text-sm">
                                                    Post your review about this gift. It helps others in deciding 
                                                    to purchase this gift
                                                </p>
                                            @endauth
                                            @guest
                                                <p class="text-sm">
                                                    Sign in to post your review about this gift. It helps others in deciding 
                                                    to purchase this gift
                                                </p> 
                                            @endguest
                                            <a href="#" class="btn btn-primary btn-sm px-3">Post a review</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Product Ratings & Reviews -->
            </div>
            <!-- Customize product -->
            <div class="col-12 col-xl-4 pb-2 customizing-panel">
                <h5 class="font-600 my-0 py-0">Accessories that go with this gift</h5>
                <ul class="nav nav-pills my-3" id="customizing-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-pills active" id="pills-customize-tab" data-toggle="pill" href="#pills-customize" role="tab" aria-controls="pills-customize" aria-selected="true">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="material-icons">local_library</i>
                                <span class="text-sm ml-1">cards</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-pills" id="pills-accesssories-tab" data-toggle="pill" href="#pills-accessories" role="tab" aria-controls="pills-accessories" aria-selected="false">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="material-icons">cake</i>
                                <span class="text-sm ml-1">add-ons</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-pills" id="pills-wrappers-tab" data-toggle="pill" href="#pills-wrappers" role="tab" aria-controls="pills-wrappers" aria-selected="false">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="material-icons">card_giftcard</i>
                                <span class="text-sm ml-1">wrappers</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="customizing-tabContent">
                    <div class="tab-pane fade show active" id="pills-customize" role="tabpanel" aria-labelledby="pills-customize-tab">
                        <h5 class="font-600">Add a custom greeting card</h5>
                        <div class="accessories-grid w-100" id="greeting-cards">
                            <!-- Greeting cards will show up here -->
                            @foreach ($greeting_cards as $gift)
                                <?php
                                    // Gift star rating
                                    $star_rating = giftStarRating($gift->id);

                                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                                    $short_name = mb_strimwidth($gift->gift_name, 0, 20, '..');

                                    $gift_usd_price = explode('.', $gift->usd_price);
                                    $usd_notes = $gift_usd_price[0];
                                    $usd_cents =  $gift_usd_price[1]; 

                                    $gift_zar_price = explode('.', $gift->zar_price);
                                    $zar_notes = $gift_zar_price[0];
                                    $zar_cents =  $gift_zar_price[1]; 

                                    $gift_zwl_price = explode('.', $gift->zwl_price);
                                    $zwl_notes = $gift_zwl_price[0];
                                    $zwl_cents =  $gift_zwl_price[1]; 

                                    $usd_price = number_format($gift->usd_price, 2);
                                    $zar_price = number_format($gift->zar_price, 2);
                                    $zwl_price = number_format($gift->zwl_price, 2);
                                ?>
                                <!-- Greeting Cards -->
                                <div class="greeting-gift-card">
                                    <a href="{{ route('details.show', [$gift->slug, $gift->id]) }}" title="View details">
                                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="100" class="card-img-top greeting-card-img pulse rounded-0">
                                    </a>
                                    <h6 class="font-500 text-capitalize mt-1 mb-0 pb-0">{{ $short_name }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="font-600 my-0 py-0 card-price-tag">
                                            <span class="currency-notes usd-price">
                                                US${{ $usd_notes }}<sup class="font-700">{{ $usd_cents }}</sup>
                                            </span>
                                            <span class="currency-notes zar-price d-none">
                                                R{{ $zar_notes }}<sup class="font-700">{{ $zar_cents }}</sup>
                                            </span>
                                            <span class="currency-notes zwl-price d-none">
                                                ZW${{ $zwl_notes }}<sup class="font-700">{{ $zwl_cents }}</sup>
                                            </span>
                                        </h5>
                                        <input value="{{ $gift->id }}" id="product_id" type="hidden">
                                        <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                                        <input value="{{ $usd_price }}" id="usd-price{{ $gift->id }}" type="hidden">
                                        <input value="{{ $zar_price }}" id="zar-price{{ $gift->id }}" type="hidden">
                                        <input value="{{ $zwl_price }}" id="zwl-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_usd_price" value="{{ $sale_usd_price ?? ''}}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_zar_price" value="{{ $sale_zar_price ?? ''}}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_zwl_price" value="{{ $sale_zwl_price ?? ''}}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                                        <input name="end-time" value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                                        <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                                        <input type="hidden" name="sale-end-date" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                                        <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                                        <button class="btn btn-sm btn-outline-primary d-grid rounded-0 add-card-btn" data-id="{{ $gift->id }}" data-label="{{ $gift->label }}">
                                            <i class="material-icons m-auto">add</i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.Greeting Cards -->
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-accessories" role="tabpanel" aria-labelledby="pills-accessories-tab">
                        <h5 class="font-600">Make it extra special</h5>
                        <div class="accessories-grid w-100" id="accessories">
                            <!-- All product add-ons will be shown here -->
                            @foreach ($accesories as $gift)
                                <?php
                                    // Gift star rating
                                    $star_rating = giftStarRating($gift->id);

                                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                                    $short_name = mb_strimwidth($gift->gift_name, 0, 20, '..');

                                    $gift_usd_price = explode('.', $gift->usd_price);
                                    $usd_notes = $gift_usd_price[0];
                                    $usd_cents =  $gift_usd_price[1]; 

                                    $gift_zar_price = explode('.', $gift->zar_price);
                                    $zar_notes = $gift_zar_price[0];
                                    $zar_cents =  $gift_zar_price[1]; 

                                    $gift_zwl_price = explode('.', $gift->zwl_price);
                                    $zwl_notes = $gift_zwl_price[0];
                                    $zwl_cents =  $gift_zwl_price[1]; 

                                    $usd_price = number_format($gift->usd_price, 2);
                                    $zar_price = number_format($gift->zar_price, 2);
                                    $zwl_price = number_format($gift->zwl_price, 2);
                                ?>
                                <!-- Greeting Cards -->
                                <div class="greeting-gift-card">
                                    <a href="/details/{{ $gift->slug }}/{{ $gift->id }}" title="View details">
                                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="100" class="card-img-top greeting-card-img pulse rounded-0">
                                    </a>
                                    <h6 class="font-500 text-capitalize mt-1 mb-0 pb-0">{{ $short_name }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="font-600 my-0 py-0 card-price-tag">
                                            <span class="currency-notes usd-price">
                                                US${{ $usd_notes }}<sup class="font-700">{{ $usd_cents }}</sup>
                                            </span>
                                            <span class="currency-notes zar-price d-none">
                                                R{{ $zar_notes }}<sup class="font-700">{{ $zar_cents }}</sup>
                                            </span>
                                            <span class="currency-notes zwl-price d-none">
                                                ZW${{ $zwl_notes }}<sup class="font-700">{{ $zwl_cents }}</sup>
                                            </span>
                                        </h5>
                                        <input value="{{ $gift->id }}" id="product_id" type="hidden">
                                        <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                                        <input value="{{ $usd_price }}" id="usd-price{{ $gift->id }}" type="hidden">
                                        <input value="{{ $zar_price }}" id="zar-price{{ $gift->id }}" type="hidden">
                                        <input value="{{ $zwl_price }}" id="zwl-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_usd_price" value="{{ $sale_usd_price ?? ''}}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_zar_price" value="{{ $sale_zar_price ?? ''}}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_zwl_price" value="{{ $sale_zwl_price ?? ''}}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                                        <input name="end-time" value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                                        <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                                        <input type="hidden" name="sale-end-date" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                                        <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                                        <button class="btn btn-sm btn-outline-primary d-grid rounded-0 add-card-btn" data-id="{{ $gift->id }}" data-label="{{ $gift->label }}">
                                            <i class="material-icons m-auto">add</i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.Greeting Cards -->
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-wrappers" role="tabpanel" aria-labelledby="pills-wrappers-tab">
                        <h5 class="font-600">Choose your gift wrapper</h5>
                        <div class="accessories-grid w-100" id="gift-wrappers">
                            <!-- All gift wrappers will be shown here -->
                            @foreach ($wrappers as $gift)
                                <?php
                                    // Gift star rating
                                    $star_rating = giftStarRating($gift->id);

                                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                                    $short_name = mb_strimwidth($gift->gift_name, 0, 20, '..');

                                    $gift_usd_price = explode('.', $gift->usd_price);
                                    $usd_notes = $gift_usd_price[0];
                                    $usd_cents =  $gift_usd_price[1]; 

                                    $gift_zar_price = explode('.', $gift->zar_price);
                                    $zar_notes = $gift_zar_price[0];
                                    $zar_cents =  $gift_zar_price[1]; 

                                    $gift_zwl_price = explode('.', $gift->zwl_price);
                                    $zwl_notes = $gift_zwl_price[0];
                                    $zwl_cents =  $gift_zwl_price[1]; 

                                    $usd_price = number_format($gift->usd_price, 2);
                                    $zar_price = number_format($gift->zar_price, 2);
                                    $zwl_price = number_format($gift->zwl_price, 2);
                                ?>
                                <!-- Greeting Cards -->
                                <div class="greeting-gift-card">
                                    <a href="/details/{{ $gift->slug }}/{{ $gift->id }}" title="View details">
                                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="100" class="card-img-top greeting-card-img pulse rounded-0">
                                    </a>
                                    <h6 class="font-500 text-capitalize mt-1 mb-0 pb-0">{{ $short_name }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="font-600 my-0 py-0 card-price-tag">
                                            <span class="currency-notes usd-price">
                                                US${{ $usd_notes }}<sup class="font-700">{{ $usd_cents }}</sup>
                                            </span>
                                            <span class="currency-notes zar-price d-none">
                                                R{{ $zar_notes }}<sup class="font-700">{{ $zar_cents }}</sup>
                                            </span>
                                            <span class="currency-notes zwl-price d-none">
                                                ZW${{ $zwl_notes }}<sup class="font-700">{{ $zwl_cents }}</sup>
                                            </span>
                                        </h5>
                                        <input value="{{ $gift->id }}" id="product_id" type="hidden">
                                        <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                                        <input value="{{ $usd_price }}" id="usd-price{{ $gift->id }}" type="hidden">
                                        <input value="{{ $zar_price }}" id="zar-price{{ $gift->id }}" type="hidden">
                                        <input value="{{ $zwl_price }}" id="zwl-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_usd_price" value="{{ $sale_usd_price ?? ''}}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_zar_price" value="{{ $sale_zar_price ?? ''}}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                                        <input name="sale_zwl_price" value="{{ $sale_zwl_price ?? ''}}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                                        <input name="end-time" value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                                        <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                                        <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                                        <input type="hidden" name="sale-end-date" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                                        <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                                        <button class="btn btn-sm btn-outline-primary d-grid rounded-0 add-card-btn" data-id="{{ $gift->id }}" data-label="{{ $gift->label }}">
                                            <i class="material-icons m-auto">add</i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.Greeting Cards -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.Customize product -->
        </div>

        <!-- Related Gifts -->
        <div class="container-fluid border-top">
            <!-- Related gifts will be shown here -->
            {!! relatedGifts($id, categoryId($id)) !!}
        </div>
        <!-- /.Related Gifts -->
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')

@auth
<!-- Review Modal -->
<div class="modal text-sm p-0" id="write-review" tabindex="-1" role="dialog" aria-labelledby="write-review" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content box-shadow-sm rounded-2">
            <div class="modal-header border-bottom d-block py-1 box-shadow-sm">
                <h5 class="font-400 my-0 py-0">Write a review</h5>
                <p class="font-400 my-0 py-0 text-capitalize" id="product-name"></p>
            </div>
            <div class="modal-body">
                <div class="media mb-2">
                    <img src="/storage/users/{{ Auth::user()->profile_pic }}" height="30" width="30" alt="" class="rounded-circle align-self-start mr-2 mt-1">
                    <div class="media-body">
                        <p class="font-600 my-0 py-0 text-capitalize">{{ Auth::user()->name }}</p>
                        <p class="text-muted my-0 py-0">Posting publicly</p>
                        <div class="d-flex align-items-center my-1">
                            <div id="user-rating"></div>
                            <span class="ml-2 font-500 text-faded"></span>
                        </div>
                    </div>
                </div>
                <form action="" method="post" id="ratingForm">
                    <textarea name="user-review" id="user-review" cols="30" rows="7" class="form-control rounded-2 font-400 w-100" placeholder="Your feedback helps others to purchase this gift." onkeyup="emptyReview(this)"></textarea>
                    <input type="hidden" name="product-id" id="product-id" value="{{ $gift->id }}">
                    <input type="hidden" class="text-capitalize" name="product-name" id="product-name" value="{{ $gift->gift_name }}">
                    <input type="hidden" id="star-rating" name="star-rating">
                    <input type="hidden" name="action" value="post-review">
                    <div class="d-flex align-items-center justify-content-end mt-2">
                        <a role="button" href="javascript:void()" class="btn btn-link font-500" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm px-3 ml-2 font-500" id="submit-review" disabled>Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.Review Modal -->
@endauth

@guest
<!-- SigninFirst Modal -->
<div class="modal text-sm p-0" id="write-review" tabindex="-1" role="dialog" aria-labelledby="write-review" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content p-0">
            <div class="modal-header pt-0 pb-1 shadow-sm">
                <div class="modal-title d-block" id="exampleModalLabel">
                    <h5 class="mb-0 p-3">Want to contribute?</h5>
                    <small class="mt-0 write-review-title text-capitalize">
                    </small>
                </div>
                <button type="button" class="close mt-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">
                    You need to be signed in with your account to have your contributions about 
                    <span class="text-primary text-capitalize">{{ $title }}</span> saved.
                </p>
                <div class="row justify-content-center w-100 px-0 mx-0">
                    <div class="col">
                        <a role="button" href="/login" class="btn border-primary text-primary btn-sm btn-block font-600">
                            Sign in
                        </a>
                    </div>
                    <div class="col">
                        <a role="button" href="/register" class="btn btn-primary btn-sm btn-block font-600 ml-1">
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

<script>
    var _token = $('input[name="_token"]').val();
</script>