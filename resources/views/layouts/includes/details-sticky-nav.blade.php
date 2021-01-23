<!-- Sticky Navbar -->
<div class="navbar navbar-expand-lg navbar-light bg-white page-navbar sticky-top box-shadow-sm">
    <div class="container">
        <div class="dropdown">
            <a class="navbar-brand brandname dropdown-toggle text-capitalize d-flex align-items-center" href="#" href="#" id="title-dropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                {{ mb_strimwidth($title, 0, 17, '...') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-left w-auto px-2" aria-labelledby="title-dropdown">
                <div class="d-flex align-items-center">
                    <img src="/storage/gifts/{{ $gift->gift_image }}" alt="Gift Img" height="30" width="30" class="align-self-center mr-2 rounded-circle">
                    <h6 class="text-capitalize text-sm">{{ $title }}</h6>
                </div>
                <div class="dropdown-menu-item text-muted text-sm mt-2">
                    @if(positiveFeedback($id) >= 50)
                        <span class="text-success">{{ positiveFeedback($id) }}%</span> Positive feedback
                    @elseif(positiveFeedback($id) < 50)
                        <span class="text-danger">{{ positiveFeedback($id) }}%</span> Positive feedback
                    @elseif(positiveFeedback($id) == 0)
                        <span class="text-muted">Hasn't been rated yet.</span>
                    @endif
                </div>
                <div class="dropdown-menu-item text-muted text-sm">
                    @switch($gift->units)
                        @case($gift->units == 1)
                            <span class="text-danger">1</span> Unit left
                            @break
                        @case($gift->units < 10)
                            <span class="text-danger">{{ $gift->units }}</span> Units left
                            @break
                        @default
                            <span class="text-success">{{ $gift->units }}</span> Units
                    @endswitch
                </div>
                <div class="dropdown-menu-item text-muted text-sm">
                    @if (giftsSold($id) == 1)
                        <span class="text-dark">1</span> Purchase
                    @else
                        <span class="text-dark">{{ giftsSold($id) }}</span> Purchases
                    @endif
                </div>
                <div class="dropdown-menu-item text-muted text-sm">
                    @if (totalWishes($id) == 1)
                        <span class="text-dark">1</span> Customer wishlisted this
                    @else
                        <span class="text-dark">{{ totalWishes($id) }}</span> Customers wishlisted this
                    @endif
                </div>
                <div class="dropdown-menu-item text-muted text-sm">
                    @if (viewCounter($id) == 1)
                        <span class="text-dark">1</span> View
                    @else
                        <span class="text-dark">{{ viewCounter($id) }}</span> Total views
                    @endif
                </div>
                <div class="dropdown-menu-item d-flex justify-content-center my-2">
                    <a href="#" class="btn btn-sm btn-primary btn-block rounded-pill">
                        Write a review
                    </a>
                </div>
            </ul>
        </div>
        <ul class="nav nav-tabs mr-auto" id="nav-tab" role="tablist">
            <li class="nav-item m-0">
                <a class="nav-link active font-600" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">Overview</a>
            </li>
            <li class="nav-item m-0">
                <a class="nav-link font-600" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-home" aria-selected="false">Customer Reviews ({{ countRatings($id) }})</a>
            </li>
            <li class="nav-item m-0">
                <a class="nav-link font-600" id="nav-related-tab" data-toggle="tab" href="#nav-related" role="tab" aria-controls="nav-home" aria-selected="false">Related</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item nav-buttons">
                <button type="button" class="btn btn-sm bg-switch d-flex align-items-center rounded-pill px-3 py-1 add-to-cart">
                    <i class="material-icons text-white mr-1">add_shopping_cart</i>
                    <span class="text-white font-600">Add to Cart</span>
                </button>
            </li>
            <li class="nav-item nav-buttons mx-3">
                <a role="button" class="nav-link btn btn-sm bg-danger d-flex align-items-center rounded-pill px-3 py-1" href="/checkout">
                    <i class="material-icons text-white mr-1">credit_card</i>
                    <span class="text-white font-600">Checkout</span>
                </a>
            </li>
            <li class="nav-item nav-buttons">
                <button type="button" class="btn btn-sm btn-default d-flex align-items-center rounded-pill px-3 py-1">
                    <i class="material-icons mr-1">favorite_border</i>123
                </button>
            </li>
        </ul>
    </div>
</div>
<!-- Sticky Navbar -->