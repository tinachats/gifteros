@include('layouts.includes.category-header')
<!-- Page Content -->
<div class="container filtered-products">
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">{{ $title }}</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
        </div>
    </div>
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="all-gifts">
        <!-- All recommended products will show up here -->
        @foreach ($gifts as $gift)
            <?php
                // Gift star rating
                $star_rating = giftStarRating($gift->id);

                $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');
            ?>
            <!-- Product Card -->
            <div class="card product-card border-0 rounded-0 box-shadow-sm">
                <div class="product-img-wrapper">
                    {!!giftLabel($gift->id)!!}
                    <a href="/details/{{ $gift->slug }}/{{ $gift->id }}" title="View product">
                        <img src="/storage/gifts/{{ $gift->gift_image }}" alt="{{ $gift->gift_name }}" height="200" class="card-img-top rounded-0">
                    </a>
                    <div class="overlay py-1 px-2">
                        <div class="d-flex align-items-center">
                            <a href="/details/{{ $gift->slug }}/{{ $gift->id }}" class="d-flex align-items-center">
                                <img role="button" src="/storage/gifts/{{ $gift->gift_image }}" height="30" width="30" alt="{{ $gift->gift_name }}" class="rounded-circle">
                            </a>
                            <div class="d-flex align-items-center ml-auto" title="Add to Wishlist">
                                @auth
                                    {!!wishlistIcon($gift->id, Auth::user()->id)!!}
                                @endauth
                                @guest
                                    <span role="button" class="material-icons text-warning visitor-wishes" id="{{ $gift->id }}" data-name="{{ $gift->gift_name }}">favorite_border</span>
                                @endguest
                                <small class="text-light d-list-grid">{{ totalWishes($gift->id) }}</small>
                            </div>
                            <a href="/details/{{ $gift->slug }}/{{ $gift->id }}" class="d-flex align-items-center ml-2" title="See Reviews">
                                <span role="button" class="material-icons overlay-icon">forum</span>
                                <small class="text-light d-list-grid">{{ countRatings($gift->id) }}</small>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body my-0 py-0">
                        <div class="lh-100">
                            <a href="/details/{{ $gift->slug }}/{{ $gift->id }}">
                                <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="{{ $gift->id }}">
                                    {{ mb_strimwidth($gift->gift_name, 0, 25, '...') }}
                                </p>
                            </a>
                            <a href="/category/{{ $gift->category_name }}" class="text-sm font-500 text-capitalize my-0 py-0">
                                {{ $gift->category_name }}
                            </a>
                            {!!$star_rating!!}
                        </div>
                        <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                            {{ mb_strimwidth($gift->description, 0, 60, '...') }}
                        </p>
                        <input value="{{ $gift->id }}" id="product_id" type="hidden">
                        <input value="{{ $gift->gift_name }}" id="name{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->label }}" id="label{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->gift_image }}" id="image{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->usd_price }}" id="usd-price{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->zar_price }}" id="zar-price{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->zwl_price }}" id="zwl-price{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->sale_usd_price }}" id="sale-usd-price{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->sale_zar_price }}" id="sale-zar-price{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->sale_zwl_price }}" id="sale-zwl-price{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->custom_usd_price }}" id="customizing-usd-cost{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->custom_zar_price }}" id="customizing-zar-cost{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->custom_zwl_price }}" id="customizing-zwl-cost{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->ends_on }}" id="end-time{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->category_name }}" id="category-name{{ $gift->id }}" type="hidden">
                        <input value="{{ $gift->units }}" id="product-units{{ $gift->id }}" type="hidden">
                        <input value="1" id="quantity{{ $gift->id }}" type="hidden">
                        <input type="hidden" id="sale-end-date" value="{{ date('y, m, d, h, m, s', strtotime($gift->ends_on)) }}">
                        <input value="{{ $gift->description }}" id="description{{ $gift->id }}" type="hidden">
                        
                        <div class="usd-price">
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span class="font-600">US$<span class="product-price">{{ number_format($gift->usd_price, 2) }}</span></span>
                                <div class="d-flex align-items-center before-prices">
                                    <span class="font-600 text-muted strikethrough ml-1">US${{ $usd_before }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="zar-price d-none">
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span class="font-600">R<span class="product-price">{{ number_format($gift->zar_price, 2) }}</span></span>
                                <div class="d-flex align-items-center before-prices">
                                    <span class="font-600 text-muted strikethrough ml-1">R{{ $zar_before }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="zwl-price d-none">
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span class="font-600">ZW$<span class="product-price">{{ number_format($gift->zwl_price, 2) }}</span></span>
                                <div class="d-flex align-items-center before-prices">
                                    <span class="font-600 text-muted strikethrough ml-1">${{ $zwl_before }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center w-100 mx-0 px-0 mb-1">
                            <div class="btn-group btn-group-sm mt-0 pt-0 product-card-btns pulse">
                                <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="{{ $gift->id }}">
                                    <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                    Buy <span class="text-white text-white ml-1">gift</span>
                                </button>
                                <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn{{ $gift->id }}" data-name="{{ $short_name }}" data-id="{{ $gift->id }}">
                                    <i class="material-icons text-primary mr-1">compare_arrows</i>
                                    Compare
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.Product Card -->
        @endforeach
    </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.category-footer')