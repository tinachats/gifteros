@include('layouts.includes.main-nav')
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
        {{ csrf_field() }}
        <div class="row">
            <div class="col-12 col-xl-8 details-section">
                <!-- Product Info -->
                <div class="row no-gutters">
                    <div class="col-12 col-md-6 product-gallery">
                        <!-- Product Images -->
                        <div class="product-images">
                            <img class="border border-warning" id="product-img" src="/storage/gifts/{{ $gift->gift_image }}" data-zoom-image="/storage/gifts/{{ $gift->gift_image }}" />
                            <!-- Show preview images here -->
                            <div id="gallery">
                                <a class="active" href="#" data-image="/storage/gifts/<?= $gift->gift_image; ?>" data-zoom-image="/storage/gifts/<?= $gift->gift_image; ?>">
                                    <img src="/storage/gifts/<?= $gift->gift_image; ?>" />
                                </a>
                            </div>
                        </div>
                        <!-- /.Product Images -->
                    </div>
                    <!-- Product Details -->
                    <div class="col-12 col-md-6 pl-md-5 product-details">
                        <div class="d-block info-section">
                            <h5 class="font-500 lead lead-2x text-capitalize font-600 mb-0 pb-0 ml-md-2" id="product-title">{{ $gift->gift_name }}</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-auto">
                                    <a href="/category/{{ $gift->category_id }}/{{ $category_name }}" class="text-capitalize ml-md-2 my-0 py-0">
                                        {{ $category_name }}
                                    </a>
                                    <p class="text-capitalize text-faded my-0 py-0 ml-md-2">
                                        @if($gift->units > 0)
                                            <span class="badge badge-pill badge-success">{{ $gift->units }} In Stock</span>
                                        @else 
                                            <span class="badge badge-pill badge-danger">Out of Stock</span>
                                        @endif
                                    </p>
                                </div>
                                @if ($gift->label == 'customizable')
                                    <div class="ml-auto">
                                        <button class="btn btn-sm border-secondary text-secondary rounded-pill d-flex align-items-center px-1 pulse">
                                            <i class="material-icons mr-1">color_lens</i> Customize
                                        </button>
                                    </div>
                                @endif
                            </div>
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
                                <div class="d-block justify-content-center text-center" id="gift-star-rating">
                                    <!-- Gift star rating will show up here -->
                                    {!!dpStarRating($id)!!}
                                </div>
                                <div class="border-right mr-1"></div>
                                <div class="d-block text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="material-icons text-primary">add_shopping_cart</i>
                                        <span class="text-primary font-600">{{ giftsSold($id) }}</span>
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
                                    <div id="wishlist-btn">
                                        <button class="btn btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center mr-1 guest-wishes" id="{{ $id }}" data-name="{{ $title }}">
                                            <i class="material-icons text-primary mr-1">favorite_border</i>
                                            <span class="text-primary">Wishlist</span>
                                        </button>
                                    </div>
                                @endguest

                                @auth
                                    <div id="wishlist-btn">
                                        {!!wishlistBtn($gift->id, Auth::user()->id)!!}
                                    </div>
                                @endauth

                                <div id="checkout-btn">
                                    <button class="btn btn-primary btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center m-0" disabled>
                                        <i class="material-icons mr-1">accessible</i> Disabled
                                    </button>
                                </div>
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
                                    <h5 class="display-4 font-600 m-0 p-0 rated-value">{{  number_format(giftRating($gift->id), 1) ?? number_format(0, 1) }}</h5>
                                    <div class="d-md-block d-sm-flex">
                                        <div class="m-0 p-0" id="gift-rating"></div>
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
                                {{ csrf_field() }}
                                @if($review_count > 5)
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
                            <div id="gift-reviews" class="col-12 col-md-10 mt-md-3">
                                <!-- Product reviews will be shown here -->
                                <div class="row justify-content-center my-5">
                                    <div class="d-block text-center">
                                        <img src="{{ asset('img/app/spinner.svg') }}" height="80" width="80" alt="" class="">
                                        <h6 class="font-600 mt-2">Loading gift reviews...</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Product Ratings & Reviews -->
            </div>
            <!-- Customize product -->
            <div class="col-12 col-xl-4 pb-2 customizing-panel">
                <nav class="rounded-0 bg-whitesmoke box-shadow-sm">
                    <div class="nav nav-tabs justify-content-around px-0 w-100" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link rounded-0 active" id="nav-addons-tab" data-toggle="tab" href="#nav-addons" role="tab" aria-controls="nav-home" aria-selected="true">
                            Add-ons
                        </a>
                        <a class="nav-item nav-link rounded-0" id="nav-cards-tab" data-toggle="tab" href="#nav-cards" role="tab" aria-controls="nav-home" aria-selected="false">
                            Cards
                        </a>
                        <a class="nav-item nav-link rounded-0" id="nav-wrappers-tab" data-toggle="tab" href="#nav-wrappers" role="tab" aria-controls="nav-home" aria-selected="false">
                            Wrappers
                        </a>
                    </div>
                </nav>
                <div class="tab-content bg-whitesmoke box-shadow-sm rounded-0" id="nav-tabContent" id="customizing-tabContent">
                    <div class="tab-pane fade show active" id="nav-addons" role="tabpanel" aria-labelledby="nav-addons-tab">
                        <h5 class="font-600 p-2">Make it extra special</h5>
                        <div class="accessories-grid w-100" id="greeting-cards">
                            <!-- Greeting cards will show up here -->
                            @foreach ($accesories as $gift)
                                <!-- Accessories -->
                                <div class="item w-100">
                                    <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                        <a href="{{ route('details.show', [$gift->slug, $gift->gift_id]) }}">
                                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                                        </a>
                                        <div class="gift-content mx-1">
                                            <a href="{{ route('details.show', [$gift->slug, $gift->gift_id]) }}">
                                                <h6 class="my-0 py-0 text-capitalize font-600 text-primary">{{ mb_strimwidth($gift->gift_name, 0, 17, '...') }}</h6>
                                            </a>
                                            <div class="d-inline-block lh-100">
                                                <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->category_name }}</h6>
                                                <div class="d-flex align-items-center justify-content-around">
                                                    {!! giftStarRating($gift->id) !!}
                                                </div>
                                            </div>
                                            <input value="{{ $gift->id }}" id="gift_id" type="hidden">
                                            <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->usd_price, 2) }}" id="usd-price{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->zar_price, 2) }}" id="zar-price{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->zwl_price, 2) }}" id="zwl-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_usd_price" value="{{ $sale_usd_price ?? ''}}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_zar_price" value="{{ $sale_zar_price ?? ''}}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_zwl_price" value="{{ $sale_zwl_price ?? ''}}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                                            <input name="end-time" value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                                            <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                                            <input type="hidden" name="sale-end-date" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                                            <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <h6 class="usd-price text-grey text-sm font-600 mt-2">US${{ number_format($gift->usd_price, 2) }}</h6>
                                                <h6 class="zar-price d-none text-grey text-sm font-600 mt-2">R{{ number_format($gift->zar_price, 2) }}</h6>
                                                <h6 class="zwl-price d-none text-grey text-sm font-600 mt-2">ZW${{ number_format($gift->zwl_price, 2) }}</h6>
                                                <span role="button" class="material-icons fa-2x text-success">add_circle_outline</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Accessories -->
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-cards" role="tabpanel" aria-labelledby="nav-cards-tab">
                        <h5 class="font-600 p-2">Add a custom greeting card</h5>
                        <div class="accessories-grid w-100" id="greeting-cards">
                            <!-- Greeting cards will show up here -->
                            @foreach ($greeting_cards as $gift)
                                <!-- Accessories -->
                                <div class="item w-100">
                                    <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                        <a href="{{ route('details.show', [$gift->slug, $gift->gift_id]) }}">
                                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                                        </a>
                                        <div class="gift-content mx-1">
                                            <a href="{{ route('details.show', [$gift->slug, $gift->gift_id]) }}">
                                                <h6 class="my-0 py-0 text-capitalize font-600 text-primary">{{ mb_strimwidth($gift->gift_name, 0, 17, '...') }}</h6>
                                            </a>
                                            <div class="d-inline-block lh-100">
                                                <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->category_name }}</h6>
                                                <div class="d-flex align-items-center justify-content-around">
                                                    {!! giftStarRating($gift->id) !!}
                                                </div>
                                            </div>
                                            <input value="{{ $gift->id }}" id="gift_id" type="hidden">
                                            <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->usd_price, 2) }}" id="usd-price{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->zar_price, 2) }}" id="zar-price{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->zwl_price, 2) }}" id="zwl-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_usd_price" value="{{ $sale_usd_price ?? ''}}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_zar_price" value="{{ $sale_zar_price ?? ''}}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_zwl_price" value="{{ $sale_zwl_price ?? ''}}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                                            <input name="end-time" value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                                            <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                                            <input type="hidden" name="sale-end-date" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                                            <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <h6 class="usd-price text-grey text-sm font-600 mt-2">US${{ number_format($gift->usd_price, 2) }}</h6>
                                                <h6 class="zar-price d-none text-grey text-sm font-600 mt-2">R{{ number_format($gift->zar_price, 2) }}</h6>
                                                <h6 class="zwl-price d-none text-grey text-sm font-600 mt-2">ZW${{ number_format($gift->zwl_price, 2) }}</h6>
                                                <span role="button" class="material-icons fa-2x text-success">add_circle_outline</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Accessories -->
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-wrappers" role="tabpanel" aria-labelledby="nav-wrappers-tab">
                        <h5 class="font-600 p-2">Choose your gift wrapper</h5>
                        <div class="accessories-grid w-100" id="greeting-cards">
                            <!-- Greeting cards will show up here -->
                            @foreach ($wrappers as $gift)
                                <!-- Accessories -->
                                <div class="item w-100">
                                    <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                        <a href="{{ route('details.show', [$gift->slug, $gift->gift_id]) }}">
                                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                                        </a>
                                        <div class="gift-content mx-1">
                                            <a href="{{ route('details.show', [$gift->slug, $gift->gift_id]) }}">
                                                <h6 class="my-0 py-0 text-capitalize font-600 text-primary">{{ mb_strimwidth($gift->gift_name, 0, 17, '...') }}</h6>
                                            </a>
                                            <div class="d-inline-block lh-100">
                                                <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->category_name }}</h6>
                                                <div class="d-flex align-items-center justify-content-around">
                                                    {!! giftStarRating($gift->id) !!}
                                                </div>
                                            </div>
                                            <input value="{{ $gift->id }}" id="gift_id" type="hidden">
                                            <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->usd_price, 2) }}" id="usd-price{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->zar_price, 2) }}" id="zar-price{{ $gift->id }}" type="hidden">
                                            <input value="{{ number_format($gift->zwl_price, 2) }}" id="zwl-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_usd_price" value="{{ $sale_usd_price ?? ''}}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_zar_price" value="{{ $sale_zar_price ?? ''}}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                                            <input name="sale_zwl_price" value="{{ $sale_zwl_price ?? ''}}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                                            <input name="end-time" value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                                            <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                                            <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                                            <input type="hidden" name="sale-end-date" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                                            <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <h6 class="usd-price text-grey text-sm font-600 mt-2">US${{ number_format($gift->usd_price, 2) }}</h6>
                                                <h6 class="zar-price d-none text-grey text-sm font-600 mt-2">R{{ number_format($gift->zar_price, 2) }}</h6>
                                                <h6 class="zwl-price d-none text-grey text-sm font-600 mt-2">ZW${{ number_format($gift->zwl_price, 2) }}</h6>
                                                <span role="button" class="material-icons fa-2x text-success">add_circle_outline</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Accessories -->
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
                    <p class="font-400 my-0 py-0 text-capitalize">{{ $title }}</p>
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
                    <form method="post" id="ratingForm">
                        @csrf
                        <textarea name="user-review" id="user-review" cols="30" rows="7" class="form-control rounded-2 font-400 w-100" placeholder="Your feedback helps others to purchase this gift." onkeyup="emptyReview(this)"></textarea>
                        <input type="hidden" name="gift-id" id="gift-id" value="{{ $id }}">
                        <input type="hidden" id="star-rating" name="star-rating">
                        <input type="hidden" name="action" value="gift-review">
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
    <div class="modal fade rounded-0" id="write-review" tabindex="-1" role="dialog" aria-labelledby="write-review" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content box-shadow-sm">
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <a href="#" class="navbar-brand font-700">
                            <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> {{ config('app.name') }}
                        </a>
                    </div>
                    <h5 class="lead my-2">Want to contribute?</h5>
                    <p class="text-sm text-justify">
                        You need to be signed in with your account to have your contributions about 
                        <span class="text-primary text-capitalize">{{ $title }}</span> saved.
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
    <!-- /.signin-first modal -->
@endguest

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
    });
</script>