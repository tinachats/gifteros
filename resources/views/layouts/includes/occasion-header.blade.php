@include('layouts.includes.header')
@include('layouts.includes.main-nav')
@include('layouts.includes.mobile-catheader')
<style>
    @media(max-width: 660px){
        #web-main-header{
            display: none
        }
        .range-slider-settings{
            display: inline-block
        }
    }
    @media(min-width: 768px){
        #web-main-header{
            display: block
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
        <div class="showcase-pane bg-whitesmoke box-shadow-sm d-none d-md-block p-2">
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
                   <!-- Related Gift -->
                   <div class="item w-100">
                    <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                        <a href="{{ route('details.show', [$gift->gift_slug, $gift->gift_id]) }}">
                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                        </a>
                        <div class="gift-content mx-1">
                            <a href="{{ route('details.show', [$gift->gift_slug, $gift->gift_id]) }}">
                                <h6 class="my-0 py-0 text-capitalize font-600 text-primary">{{ mb_strimwidth($gift->gift_name, 0, 17, '...') }}</h6>
                            </a>
                            <div class="d-inline-block lh-100">
                                <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->category_name }}</h6>
                                <div class="d-flex align-items-center justify-content-around">
                                    {!! $star_rating !!}
                                </div>
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
            <div class="chip-sliders bg-whitesmoke box-shadow-sm border-bottom d-none d-md-block">
                <div class="owl-carousel owl-theme category-filters m-2">
                    @isset($filters)
                        @foreach ($filters as $category)
                            <!-- Category Item -->
                            <div class="item">
                                <!-- Category Chip -->
                                <a role="button" href="{{ route('gifts_category', [$category->id, $category->category_slug]) }}" class="sub-category-filter" data-id="{{ $category->id }}">
                                    <div class="category-chip rounded-pill">
                                        <img src="/storage/sub-categories/{{ $category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $category->category_name }}">
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