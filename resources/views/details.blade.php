@include('layouts.includes.main-nav')
@php
    use Illuminate\Support\Str;
@endphp
<style>
    .navbar.sticky-top {
        height: 45px
    }
    .nav-buttons{
        margin-top: 0px
    }
    .sticky-nav-item.active {
        border-bottom: 2px solid var(--danger-warning)
    }
    .sticky-nav-item.active a{
        color: var(--danger-warning) !important
    }
    .page-navbar{
        z-index: 999 !important
    }
    .affix{
        position: fixed;
        top: 0;
        width: 100%
    }

    .affix + .page-content{
        padding-top: 60px
    }

    .grid-pane{
        margin-top: 5px;
        grid-template-columns: 1fr 3fr 2fr;
        grid-column-gap: .7rem
    }
    .trending-list>li:first-child{
        margin-bottom: .25rem
    }
    .gift-star-rating{
        display: flex;
        align-items: center;
        margin-top: 15px
    }
    .gift-star-rating>li:first-child{
        margin-left: 0
    }
    .gift-star-rating>li.list-inline-item{
        margin-left: -10px
    }
    .progress-bar-rating{
        margin-top: -2rem
    }
    .rating-metrics,
    .customer-votes{
        margin-top: -10px
    }
    .display-4 {
        font-size: 3.5rem !important;
        font-weight: 300 !important;
        line-height: 1.2;
    }
    .media-img{
        position: relative;
    }
    .review-country{
        position: absolute;
        bottom: 0;
        right: 4px
    }
    /*set a border on the images to prevent shifting*/
        
    .product-images {
        position: relative;
        display: flex;
    }
    
    #product-img,
    .zoomWindow,
    .active img {
        box-shadow: var(--shadow-sm) !important;
    }
    
    .zoomWindow,
    .zoomLens {
        border: 1px solid var(--warning) !important;
    }
    
    #gallery img {
        display: flex;
        justify-content: space-between;
        height: 70px;
        width: 70px;
        border: 2px solid var(--border-color);
    }
    /*Change the colour*/
    
    #gallery img.active{
        border: 2px solid var(--warning) !important;
    }
    
    .accessory>img {
        border: 0 !important
    }
    
    .action-icons {
        font-size: 3.5rem !important;
    }
    
    #customizing-tab>li>a,
    #customizing-tab>li>a {
        color: var(--dark);
    }
    
    #customizing-tab>li>a.active>div>i,
    #customizing-tab>li>a.active>div>span,
    #customizing-tab>li>a.active>div>p {
        color: #fff !important
    }
    
    .review-metrics {
        grid-template-columns: 1fr 2fr;
    }
    
    .comment-section {
        display: none;
    }
    
    .review-post {
        margin-bottom: 10px;
    }
    
    .review-post:last-child {
        margin-bottom: 0;
    }

    .custom-option,
    .custom-option.inactive{
        border: 2px solid var(--border-color);
        border-radius: .25rem;
    }
    .custom-option.active{
        border: 2px solid var(--danger-warning);
    }

    .custom-option .size,
    .custom-option.inactive .size{
        color: var(--border-color);
    }

    .custom-option.active .size{
        color: var(--danger-warning);
    }

    a:hover .size-info,
    a.active .size-info{
        color: var(--danger-warning);
    }

    .popover{
        width: max-content
    }
    
    @media(min-width: 768px) {
        .details-section {
            border-right: 1px solid var(--bg-inverse);
        }
        .product-images {
            align-items: flex-start;
            margin-top: 0rem;
            margin-left: 5rem;
        }
        .zoomWrapper,
        .product-images,
        #product-img,
        .zoomWindowContainer {
            height: 295px !important;
            width: 300px !important;
            z-index: 999999 !important
        }
        .zoomWindow {
            margin-left: 1rem !important;
        }
        .zoomLens {
            height: 200px !important;
            width: 200px !important;
        }
        #gallery {
            position: absolute;
            height: 295px;
            left: -80px;
            top: 0;
        }
        #gallery img {
            flex-direction: column;
            margin-bottom: 5px;
        }
        .post-actions {
            display: flex;
            align-items: center;
        }
    }
</style>
<!-- Page Content -->
<div class="container page-content">
    <!-- Content Header (Page header) -->
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="font-600 m-0 p-0">Details</h5>
        <ol class="breadcrumb float-sm-right bg-transparent">
            <li class="breadcrumb-item d-flex align-items-center">
                <a href="/" class="d-flex align-items-center text-primary">
                    <i class="material-icons mr-1">store</i>
                    <span class="d-none d-md-inline text-primary">Store</span>
                </a>
            </li>
            <li class="breadcrumb-item text-capitalize">
                <a href="">{{ categoryName($id) }}</a>
            </li>
            <li class="breadcrumb-item active">{{ Str::words($title, 2, '...') }}</li>
        </ol>
    </div>
    <!-- /.content-header -->

    {{-- Gift Details & Imagery --}}
    <div class="row">
        <div class="col-12 col-md-8 details-section">
            <!-- Product Info -->
            <div class="row no-gutters">
                <div class="col-12 col-md-6 product-gallery">
                    <!-- Product Images -->
                    <div class="product-images">
                        <img class="border border-warning" id="product-img" src="/storage/gifts/{{ $gift->gift_image }}" data-zoom-image="/storage/gifts/{{ $gift->gift_image }}" />
                        <div id="gallery">
                            <a href="#" data-image="/storage/gifts/{{ $gift->gift_image }}" data-zoom-image="/storage/gifts/{{ $gift->gift_image }}">
                                <img src="/storage/gifts/{{ $gift->gift_image }}" />
                            </a>
                            <a href="#" data-image="/storage/gifts/15f47c4f06e6bb.webp" data-zoom-image="/storage/gifts/15f47c4f06e6bb.webp">
                                <img src="/storage/gifts/15f47c4f06e6bb.webp" />
                            </a>
                            <a href="#" data-image="/storage/gifts/15f47b9066c522.jpg" data-zoom-image="/storage/gifts/15f47b9066c522.jpg">
                                <img src="/storage/gifts/15f47b9066c522.jpg" />
                            </a>
                            <a href="#" data-image="/storage/gifts/15f47cc7680adc.webp" data-zoom-image="/storage/gifts/15f47cc7680adc.webp">
                                <img src="/storage/gifts/15f47cc7680adc.webp" />
                            </a>
                        </div>
                    </div>
                    <!-- /.Product Images -->
                </div>
                <!-- Product Details -->
                <div class="col-12 col-md-6 pl-md-5 product-details">
                    <div class="d-block">
                        <h6 class="font-500 lead text-capitalize mb-0 pb-0" id="product-title">{{ $title }}</h6>
                        <p class="text-capitalize text-faded my-0 py-0">Category: {{ categoryName($id) }}</p>
                        <div class="d-flex align-items-center">
                            <ul class="list-inline align-items-center gift-star-rating ml-2 my-0 py-0">
                                <li class="list-inline-item text-warning">&starf;</li>
                                <li class="list-inline-item text-warning">&starf;</li>
                                <li class="list-inline-item text-warning">&starf;</li>
                                <li class="list-inline-item text-warning">&starf;</li>
                                <li class="list-inline-item text-faded">&star;</li>
                                <span class="text-sm text-faded font-600">(128)</span>
                            </ul>
                            <label class="badge badge-success badge-pill px-2 py-1 ml-3 my-0">In Stock</label>
                        </div>
                        <hr class="border-inverse my-2">
                        <h6 class="font-600 text-capitalize mb-0 pb-0">About this item</h6>
                        @isset($gift->description)
                            <p class="text-sm text-faded text-justify my-0 py-0">
                                {!! Str::words($gift->description, 15, '...<a class="text-primary" href="#nav-overview">Read more</a>') !!}
                            </p>
                        @endisset
                        @empty($gift->description)
                            No any info found that describes this gift item.
                            Contact our customer care service.
                        @endempty
                        <hr class="border-inverse my-2">
                        <div class="d-flex justify-content-center w-100">
                            <div class="us-prices text-center w-50">
                                <p class="font-600 text-sm text-uppercase text-faded my-0 py-0">price in usd</p>
                                <h5 class="lead font-600 my-0 py-0">${{ number_format($gift->usd_price, 2) }}</h5>
                            </div>
                            <div class="border-right mx-3"></div>
                            <div class="zw-prices text-center w-50">
                                <p class="font-600 text-sm text-uppercase text-faded my-0 py-0">price in zwl</p>
                                <h5 class="lead font-600 my-0 py-0">${{ number_format($gift->usd_price * zwRate(), 2) }}</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-around">
                            <span role="button" class="material-icons text-success action-icons">remove_circle</span>
                            <span class="display-4 font-500 text-success">1</span>
                            <span role="button" class="material-icons text-success action-icons">add_circle</span>
                        </div>
                        <p class="text-sm text-muted">
                            Additional 2% off for purchase of 12 items or more.
                            <span class="text-muted">{{ $gift->units }} items available</span>
                        </p>
                    </div>
                </div>
                <!-- /.Product Details -->
            </div>
            <!-- /.Product Info -->
        </div>
        <!-- Customize product -->
        <div class="col-12 col-md-4">
            {{-- Item Colors --}}
            <div class="custom-category">
                <h6 class="text-sm font-600">
                    Color:<span class="ml-1" id="selected-color">Blue</span>
                </h6>
                <div class="d-grid grid-6 grid-p-1">
                    <img src="/storage/gifts/{{ $gift->gift_image }}" height="50" width="50" alt="" class="custom-option active">
                    @for ($i = 0; $i < 9; $i++)
                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="50" width="50" alt="" class="custom-option">
                    @endfor
                </div>
            </div>
            {{-- /.Item Colors --}}

            {{-- Shoe Sizes --}}
            <div class="custom-category my-2">
                <h6 class="text-sm font-600">
                    Shoe Size:<span class="ml-1" id="selected-size">43</span>
                </h6>
                <div class="d-grid grid-6 grid-p-1">
                    <div class="d-grid custom-size custom-option active">
                        <div class="m-auto">
                            <div class="m-auto">
                                <span class="size">35</span>
                            </div>
                        </div>
                    </div>
                    @for ($i = 35; $i < 45; $i++)
                        <div class="d-grid custom-size custom-option">
                            <div class="m-auto">
                                <div class="m-auto">
                                    <span class="size">{{ $i }}</span>
                                </div>
                            </div>
                        </div>     
                    @endfor
                </div>
                <a href="#shoes-measurements-modal" class="d-flex align-items-center">
                    <i class="material-icons mr-1">straighten</i>
                    <span class="text-sm size-info">Size info</span>
                </a>
            </div>
            {{-- /.Shoe Sizes --}}

            {{-- Shirts Sizes --}}
            <div class="custom-category my-2">
                <h6 class="text-sm font-600">
                    Size:<span class="ml-1" id="shirt-size">S</span>
                </h6>
                <div class="d-grid grid-6 grid-p-1">
                    <div class="d-grid custom-size custom-option small-size" data-size="s">
                        <div class="m-auto">
                            <span class="size">S</span>
                        </div>
                    </div>
                    <div class="d-grid custom-size custom-option medium-size" data-size="m">
                        <div class="m-auto">
                            <span class="size">M</span>
                        </div>
                    </div>
                    <div class="d-grid custom-size custom-option large-size" data-size="l">
                        <div class="m-auto">
                            <span class="size">L</span>
                        </div>
                    </div>
                    <div class="d-grid custom-size custom-option xlarge-size" data-size="xl">
                        <div class="m-auto">
                            <span class="size">XL</span>
                        </div>
                    </div>
                    <div class="d-grid custom-size custom-option xxlarge-size" data-size="xxl">
                        <div class="m-auto">
                            <span class="size">XXL</span>
                        </div>
                    </div>
                    <div class="d-grid custom-size custom-option xxxlarge-size" data-size="xxxl">
                        <div class="m-auto">
                            <span class="size">XXXL</span>
                        </div>
                    </div>
                    <div class="d-grid custom-size custom-option 4xlarge-size" data-size="4xl">
                        <div class="m-auto">
                            <span class="size">4XL</span>
                        </div>
                    </div>
                </div>
                <a href="#shirts-measurements-modal" class="d-flex align-items-center">
                    <i class="material-icons mr-1">straighten</i>
                    <span class="text-sm size-info">Size info</span>
                </a>
            </div>
            {{-- /.Shirts Sizes --}}
        </div>
        <!-- /.Customize product -->
    </div>
    {{-- /.Gift Details & Imagery --}}
    {{-- Sticky-top Navbar --}}
    @include('layouts.includes.details-sticky-nav')
    {{-- /.Sticky-top Navbar --}}
    <div class="d-grid grid-pane">
        <div class="bg-whitesmoke box-shadow-sm p-2 left-pane">
            <h6 class="font-600">Top Selling</h6>
            <ul class="trending-list">
                {{-- Trending Item --}}
                <li>
                    <div class="card rounded-top-2 box-shadow-sm">
                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" alt="" class="card-img-top">
                        <div class="card-body rounded-bottom-2 pl-1 py-0">
                            <h6 class="text-capitalize font-600 mb-0">{{ Str::words($title, 2, '...') }}</h6>
                            <h6 class="usd-price my-0">US${{ number_format($gift->usd_price, 2) }}</h6>
                            <h6 class="zar-price my-0 d-none">R{{ number_format($gift->usd_price * zaRate(), 2) }}</h6>
                            <h6 class="zwl-price my-0 d-none">ZW${{ number_format($gift->usd_price * zwRate(), 2) }}</h6>
                            <div class="d-block">
                                <span class="text-sm">{!! giftStarRating($id) !!}</span>
                                <span class="text-muted text-sm">{{ giftsSold($id) }} sold</span>
                            </div>
                            <a href="/details/{{ $gift->slug }}/{{ $id }}" class="stretched-link"></a>
                        </div>
                    </div>
                </li>
                {{-- /.Trending Item --}}
                {{-- Trending Item --}}
                <li>
                    <div class="card rounded-top-2 box-shadow-sm">
                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" alt="" class="card-img-top">
                        <div class="card-body rounded-bottom-2 pl-1 py-0">
                            <h6 class="text-capitalize font-600 mb-0">{{ Str::words($title, 2, '...') }}</h6>
                            <h6 class="usd-price my-0">US${{ number_format($gift->usd_price, 2) }}</h6>
                            <h6 class="zar-price my-0 d-none">R{{ number_format($gift->usd_price * zaRate(), 2) }}</h6>
                            <h6 class="zwl-price my-0 d-none">ZW${{ number_format($gift->usd_price * zwRate(), 2) }}</h6>
                            <div class="d-block">
                                <span class="text-sm">{!! giftStarRating($id) !!}</span>
                                <span class="text-muted text-sm">{{ giftsSold($id) }} sold</span>
                            </div>
                            <a href="/details/{{ $gift->slug }}/{{ $id }}" class="stretched-link"></a>
                        </div>
                    </div>
                </li>
                {{-- /.Trending Item --}}
            </ul>
        </div>
        <div class="tab-content main-pane box-shadow-sm bg-whitesmoke p-2" id="nav-tabContent" id="gifts-tabContent">
            <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                <h5 class="font-600 p-2 lead">Gift Description</h5>
                <p class="text-justify p-2">
                    {{ $gift->description ?? 'This gift doesn/t have a gift description. For more info contact customer service.' }}
                </p>
                <div class="p-2">
                    <h6 class="font-600 lead">Disclaimer</h6>
                    <ul class="bulleted-list px-3">
                        <li>Delivered product might vary slightly from the image shown.</li>
                        <li>The date of delivery is provisional as it is transported through third party courier partners.</li>
                        <li>We try to get the gift delivered close to the provided date. However, your gift may be delivered prior or after the selected date of delivery.</li>
                        <li>To maintain the element of surprise on gift arrival, our courier partners do not call prior to delivering an order, so we request that you provide an address at which someone will be present to receive the package.</li>
                        <li>Delivery may not be possible on Sundays and National Holidays.</li>
                        <li>For out of Harare deliveries, custom charges might be levied which are payable by the recipient.</li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="font-600 my-0 text-uppercase text-faded">Customer ratings</h6>
                    <h6>
                        <a class="d-flex align-items-center" href="">
                            <i class="fa fa-info-circle mr-1"></i> Review policy
                        </a>
                    </h6>
                </div>
                <div class="d-block">
                    <div class="d-flex align-items-center">
                        <div class="ml-3 my-0 p-0" id="gift-rating"></div>
                        <h6 class="lead my-0 ml-1">{{ number_format(giftRating($id), 1) }} out of 5</h6>
                    </div>
                    @if (countRatings($id) == 1)
                        <h6 class="my-0 font-600 ml-3 text-muted">1 Customer Rating</h6>
                    @else 
                        <h6 class="my-0 font-600 ml-3 text-muted">
                            <span class="text-muted">{{ countRatings($id) }}</span> Customer Ratings
                        </h6>
                    @endif
                </div>
                {{-- Progress Bar Rating --}}
                <div class="d-md-flex align-items-md-start justify-content-md-around w-md-100 ml-3 mt-4">
                    <div class="flex-column w-75 progress-bars">
                        {{-- Five Star Rating --}}
                        <div class="progress-bar-rating d-flex align-items-center">
                            <ul class="list-inline gift-star-rating">
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                            </ul>
                            <div class="progress progess-sm w-100 mx-2">
                                <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="47" aria-valuemax="100" style="width:47%;">
                                    <span class="text-white font-400">47%</span>
                                </div>
                            </div>
                            <span class="percentage">47%</span>
                        </div>
                        {{-- /.Five Star Rating --}}
                        {{-- Four Star Rating --}}
                        <div class="progress-bar-rating d-flex align-items-center">
                            <ul class="list-inline gift-star-rating">
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                            </ul>
                            <div class="progress progess-sm w-100 mx-2">
                                <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="47" aria-valuemax="100" style="width:47%;">
                                    <span class="text-white font-400">47%</span>
                                </div>
                            </div>
                            <span class="percentage">47%</span>
                        </div>
                        {{-- /.Four Star Rating --}}
                        {{-- Three Star Rating --}}
                        <div class="progress-bar-rating d-flex align-items-center">
                            <ul class="list-inline gift-star-rating">
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                            </ul>
                            <div class="progress progess-sm w-100 mx-2">
                                <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="47" aria-valuemax="100" style="width:47%;">
                                    <span class="text-white font-400">47%</span>
                                </div>
                            </div>
                            <span class="percentage">47%</span>
                        </div>
                        {{-- /.Three Star Rating --}}
                        {{-- Two Star Rating --}}
                        <div class="progress-bar-rating d-flex align-items-center">
                            <ul class="list-inline gift-star-rating">
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                            </ul>
                            <div class="progress progess-sm w-100 mx-2">
                                <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="47" aria-valuemax="100" style="width:47%;">
                                    <span class="text-white font-400">47%</span>
                                </div>
                            </div>
                            <span class="percentage">47%</span>
                        </div>
                        {{-- /.Two Star Rating --}}
                        {{-- One Star Rating --}}
                        <div class="progress-bar-rating d-flex align-items-center">
                            <ul class="list-inline gift-star-rating">
                                <li class="list-inline-item text-gold">&starf;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                                <li class="list-inline-item text-muted">&star;</li>
                            </ul>
                            <div class="progress progess-sm w-100 mx-2">
                                <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="47" aria-valuemax="100" style="width:47%;">
                                    <span class="text-white font-400">47%</span>
                                </div>
                            </div>
                            <span class="percentage">47%</span>
                        </div>
                        {{-- /.One Star Rating --}}
                    </div>
                    <div class="d-block text-center rating-metrics">
                        <h2 class="display-4 my-0 font-300">{{ number_format(giftRating($id), 1) }}</h2>
                        <div class="d-flex align-items-center customer-votes">
                            <i class="material-icons fa-2x">people</i>
                            @if (countRatings($id) == 1)
                                <h6 class="ml-1 font-600 text-muted my-0">1 rating</h6>
                            @else 
                                <h6 class="ml-1 font-600 text-muted my-0">{{ countRatings($id) }} ratings</h6>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- /.Progress Bar Rating --}}
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <a href="#ratings-calculations" class="accordion-header" id="flush-headingOne" role="button" data-toggle="collapse" data-target="#ratings-calculations" aria-expanded="false" aria-controls="ratings-calculations">
                            How are ratings calculated?
                        </a>
                        <div id="ratings-calculations" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                To calculate the overall star rating and percentage breakdown by star, we don’t use a simple average. Instead, our system considers things 
                                like how recent a review is and if the reviewer bought the item on {{ config('app.name') }}. 
                                It also analyzes reviews to verify trustworthiness.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center border-top border-bottom py-3 mt-2">
                    <h6 class="font-600 my-0 py-0 text-uppercase text-faded">Customer reviews</h6>
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
                </div>
                {{-- Customer Reviews --}}
                <div class="container-fluid">
                    <div class="row pb-1">
                        <div id="product-reviews" class="col-12">
                            <!-- Product Review -->
                            <div class="media review-post">
                                <div class="media-img">
                                    <img src="/storage/users/user.png" alt="" height="40" width="40" class="rounded-circle align-self-start mt-2 mr-2">
                                    <img src="/storage/country-flag/flag-of-zimbabwe.png" class="review-country" height="15" width="22" alt="ZW">
                                </div>
                                <div class="media-body">
                                    <div class="d-block user-details">
                                        <p class="text-capitalize text-sm font-600 my-0 py-0">tinashe chaterera</p>
                                        <div class="d-flex align-items-center font-500 text-capitalize text-sm text-faded">
                                            <i class="material-icons text-success">verified_user</i> verified buyer
                                        </div>
                                        <ul class="list-inline gift-star-rating align-items-center ml-2 my-0 py-0">
                                            <li class="list-inline-item text-gold">&starf;</li>
                                            <li class="list-inline-item text-gold">&starf;</li>
                                            <li class="list-inline-item text-gold">&starf;</li>
                                            <li class="list-inline-item text-gold">&starf;</li>
                                            <li class="list-inline-item text-faded">&star;</li>
                                            <span class="text-sm text-faded font-600 text-capitalize">April 13, 2019</span>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- User's Post -->
                            <div class="customer-post">
                                <p class="text-sm font-500 text-justify text-faded">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere et, quas similique ut impedit modi ab! Facere tempora suscipit illo accusantium soluta praesentium, rem velit vitae, odio fugit inventore corrupti alias delectus laudantium est adipisci
                                    veniam repudiandae dolorum commodi quia!
                                </p>
                                <p class="text-sm text-faded">
                                    <span id="helpful-count">0</span> people found this helpful
                                </p>
                                <div class="mt-2 post-actions border-top border-bottom w-100 py-2">
                                    <div class="d-flex d-cursor align-items-center text-sm text-faded review-action">
                                        <i class="tiny material-icons mr-1">thumb_up</i>
                                        <span class="d-none d-md-inline">helpful</span>
                                    </div>
                                    <div class="d-flex d-cursor align-items-center text-sm mx-md-4 text-faded review-action">
                                        <i class="tiny material-icons mr-1">thumb_down</i>
                                        <span class="d-none d-md-inline">unhelpful</span>
                                    </div>
                                    <div class="d-flex d-cursor align-items-center text-sm text-faded review-action toggle-comments">
                                        <i class="tiny material-icons mr-1">sms</i> comment
                                    </div>
                                    <div class="d-flex d-cursor align-items-center text-sm text-faded ml-md-auto toggle-comments">
                                        <i class="fa fa-comments-o mr-1" style="font-size:18px"></i> <span class="d-none d-md-inline mr-1">Comments</span> (45)
                                    </div>
                                </div>
                                <!-- Commend section -->
                                <div class="comment-section my-2">
                                    <!-- Comment -->
                                    <div class="comment mb-2">
                                        <div class="media">
                                            <img src="/storage/users/user.png" height="30" width="30" alt="" class="rounded-circle align-self-start mt-1 mr-2">
                                            <div class="media-body">
                                                <p class="text-capitalize text-sm text-faded font-500 my-0 py-0">tamuka mukocheya</p>
                                                <small class="text-sm text-faded text-capitalize my-0 py-0">april 12, 2020</small>
                                                <br>
                                                <p class="text-sm text-faded text-justify mt-1">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti non eaque accusamus iure alias ea. Totam eius tenetur nisi voluptatum rerum, incidunt sequi consectetur ad libero minus, eum saepe? Quibusdam, dignissimos! Sapiente tenetur possimus veritatis
                                                    consectetur, quibusdam atque?
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.Comment -->
                                    <!-- Comment -->
                                    <div class="comment mb-2">
                                        <div class="media">
                                            <img src="/storage/users/user.png" height="30" width="30" alt="" class="rounded-circle align-self-start mt-1 mr-2">
                                            <div class="media-body">
                                                <p class="text-capitalize text-sm text-faded font-500 my-0 py-0">tamuka mukocheya</p>
                                                <small class="text-sm text-faded text-capitalize my-0 py-0">april 12, 2020</small>
                                                <br>
                                                <p class="text-sm text-faded text-justify mt-1">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti non eaque accusamus iure alias ea. Totam eius tenetur nisi voluptatum rerum, incidunt sequi consectetur ad libero minus, eum saepe? Quibusdam, dignissimos! Sapiente tenetur possimus veritatis
                                                    consectetur, quibusdam atque?
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.Comment -->
                                    <!-- Comment form -->
                                    <form action="" method="post" id="comment-form">
                                        <div class="d-flex align-items-center">
                                            <img src="/storage/users/user.png" height="30" width="30" alt="" class="rounded-circle mr-1">
                                            <input type="text" name="comment" id="comment" class="form-control form-control-sm rounded-pill" placeholder="Press enter to submit comment">
                                        </div>
                                    </form>
                                    <!-- /.comment form -->
                                </div>
                                <!-- /.Commend section -->
                            </div>
                            <!-- /.User's Post -->
                            <!-- /.Product review -->
                        </div>
                    </div>
                </div>
                {{-- /.Customer Reviews --}}
            </div>
            <div class="tab-pane fade" id="nav-related" role="tabpanel" aria-labelledby="nav-related-tab">
                <h5 class="font-600 p-2 lead">Customers who bought this gift also bought</h5>
                 <div class="container-fluid">
                    <!-- Related Gifts Carousel -->
                    <div class="owl-carousel owl-theme ordered-gifts">
                        @for ($i = 0; $i < 8; $i++)
                            <!-- Related Gift -->
                            <div class="item mb-2">
                                <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-2 w-100">
                                    <a href="#">
                                        <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top rounded-top-2">
                                    </a>
                                    <div class="gift-content mx-1">
                                        <a href="#">
                                            <h6 class="my-0 py-0 text-capitalize font-600 text-primary">{{ mb_strimwidth($gift->gift_name, 0, 17, '...') }}</h6>
                                        </a>
                                        <div class="d-inline-block lh-100">
                                            <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->category_name }}</h6>
                                            {!! giftStarRating($id) !!}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h6 class="usd-price text-grey text-sm font-600 mt-2">US${{ number_format($gift->usd_price, 2) }}</h6>
                                            <h6 class="zar-price d-none text-grey text-sm font-600 mt-2">R{{ number_format($gift->zar_price, 2) }}</h6>
                                            <h6 class="zwl-price d-none text-grey text-sm font-600 mt-2">ZW${{ number_format($gift->zwl_price, 2) }}</h6>
                                            <span role="button" class="material-icons fa-2x text-success">add_circle_outline</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Related Gift -->
                        @endfor
                    </div>
                    <!-- /.Related Gifts Carousel -->
                 </div>
            </div>
        </div>
        <div class="bg-whitesmoke box-shadow-sm p-2 right-pane">
            <h6 class="font-600">Frequently bought together</h6>
            {{-- Gift Combinations --}}
            <div class="d-flex align-items-center justify-content-around">
                <img src="/storage/gifts/{{ $gift->gift_image }}" height="70" width="70" alt="" class="rounded">
                <span class="material-icons mx-2">add</span>
                <img src="/storage/gifts/{{ $gift->gift_image }}" height="70" width="70" alt="" class="rounded">
                <div class="flex-column w-100 ml-2">
                    <h6 class="text-muted">
                        Total price: <span class="text-danger font-600">$273.37</span>
                    </h6>
                    <button class="btn btn-default btn-sm btn-block">Add all to Wishlist</button>
                    <button class="btn btn-primary btn-sm btn-block">Add all to Cart</button>
                </div>
            </div>
            {{-- /.Gift Combinations --}}
        </div>
    </div>
</div>
@include('layouts.includes.footer')
<script>
    $(function(){
        var gift_id = {{ $id }};
        var gift_name = "{!! $title !!}";

        // Increment the gift view counter
        viewCounter(gift_id);
        function viewCounter(gift_id){
            var action = 'viewed-gift';
            $.ajax({
                url: '{{ route("gift_views") }}',
                method: 'post',
                data: {
                    action: action,
                    gift_id: gift_id
                },
                success: function(){

                }
            });
        }

        // Fetch wishlist button
        wishlistBtn();
        function wishlistBtn(){
            var action = 'wishlist-btn';
            $.ajax({
                url: '{{ route("wishlist_btn") }}',
                method: 'get',
                data: {
                    action: action,
                    gift_id: gift_id
                },
                dataType: 'json',
                success: function(data){
                    $('#wishlist-btn').html(data.wishlist_btn);
                }
            });
        }

        // Gift rating
        starRating();
        function starRating(){
            $('#gift-rating').rateYo({
                rating:  {{ giftRating($id) }},
                starWidth: "20px",
                spacing: "5px",
                readOnly: true
            });
        }

        // Gift Ratings
        giftRatings();
        function giftRatings(){
            var action = 'gift-ratings';
            $.ajax({
                url: '{{ route("gift_ratings") }}',
                method: 'get',
                data: {
                    action: action,
                    gift_id: gift_id
                },
                dataType: 'json',
                success: function(data){
                    starRating();
                    $('#progress-rating').html(data.progress_rating);
                    $('#gift-star-rating').html(data.star_rating);
                    $('.rated-value').html(data.gift_rating);
                    $('.total-ratings').html(data.count_ratings);
                    $('#gift-reviews').html(data.reviews);
                }
            });
        }

        // Wishlist actions
        $(document).on('click', '.details-wishlist-btn', function() {
            var gift_id = $(this).data('id');
            var user_id = $(this).data('user');
            var action = $(this).data('action');
            $.ajax({
                url: `/${action}`,
                method: 'post',
                data: {
                    action: action,
                    gift_id: gift_id,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(data) {
                    wishlistBtn();
                    userInfo();
                    myWishlist();
                }
            });
        });

        // User product_rating rating
        $("#user-rating").rateYo({
            onSet: function(rating, rateYoInstance) {
                $(this).next().text('Rating of ' + rating);
                $('#star-rating').val(rating);
            },
            normalFill: "#A0A0A0",
            maxValue: 5,
            starWidth: "20px",
            spacing: "10px"
        });

        // Submit a gift rating and review
        $(document).on('submit', '#ratingForm', function(e) {
            e.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: '{{ route("gift_review") }}',
                method: 'post',
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    giftRatings();
                    if (data.message == 'success') {
                        $("#rate-product").rateYo({
                            onSet: function(rating, rateYoInstance) {
                                $(this).next().text(' ');
                                $('#user-rating').val(' ');
                            },
                            rating: 0
                        });
                        $('#ratingForm')[0].reset();
                        $('#write-review').modal('hide');
                        $('#success-icon').html('check_circle');
                        $('#success-message').html('Your rating for <span class="text-capitalize text-white">' + gift_name + '</span> has been submitted.');
                        $('#success-modal').modal('show');
                    } else {
                        $('#success-icon').html('error');
                        $('#success-message').html('Oops! Something went wrong. Try again!');
                        $('#success-modal').modal('show');
                    }
                }
            });
        });

        // Click on the helpful button
        $(document).on('click', '.helpful-btn', function() {
            var rating_id = $(this).data('post');
            var gift_id = $(this).data('id');
            var action = $(this).data('action');
            $.ajax({
                url: `/${action}`,
                method: 'post',
                data: {
                    rating_id: rating_id,
                    gift_id: gift_id,
                    action: action,
                    notification_type: 'like'
                },
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'helpful'){
                        iziToast.show({
                            theme: 'dark',
                            timeout: 5000,
                            overlay: false,
                            icon: 'ion ion-checkmark text-light',
                            backgroundColor: 'var(--success)',
                            message: data.message,
                            messageColor: '#fff',
                            position: 'bottomLeft'
                        });
                        giftRatings();
                        notifications();
                    } else {
                        giftRatings();
                        notifications();
                    }
                }
            });
        });

        // Click on the unhelpful button
        $(document).on('click', '.unhelpful-btn', function() {
            var rating_id = $(this).data('post');
            var gift_id = $(this).data('id');
            var action = $(this).data('action');
            $.ajax({
                url: `/${action}`,
                method: 'post',
                data: {
                    rating_id: rating_id,
                    gift_id: gift_id,
                    action: action,
                    notification_type: 'dislike'
                },
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'unhelpful'){
                        iziToast.show({
                            theme: 'dark',
                            timeout: 5000,
                            overlay: false,
                            icon: 'ion ion-checkmark text-light',
                            backgroundColor: 'var(--success)',
                            message: data.message,
                            messageColor: '#fff',
                            position: 'bottomLeft'
                        });
                        giftRatings();
                        notifications();
                    } else {
                        giftRatings();
                        notifications();
                    }
                }
            });
        });

        // Toggle comment section
        $(document).on('click', '.toggle-comments', function() {
            post_id = $(this).data('post_id');
            user_id = $(this).data('user_id');
            var action = 'review-comments';
            $.ajax({
                url: '{{ route("review_comments") }}',
                method: 'get',
                data: {
                    action: action,
                    post_id: post_id,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(data) {
                    $('#old-comments' + post_id).html(data.review_comments);
                    $('#comment-box' + post_id).slideToggle('fast');
                }
            });
        });

        // Submitting a comment
        $(document).on('keyup', '.comment-input', function(e) {
            post_id = $(this).data('post_id');
            user_id = $(this).data('user_id');
            var comment = $('#add-comment' + post_id).val();
            if (comment.length > 0) {
                $('#add-comment' + post_id).removeClass('is-invalid');
                $('#add-comment' + post_id).addClass('is-valid');
                $('#send-btn' + post_id).show();
                if (e.keyCode === 13) {
                    var receiver_id = user_id;
                    var action = 'submit-comment';
                    if (comment != '') {
                        $('#add-comment' + post_id).removeClass('is-invalid');
                        $('#add-comment' + post_id).addClass('is-valid');
                        $.ajax({
                            url: '{{ route("submit_comment") }}',
                            method: 'post',
                            data: {
                                action: action,
                                post_id: post_id,
                                receiver_id: receiver_id,
                                comment: comment,
                                _token: _token
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data.status == 'success') {
                                    $('#comment-box' + post_id).slideUp('fast');
                                    giftRatings();
                                    notifications();
                                    iziToast.show({
                                        theme: 'dark',
                                        timeout: 5000,
                                        backgroundColor: 'var(--success)',
                                        icon: 'ion ion-checkmark text-light',
                                        message: 'Your comment has been submitted.',
                                        messageColor: '#fff',
                                        position: 'center'
                                    });
                                } else {
                                    iziToast.warning({
                                        theme: 'dark',
                                        timeout: 5000,
                                        closeOnClick: true,
                                        progressBar: false,
                                        backgroundColor: 'var(--warning)',
                                        icon: 'ion-android-alert text-dark',
                                        message: 'Oops! Something went wrong!',
                                        messageColor: '#000',
                                        position: 'center'
                                    });
                                }
                            }
                        });
                    } else {
                        e.preventDefault();
                        $('#add-comment' + post_id).removeClass('is-valid');
                    }
                }
            } else {
                $('#send-btn' + post_id).hide();
                $('#add-comment' + post_id).removeClass('is-valid');
            }
        });

        // Submitting by clicking the send button
        $(document).on('click', '.comment-btn', function(e) {
            e.preventDefault();
            post_id = $(this).data('post_id');
            user_id = $(this).data('user_id');
            var comment = $('#add-comment' + post_id).val();
            if (comment == '') {
                $('#add-comment' + post_id).removeClass('is-valid');
                $('#add-comment' + post_id).addClass('is-invalid');
            } else {
                $('#add-comment' + post_id).removeClass('is-invalid');
                $('#add-comment' + post_id).addClass('is-valid');
                var receiver_id = user_id;
                var action = 'submit-comment';
                $.ajax({
                    url: '{{ route("submit_comment") }}',
                    method: 'post',
                    data: {
                        action: action,
                        post_id: post_id,
                        receiver_id: receiver_id,
                        comment: comment
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#comment-box' + post_id).slideUp('fast');
                            giftRatings();
                            notifications();
                            iziToast.show({
                                theme: 'dark',
                                timeout: 5000,
                                backgroundColor: 'var(--success)',
                                icon: 'ion ion-checkmark text-light',
                                message: 'Your comment has been submitted.',
                                messageColor: '#fff',
                                position: 'center'
                            });
                        } else {
                            iziToast.warning({
                                theme: 'dark',
                                timeout: 5000,
                                closeOnClick: true,
                                progressBar: false,
                                backgroundColor: 'var(--warning)',
                                icon: 'ion-android-alert text-dark',
                                message: 'Oops! Something went wrong!',
                                messageColor: '#000',
                                position: 'center'
                            });
                        }
                    }
                });
            }
        });

        function missingInfoPop(){
            var content = `
                <p class="text-danger">
                    Please provide the missing information first to add this item to cart.
                </p>
            `;
            return content;
        }

        $('.add-to-cart').popover({
            html: true,
            container: 'body',
            placement: 'top',
            trigger: 'hover',
            content: missingInfoPop,
            animation: true
        });

        function smallSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">92cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">64cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">43cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">17cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        function mediumSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">96cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">65cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">44cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">18cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        function largeSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">100cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">67cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">46cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">19cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        function xlargeSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">104cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">69cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">47cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">20cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        function xxlargeSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">108cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">71cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">50cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">21cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        function xxxlargeSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">110cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">73cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">54cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">22cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        function xxxxlargeSize() {
            var content = `
                <h6 class="text-center font-600 mb-0">Manufacturer's Size</h6>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Chest Width</p>
                                </div>
                                <p class="ml-auto">112cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Length</p>
                                </div>
                                <p class="ml-auto">75cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Shoulder</p>
                                </div>
                                <p class="ml-auto">57cm</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center my-1 p-2">
                                <div class="bg-light">
                                    <p class="my-0">Sleeve Length</p>
                                </div>
                                <p class="ml-auto">23cm</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return content;
        }

        $('.small-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: smallSize,
            animation: true
        });

        $('.medium-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: mediumSize,
            animation: true
        });

        $('.large-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: largeSize,
            animation: true
        });

        $('.xlarge-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: xlargeSize,
            animation: true
        });

        $('.xxlarge-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: xxlargeSize,
            animation: true
        });

        $('.xxxlarge-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: xxxlargeSize,
            animation: true
        });
        
        $('.4xlarge-size').popover({
            html: true,
            container: 'body',
            placement: 'bottom',
            trigger: 'hover',
            content: xxxxlargeSize,
            animation: true
        });
    });
</script>