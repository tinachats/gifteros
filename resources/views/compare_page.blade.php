@include('layouts.includes.header')
@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">Gift Comparisons</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item d-none d-md-inline">
                        <a href="index.php" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ Session::has('comparisons') ? count(Session::get('comparisons')) : 0 }} Comparisons</li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid justify-content-center mb-5">
        @if(Session::get('comparisons'))
            <div class="d-grid grid-3 grid-p-1">
                @foreach (Session::get('comparisons') as $key => $value)
                    @php
                        // Gift Rating
                        $gift_rating = number_format(giftRating($value['gift_id']), 1);
                    @endphp
                    <div class="card rounded-2 box-shadow-sm">
                        <img src="/storage/gifts/{{ $value['gift_image'] }}" alt="{{ $value['gift_name'] }}" class="card-img-top rounded-2" height="270">
                        <div class="card-body mt-0 pt-0 rounded-bottom-2">
                            <h5 class="font-600 text-capitalize text-faded mb-0 pb-0">
                                {{ $value['gift_name'] }}
                            </h5>
                            <p class="font-500 text-faded text-capitalize my-0 py-0">
                                {{ $value['category_name'] }}
                            </p>
                            <div class="d-flex justify-content-between">
                                {!! giftStarRating($value['gift_id']) !!}
                                <div class="d-inline-block">
                                    <span class="badge badge-success text-white badge-pill px-2 py-1">
                                        {{ $value['gift_units'] }} In Stock
                                    </span>
                                </div>
                            </div>
                            <p class="usd-price font-600 text-faded text-capitalize my-0 pt-0 pb-1">
                                Product Price: US${{ $value['usd_price'] }}
                            </p>
                            <p class="zar-price d-none font-600 text-faded text-capitalize my-0 pt-0 pb-1">
                                Product Price: R{{ $value['zar_price'] }}
                            </p>
                            <p class="zwl-price d-none font-600 text-faded text-capitalize my-0 pt-0 pb-1">
                                Product Price: ZW${{ $value['zwl_price'] }}
                            </p>
                            <input name="hidden_id" value="{{ $value['gift_id'] }}" id="gift_id" type="hidden">
                            <input name="hidden_name" value="{{ $value['gift_name'] }}" id="name{{ $value['gift_id'] }}" type="hidden">
                            <input name="hidden_image" value="{{ $value['gift_image'] }}" id="image{{ $value['gift_id'] }}" type="hidden">
                            <input name="usd-price" value="{{ $value['usd_price'] }}" id="usd-price{{ $value['gift_id'] }}" type="hidden">
                            <input name="zar-price" value="{{ $value['zar_price'] }}" id="zar-price{{ $value['gift_id'] }}" type="hidden">
                            <input name="zwl_price" value="{{ $value['zwl_price'] }}" id="zwl-price{{ $value['gift_id'] }}" type="hidden">
                            <input name="category_name" value="{{ $value['category_name'] }}" id="category-name{{ $value['gift_id'] }}" type="hidden">
                            <input name="gift_units" value="{{ $value['gift_units'] }}" id="product-units{{ $value['gift_id'] }}" type="hidden">
                            <input name="hidden_quantity" value="1" id="quantity{{ $value['gift_id'] }}" type="hidden">
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <button class="btn btn-warning btn-sm btn-block font-600 d-flex align-items-center justify-content-center add-to-cart-btn mr-1" data-id="{{ $value['gift_id'] }}">
                                    <i class="material-icons mr-1">add_shopping_cart</i>
                                    Add to Cart
                                </button>
                                <a role="button" href="details.php?id={{ $value['gift_id'] }}" class="btn btn-primary btn-sm btn-block font-600 d-flex align-items-center justify-content-center m-0">
                                    <i class="material-icons mr-1">assignment</i> Details
                                </a>
                            </div>
                            <hr class="bg-inverse my-0">
                            <h6 class="font-600 text-faded mt-2">Description:</h6>
                            <p class="text-justify text-faded text-sm">
                                {{ $value['gift_description'] }}
                            </p>
                            <hr class="bg-inverse my-0">
                            <h6 class="font-600 text-faded mt-2">Customer Ratings:</h6>
                            <div class="d-flex justify-content-center align-items-center review-metrics">
                                <h5 class="display-4 m-0 p-0 rating-score font-600">{{ number_format(giftRating($value['gift_id']), 1) }}</h5>
                                <div class="d-md-block d-sm-flex lh-100">
                                    {!! giftStarRating($value['gift_id']) !!}
                                    <div class="d-flex justify-content-center align-items-center reviewers font-600 text-muted mt-0">
                                        <i class="material-icons text-muted mr-1">people</i> <span class="total-ratings mr-1 text-muted">{{ countRatings($value['gift_id']) }}</span> total
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-inverse my-0">
                            <h6 class="font-600 text-faded mt-2">Product Reviews:</h6>
                            <!-- Product Review -->
                            {!! giftReviews($value['gift_id']) !!}
                            <!-- /.Product review -->
                            <hr class="bg-inverse mb-0 mt-2">
                            <h6 class="font-600 text-faded mt-2">Product Stats:</h6>
                            <div class="d-flex align-items-center justify-content-around">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons text-faded">add_shopping_cart</i>
                                    <span class="text-faded">{{ giftsSold($value['gift_id']) }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons text-faded">account_balance_wallet</i>
                                    <span class="text-faded">${{ totalproductAmt($value['gift_id']) }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons text-faded">favorite_border</i>
                                    <span class="text-faded">{{ totalWishes($value['gift_id']) }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons text-faded">forum</i>
                                    <span class="text-faded">{{ countRatings($value['gift_id']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-md-start justify-content-sm-center my-3">
                <button class="btn btn-primary d-flex align-items-center expire-session">
                    <i class="material-icons mr-1">arrow_back</i>
                    <span class="font-500 text-white">Continue shopping</span>
                </button>
            </div>
        @else 
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center">
                    <div class="bg-whitesmoke box-shadow-sm rounded-2 p-3">
                        <i class="material-icons fa-5x">alarm_off</i>
                        <h5 class="font-600">Comparison Session Expired</h5>
                        <p>Your gift comparison session expired. Go back to select gifts to compare.</p>
                        <a href="/" role="button" class="btn btn-link d-flex align-items-center px-3">
                            <i class="material-icons mr-1">arrow_back</i> Go back
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')