@include('layouts.includes.header')
<style>
    @media(max-width: 660px){
        .range-slider-settings{
            display: inline-block
        }
    }
    @media (min-width: 1200px){
        .chip-sliders>.category-filters.owl-carousel .owl-nav button.owl-prev {
            left: -20px;
        }
    }
</style>
<div class="occasions-page">
    <div class="container-fluid content">
        <!-- Showcase Pane -->
        <div class="showcase-pane bg-whitesmoke box-shadow-sm p-2">
            <h6 class="font-600 m-2">
                Top Selling
            </h6>
            <div class="d-flex flex-md-column gifts-column">
                @foreach($trending as $gift)
                    {{-- Gift star rating --}}
                    @php
                        $star_rating = giftStarRating($gift->id);
                        $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                        $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                        $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                        $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');
                    @endphp
                    <!-- Product Card -->
                    <div class="card product-card border-0 rounded-0 box-shadow-sm">
                        <div class="product-img-wrapper">
                            {!! giftLabel($gift->id) !!}
                            <a href="details/{{ $gift->slug }}/{{ $gift->id }}" title="View product">
                                <img src="/storage/gifts/{{ $gift->gift_image }}" alt="{{ $gift->gift_name }}" height="200" class="card-img-top rounded-0">
                            </a>
                            <div class="overlay py-1 px-2">
                                <div class="d-flex align-items-center">
                                    <a href="details/{{ $gift->slug }}/{{ $gift->id }}" class="d-flex align-items-center">
                                        <img role="button" src="/storage/gifts/{{ $gift->gift_image }}" height="30" width="30" alt="{{ $gift->gift_name }}" class="rounded-circle">
                                    </a>
                                    <div class="d-flex align-items-center ml-auto mr-2" title="{{ giftsSold($gift->id) }} gift(s) sold">
                                        <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                        <small class="text-light d-list-grid">{{ giftsSold($gift->id) }}</small>
                                    </div>
                                    <div class="d-flex align-items-center" title="Add to Wishlist">
                                        @auth
                                            {!! wishlistIcon($gift->id, Auth::user()->id) !!}
                                        @else
                                            <span role="button" class="material-icons text-warning guest-wishes" id="{{ $gift->id }}" data-name="{{ $gift->gift_name }}">favorite_border</span>
                                        @endif
                                        <small class="text-light d-list-grid">{{ totalWishes($gift->id) }}</small>
                                    </div>
                                    <a href="details/{{ $gift->slug }}/{{ $gift->id }}" class="d-flex align-items-center ml-2" title="See Reviews">
                                        <span role="button" class="material-icons overlay-icon">forum</span>
                                        <small class="text-light d-list-grid">{{ countRatings($gift->id) }}</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body my-0 py-0">
                                <div class="lh-100">
                                    <a href="details/{{ $gift->slug }}/{{ $gift->id }}">
                                        <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="{{ $gift->id }}">
                                            {{ mb_strimwidth($gift->gift_name, 0, 25, '...') }}
                                        </p>
                                    </a>
                                    <a href="/category/{{ $gift->category_name }}" class="text-sm font-500 text-capitalize my-0 py-0">
                                        {{ $gift->category_name }}
                                    </a>
                                    {!! $star_rating !!}
                                </div>
                                <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                    {{ mb_strimwidth($gift->description, 0, 60, '...') }}
                                </p>
                                <input value="{{ $gift->id }}" id="gift_id" type="hidden">
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
                <p class="d-flex justify-content-end text-sm mt-2">
                    <a href="/category/trending_gifts" class="d-flex align-items-center">
                        View more <i class="material-icons">chevron_right</i>
                    </a>
                </p>
            </div>
        </div>
        <!-- /.Showcase Pane -->

        <!-- Main Content -->
        <div class="main-content mb-5 pb-5">
            <!-- Categories Chips Slider -->
            <div class="chip-sliders bg-whitesmoke box-shadow-sm border-bottom">
                <div class="owl-carousel owl-theme category-filters m-2">
                    @isset($filters)
                        @foreach ($filters as $category)
                            <!-- Category Item -->
                            <div class="item">
                                <!-- Category Chip -->
                                <a role="button" href="{{ route('gifts_category', [$category->id, $category->category_slug]) }}" class="sub-category-filter" data-id="{{ $category->id }}">
                                    <div class="category-chip rounded-pill">
                                        <img src="/storage/categories/{{ $category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $category->category_name }}">
                                        <span class="text-lowercase text-faded">{{ mb_strimwidth($category->category_name, 0, 10, '...') }}</span>
                                    </div>
                                </a>
                                <!-- /.Category Chip -->
                            </div>
                            <!-- /.Category Item -->
                        @endforeach
                    @endisset
                </div>
            </div>
            <!-- /.Categories Chips Slider -->