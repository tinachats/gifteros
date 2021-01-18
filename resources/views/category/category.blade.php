@include('layouts.includes.main-nav')
@php
   use Illuminate\Support\Str;
@endphp
<style>
    .filter-list,
    .form-check-label{
        margin-left: -20px
    }
    .btn-group-placeholder {
        width: 190px !important
    }
    @media(min-width: 1200px){
        .grid-view>.product-card>.card-content>.card-body .btn-group{
            left: 1.2%;
        }
    }
</style>
<!-- Page Content -->
<div class="container page-content mt-5">
    <div class="row no-gutters">
        <div class="col-12 col-md-3">
            <ul class="filter-section list-group bg-whitesmoke box-shadow-sm rounded-0">
                <li class="list-group-item rounded-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="lead text-app-color font-600">filter by</h6>
                        <button class="btn btn-sm btn-default">clear all</button>
                    </div>
                </li>
                <li class="list-group-item rounded-0">
                    <h6 class="font-600">Availability</h6>
                    <div class="col-12 ml-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="active">
                            <label class="form-check-label" for="active">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="missed">
                            <label class="form-check-label" for="missed">
                                Missed
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="upcoming">
                            <label class="form-check-label" for="upcoming">
                                Upcoming
                            </label>
                        </div>
                    </div>
                </li>
                <li class="list-group-item rounded-0">
                    <h6 class="font-600">Pricing</h6>
                    <div class="col-12 ml-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="under-25">
                            <label class="form-check-label" for="under-25">
                                Under 25
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="25-to-50">
                            <label class="form-check-label" for="25-to-50">
                                $25 - $50
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="50-to-100">
                            <label class="form-check-label" for="50-to-100">
                                $50 - $100
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="100-to-200">
                            <label class="form-check-label" for="100-to-200">
                                $100 - $200
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="50-to-100">
                            <label class="form-check-label" for="50-to-100">
                                Above $200
                            </label>
                        </div>
                    </div>
                    <div class="container mt-2">
                        <div class="row justify-content-around">
                            <input type="text" name="min-price" id="min-price" class="form-control form-control-sm col" placeholder="Min. Price">
                            <input type="text" name="max-price" id="max-price" class="form-control form-control-sm col mx-2" placeholder="Max. Price">
                            <button class="btn btn-sm btn-primary px-3">Go</button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item rounded-0">
                    <h6 class="font-600">Avg. Customer Review</h6>
                    <div class="col-12 ml-md-2">
                        <ul class="list-inline filter-list">
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <span class="text-sm text-faded font-600">4 and Above</span>
                        </ul>
                        <ul class="list-inline filter-list">
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <span class="text-sm text-faded font-600">3 and Above</span>
                        </ul>
                        <ul class="list-inline filter-list">
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <span class="text-sm text-faded font-600">2 and Above</span>
                        </ul>
                        <ul class="list-inline filter-list">
                            <li class="list-inline-item star-rating mx-0 text-warning">&starf;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <li class="list-inline-item star-rating mx-0 text-faded">&star;</li>
                            <span class="text-sm text-faded font-600">1 and Above</span>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-12 col-md-9">
            <div class="filter-page main-content">
                <!-- Categories Chips Slider -->
                <div class="chip-sliders box-shadow-sm bg-whitesmoke border px-2 py-1">
                    <div class="owl-carousel owl-theme category-filters">
                        @isset($sub_categories)
                            @foreach ($sub_categories as $sub_category)
                                <!-- Category Item -->
                                <div class="item">
                                    <!-- Category Chip -->
                                    <a role="button" href="#" class="sub-category-filter" data-id="{{ $sub_category->id }}">
                                        <div class="category-chip rounded-pill">
                                            <img src="/storage/sub-categories/{{ $sub_category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $sub_category->name }}">
                                            <span class="text-lowercase text-faded">{{ Str::words($sub_category->name, 1, '') }}</span>
                                        </div>
                                    </a>
                                    <!-- /.Category Chip -->
                                </div>
                                <!-- /.Category Item -->
                            @endforeach
                        @endisset

                        @isset($filters)
                            @foreach ($filters as $sub_category)
                                <!-- Category Item -->
                                <div class="item">
                                    <!-- Category Chip -->
                                    <a role="button" href="#" class="sub-category-filter" data-id="{{ $sub_category->id }}">
                                        <div class="category-chip rounded-pill">
                                            <img src="/storage/sub-categories/{{ $sub_category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $sub_category->name }}">
                                            <span class="text-lowercase text-faded">{{ Str::words($sub_category->name, 1, '') }}</span>
                                        </div>
                                    </a>
                                    <!-- /.Category Chip -->
                                </div>
                                <!-- /.Category Item -->
                            @endforeach
                        @endisset

                        @isset($sub_filters)
                            @foreach ($sub_filters as $sub_category)
                                <!-- Category Item -->
                                <div class="item">
                                    <!-- Category Chip -->
                                    <a role="button" href="#" class="sub-category-filter active" data-id="{{ $sub_category->id }}">
                                        <div class="category-chip rounded-pill">
                                            <img src="/storage/sub-categories/{{ $sub_category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $sub_category->name }}">
                                            <span class="text-lowercase text-faded">{{ Str::words($sub_category->name, 1, '') }}</span>
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
                {{-- Range Bars --}}
                <div class="bg-whitesmoke box-shadow-sm d-sm-block d-xl-flex justify-content-xl-between align-items-center p-2" style="margin-top: 2px">
                    <!-- Left Settings -->
                    <div class="d-flex align-items-center lh-100">
                        <!-- Category Title & Results -->
                        <div class="d-block lh-100">
                            <h6 class="font-600 text-capitalize d-none d-md-block">{{ $title }}</h6>
                            <p class="text-sm my-0 py-0" id="gift-count">loading gift items in stock...</p>
                        </div>
                        <!-- /.Category Title & Results -->
            
                        <!-- Filter Progress Bars -->
                        <div class="filter-bars d-none">
                            <div class="d-flex ml-5 rating-bars">
                                <div class="progress" id="lowest-price-range" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ lowestPriceRange() }}% of customers bought gifts in this price range.">
                                    <div id="lowest-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ lowestPriceRange() }}%" aria-valuenow="{{ lowestPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress" id="lower-price-range" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ lowerPriceRange() }}% of customers bought gifts in this price range.">
                                    <div id="lower-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ lowerPriceRange() }}%" aria-valuenow="{{ lowerPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress" id="medium-price-range" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ mediumPriceRange() }}% of customers bought gifts in this price range.">
                                    <div id="medium-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ mediumPriceRange() }}%" aria-valuenow="{{ mediumPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress" id="high-price-range" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ highPriceRange() }}% of customers bought gifts in this price range.">
                                    <div id="high-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ highPriceRange() }}%" aria-valuenow="{{ highPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress" id="highest-price-range" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ highestPriceRange() }}% of customers bought gifts in this price range.">
                                    <div id="highest-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ highestPriceRange() }}%" aria-valuenow="{{ highestPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.Filter Progress Bars -->
                    </div>
                    <!-- /Left Settings -->
            
                    <!-- Right Settings -->
                    <div class="d-none d-md-block">
                        <div class="d-flex justify-content-around align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="text-sm">Sort by:</span>
                                <div class="btn-group btn-group-sm mx-2" role="group" aria-label="Filter Buttons">
                                    <button type="button" class="btn btn-default btn-sm" title="Sort gifts by trending">
                                        Trending
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" title="Sort gifts by their wishlist">
                                        Likes
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" title="Sort gifts by the date they were added">
                                        Latest
                                    </button>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" id="btnDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Price
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnDropdown">
                                            <a href="#" class="dropdown-items">Price - Low to High</a>
                                            <a href="#" class="dropdown-items">Price - High to low</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
                            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
                        </div>
                    </div>
                    <!-- /.Right Settings -->
                </div>
                {{-- /.Range Bars --}}
                {{-- Category Gifts --}}
                <div class="d-grid grid-view grid-p-1 mt-2 products-shelf w-100" id="category-gifts">
                    <!-- All fetched gifts will show up here -->
                </div>
                <!-- Gifts Preloader -->
                <div id="fuzzy-loader">
                    <div class="d-grid grid-view grid-p-1 mt-2 products-shelf w-100 gifts-preloader">
                        <!-- All fetched products will show up here -->
                        @for ($i = 0; $i < 8; $i++)
                            <!-- Product Placeholder Card -->
                            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                                <div class="img-wrapper-placeholder">
                                    <div class="badge customize-ribbon d-flex align-items-center placeholder-label rounded-right"></div>
                                    <div class="placeholder-img"></div>
                                </div>
                                <hr class="grid-view-hr my-0 py-0">
                                <div class="placeholder-card-content">
                                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
                                        <div class="content-placeholder title-placeholder mt-1 ml-2"></div>
                                        <div class="content-placeholder category-placeholder my-1 ml-2"></div>
                                        <div class="d-flex align-items-center">
                                            <div class="content-placeholder rating-placeholder ml-2"></div>
                                        </div>
                                        <div class="content-placeholder description-placeholder mt-2 mb-1 mx-2"></div>
                                        <div class="content-placeholder half-description-placeholder ml-2"></div>
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            <div class="content-placeholder price-placeholder mr-2 ml-2"></div>
                                            <div class="content-placeholder before-price-placeholder mr-2"></div>
                                        </div>
                                        <div class="text-center w-100 mx-0 px-0 mb-1">
                                            <div class="btn-group btn-group-sm mt-0 pt-0 btn-group-placeholder pulse">
                                                <button class="btn btn-sm btn-cart-placeholder rounded-left"></button>
                                                <button class="btn btn-sm compare-btn-placeholder rounded-right"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Product Placeholder Card -->
                        @endfor
                    </div>
                </div>
                {{-- /.Category Gifts --}}
            </div>
        </div>
    </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')
<script>
    $(function(){
        var start = 0;
        var limit = 12;
        var min_price = '';
        var max_price = '';
        var status = 'inactive';
        var filter = '';
        var rating = '';
        var latest = '';
        var likes = '';
        var trending = '';
        var category_id = {{ $category_id }};
        var sub_category_id = '';
        var currency = userCurrency();
        var price_ordering =  priceOrdering();

        // Clear previous results
        function loading(){
            $('#fuzzy-loader').removeClass('d-none');
            giftsPreloader(8);
            $('#category-gifts').html(' ')
        }

        // Fetch category gifts
        function categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency) {
            var action = 'category-gifts';
            $.ajax({
                url: '{{ route("category_gifts") }}',
                method: 'post',
                data: {
                    action: action,
                    category_id: category_id,
                    sub_category_id: sub_category_id,
                    start: start,
                    limit: limit,
                    filter: filter,
                    currency: currency,
                    min_price: min_price,
                    max_price: max_price,
                    rating: rating,
                    price_ordering: price_ordering,
                    latest: latest,
                    likes: likes,
                    trending: trending
                },
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data.result.length > 0){
                        status = 'inactive';
                        $('#category-gifts').append(data.gifts);
                        $('#gift-count').html(data.gift_count);
                        userCurrency();
                        viewOption();
                        // Loop every gift_id and assign trigger the countdown time
                        var gift_ids = data.gift_ids;
                        for (i = 0; i < gift_ids.length; i++) {
                            countdownTimer(gift_ids[i], data.countdown_date, data.now);
                        }
                    } else {
                        status = 'active';
                        $('#fuzzy-loader').addClass('d-none');
                        $('.gifts-preloader').html(' ');
                    }
                    if(data.count == 0){
                        $('#category-gifts').removeClass('d-grid grid-view grid-p-1 mt-3 products-shelf');
                    }
                }
            });
        }

        // Fetch filtered gifts
        function filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency) {
            var action = 'category-gifts';
            $.ajax({
                url: '{{ route("category_gifts") }}',
                method: 'post',
                data: {
                    action: action,
                    category_id: category_id,
                    sub_category_id: sub_category_id,
                    filter: filter,
                    currency: currency,
                    min_price: min_price,
                    max_price: max_price,
                    rating: rating,
                    price_ordering: price_ordering,
                    latest: latest,
                    likes: likes,
                    trending: trending
                },
                dataType: 'json',
                beforeSend: loading(),
                cache: false,
                success: function(data) {
                    if(data.gifts){
                        status = 'active';
                        $('#fuzzy-loader').addClass('d-none');
                        $('.gifts-preloader').html(' ');
                        $('#category-gifts').html(data.gifts);
                        $('#gift-count').html(data.gift_count);
                        userCurrency();
                        viewOption();
                    }
                }
            });
        }

        // Display filter bars
        function filterBars(filter, min_price, max_price){
            min_price = parseFloat($('#min-price').val());
            max_price = parseFloat($('#max-price').val());
            var price_range = parseFloat(max_price - min_price).toFixed(2);
            if(filter == 'under-25' || filter == '5-to-20' || max_price < 25){
                $('#lower-filter-rating').addClass('bg-grey');
                $('#medium-filter-rating').addClass('bg-grey');
                $('#high-filter-rating').addClass('bg-grey');
                $('#highest-filter-rating').addClass('bg-grey');
                $('#lowest-filter-rating').toggleClass('bg-grey');
                $('#lower-filter-rating').removeClass('bg-switch');
                $('#medium-filter-rating').removeClass('bg-switch');
                $('#high-filter-rating').removeClass('bg-switch');
                $('#highest-filter-rating').removeClass('bg-switch');
                $('#lowest-filter-rating').addClass('bg-switch');
            } else if(filter == '20-to-50' || max_price < 50){
                $('#lowest-filter-rating').addClass('bg-grey');
                $('#lower-filter-rating').addClass('bg-grey');
                $('#high-filter-rating').addClass('bg-grey');
                $('#highest-filter-rating').toggleClass('bg-grey');
                $('#medium-filter-rating').toggleClass('bg-grey');
                $('#lowest-filter-rating').removeClass('bg-switch');
                $('#lower-filter-rating').removeClass('bg-switch');
                $('#high-filter-rating').removeClass('bg-switch');
                $('#highest-filter-rating').removeClass('bg-switch');
                $('#medium-filter-rating').addClass('bg-switch');
            } else if(filter == '50-to-100' || max_price < 100){
                $('#lowest-filter-rating').addClass('bg-grey');
                $('#lower-filter-rating').addClass('bg-grey');
                $('#medium-filter-rating').addClass('bg-grey');
                $('#highest-filter-rating').toggleClass('bg-grey');
                $('#high-filter-rating').toggleClass('bg-grey');
                $('#lowest-filter-rating').removeClass('bg-switch');
                $('#lower-filter-rating').removeClass('bg-switch');
                $('#medium-filter-rating').removeClass('bg-switch');
                $('#highest-filter-rating').removeClass('bg-switch');
                $('#high-filter-rating').addClass('bg-switch');
            } else {
                $('#lowest-filter-rating').addClass('bg-grey');
                $('#lower-filter-rating').addClass('bg-grey');
                $('#medium-filter-rating').addClass('bg-grey');
                $('#high-filter-rating').addClass('bg-grey');
                $('#highest-filter-rating').toggleClass('bg-grey');
                $('#lowest-filter-rating').removeClass('bg-switch');
                $('#lower-filter-rating').removeClass('bg-switch');
                $('#medium-filter-rating').removeClass('bg-switch');
                $('#high-filter-rating').removeClass('bg-switch');
                $('#highest-filter-rating').addClass('bg-switch');
            }
        }

        /*** Insert price range data into range inputs on hovering on filter bars ***/
        $('#lowest-price-range').on('mouseenter', function(){
            min_price = {{ minLowestPurchase() }};
            max_price = {{ maxLowestPurchase() }};
            if(currency == 'usd'){
                $('#min-price').val(min_price);
                $('#max-price').val(max_price);
            } else if(currency == 'zar'){
                min_price = (16.5 * min_price);
                max_price = (16.5 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            } else {
                min_price = (100 * min_price);
                max_price = (100 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            }
        });

        $('#lower-price-range').on('mouseenter', function(){
            min_price = {{ minLowerPurchase() }};
            max_price = {{ maxLowerPurchase() }};
            if(currency == 'usd'){
                $('#min-price').val(min_price);
                $('#max-price').val(max_price);
            } else if(currency == 'zar'){
                min_price = (16.5 * min_price);
                max_price = (16.5 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            } else {
                min_price = (100 * min_price);
                max_price = (100 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            }
        });

        $('#medium-price-range').on('mouseenter', function(){
            min_price = {{ minMediumPurchase() }};
            max_price = {{ maxMediumPurchase() }};
            if(currency == 'usd'){
                $('#min-price').val(min_price);
                $('#max-price').val(max_price);
            } else if(currency == 'zar'){
                min_price = (16.5 * min_price);
                max_price = (16.5 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            } else {
                min_price = (100 * min_price);
                max_price = (100 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            }
        });

        $('#high-price-range').on('mouseenter', function(){
            min_price = {{ minHighPurchase() }};
            max_price = {{ maxHighPurchase() }};
            if(currency == 'usd'){
                $('#min-price').val(min_price);
                $('#max-price').val(max_price);
            } else if(currency == 'zar'){
                min_price = (16.5 * min_price);
                max_price = (16.5 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            } else {
                min_price = (100 * min_price);
                max_price = (100 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            }
        });

        $('#highest-price-range').on('mouseenter', function(){
            min_price = {{ minHighestPurchase() }};
            max_price = {{ maxHighestPurchase() }};
            if(currency == 'usd'){
                $('#min-price').val(min_price);
                $('#max-price').val(max_price);
            } else if(currency == 'zar'){
                min_price = (16.5 * min_price);
                max_price = (16.5 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            } else {
                min_price = (100 * min_price);
                max_price = (100 * max_price);
                $('#min-price').val(parseFloat(min_price).toFixed(2));
                $('#max-price').val(parseFloat(max_price).toFixed(2));
            }
        });

        // Reset the price range inputs
        function resetRangeInputs(){
            $('#min-price').val('');
            $('#max-price').val('');
            $('#min-price').removeClass('is-valid');
            $('#max-price').removeClass('is-valid');
            $('#min-price').removeClass('is-invalid');
            $('#max-price').removeClass('is-invalid');
        }

        // Filter category gifts by price
        $(document).on('click', '.price-filter', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').not(this).removeClass('active');
            $(this).addClass('active');
            $('.filter-bars').removeClass('d-none');
            var filter = $(this).attr('id');
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
            filterBars(filter, min_price, max_price);
            resetRangeInputs();
        });

        // Filter category gifts by price
        $(document).on('click', '.mobile-price-filter', function(e){
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').not(this).removeClass('active');
            $(this).addClass('active');
            $('.filter-bars').removeClass('d-none');
            var filter = $(this).attr('id');
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
            filterBars(filter, min_price, max_price);
            resetRangeInputs();
        });

        // Customer's price range
        $(document).on('click', '.submit-range', function(e){
            e.preventDefault();
            $('.price-filter').removeClass('active');
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            var min_price = $('#min-price').val();
            var max_price = $('#max-price').val();
            var errors = false;

            if(min_price == ''){
                $('#min-price').addClass('is-invalid'); 
                errors = true;
            } else {
                $('#min-price').removeClass('is-invalid'); 
                $('#min-price').addClass('is-valid'); 
            }
            
            if(max_price == ''){
                $('#max-price').addClass('is-invalid'); 
                errors = true;
            } else {
                $('#max-price').removeClass('is-invalid'); 
                $('#max-price').addClass('is-valid'); 
            }

            if(errors == false){
                // Show the filter-ratings bars
                $('.filter-bars').removeClass('d-none');
                filterBars(filter, min_price, max_price);
                filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
                userCurrency();
            }
        });

         // Customer's price range
         $(document).on('click', '.submit-mobile-range', function(e){
            e.preventDefault();
            $('.price-filter').removeClass('active');
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            var min_price = $('#mobile-min-price').val();
            var max_price = $('#mobile-max-price').val();
            var errors = false;

            if(min_price == ''){
                $('#mobile-min-price').addClass('is-invalid'); 
                errors = true;
            } else {
                $('#mobile-min-price').removeClass('is-invalid'); 
                $('#mobile-min-price').addClass('is-valid'); 
            }
            
            if(max_price == ''){
                $('#mobile-max-price').addClass('is-invalid'); 
                errors = true;
            } else {
                $('#mobile-max-price').removeClass('is-invalid'); 
                $('#mobile-max-price').addClass('is-valid'); 
            }

            if(errors == false){
                // Show the filter-ratings bars
                $('.filter-bars').removeClass('d-none');
                filterBars(filter, min_price, max_price);
                filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
                userCurrency();
            }
        });

        // Filter category gifts by customer ratings
        $(document).on('click', '.customer-rated-value', function(e){
            e.preventDefault();
            e.stopPropagation();
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.price-filter').removeClass('active');
            $('.customer-rated-value').not(this).removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $(this).addClass('active');
            var rating = $(this).data('rating');
            resetRangeInputs();
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        });

        // Filter gifts by their sub-category
        $(document).on('click', '.sub-category-filter', function(e){
            e.preventDefault();
            e.stopPropagation();
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.customer-rated-value').removeClass('active');
            $('.price-filter').removeClass('active');
            $('.sub-category-filter').not(this).removeClass('active');
            $(this).addClass('active');
            $('#category-gifts').html('');
            sub_category_id = $(this).data('id');
            resetRangeInputs();
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        });

        // Fetch all category gifts based on date inserted
        $('.latest-gifts').on('click', function(e){
            e.preventDefault();
            $('.sorting-filters').not(this).removeClass('active');
            $(this).addClass('active');
            latest = 'created_at';
            resetRangeInputs();
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        }); 

        // Fetch all category gifts based on likes
        $('.liked-gifts').on('click', function(e){
            e.preventDefault();
            $('.sorting-filters').not(this).removeClass('active');
            $(this).addClass('active');
            likes = 'top-wishlisted';
            resetRangeInputs();
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        });
        
        // Fetch all category gifts based on their orders
        $('.trending-gifts').on('click', function(e){
            e.preventDefault();
            $('.sorting-filters').not(this).removeClass('active');
            $(this).addClass('active');
            trending = 'top-sold';
            resetRangeInputs();
            filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        });

        // Sorting category gifts by user prefence settings
        $(document).on('change', '#price-sorting', function(e){
            e.stopPropagation();
            price_ordering = $(this).val();
            localStorage.setItem('price-sorting-order', price_ordering);
            if(price_ordering == 'asc'){
                $('#price-ordering-label').text('Ascending');
                $('#price-ordering').attr('checked', true);
            } else {
                $('#price-ordering-label').text('Descending');
                $('#price-ordering').attr('checked', false);
            }
            location.reload();
        });

        // Sort gifts by  customer preferences
        $(document).on('change', '#sorting-order', function(){
            var sorting_type = $(this).val();
            switch(sorting_type){
                case 'null': 
                    iziToast.warning({
                        theme: 'dark',
                        timeout: 2000,
                        closeOnClick: true,
                        overlay: false,
                        close: false,
                        progressBar: false,
                        backgroundColor: 'var(--warning)',
                        icon: 'ion-android-alert text-dark',
                        message: 'Choosing a sorting order!',
                        messageColor: '#000',
                        position: 'center'
                    });
                    break;
                case 'latest-gifts': 
                    latest = 'created_at';
                    resetRangeInputs();
                    filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
                    break;
                case 'price-asc':
                    localStorage.setItem('price-sorting-order', 'asc');
                    $('#price-ordering-label').text('Ascending');
                    $('#price-ordering').attr('checked', true);
                    location.reload();
                    break;
                case 'price-desc':
                    localStorage.setItem('price-sorting-order', 'desc');
                    $('#price-ordering-label').text('Descending');
                    $('#price-ordering').attr('checked', false);
                    location.reload();
                    break;
                case 'most-wished':
                    likes = 'top-wishlisted';
                    resetRangeInputs();
                    filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
                    break;
                case  'trending-gifts':
                    trending = 'top-sold';
                    resetRangeInputs();
                    filteredGifts(category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
                    break;
                default: 
                    resetRangeInputs();
                    location.reload();
            }
        });

        // Fetch all gifts
        $(document).on('click', '#fetch-all-btn', function(){
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').removeClass('active');
            $('.sorting-filters').removeClass('active');
            resetRangeInputs();
            location.reload();
        });

        // Fetch all gifts
        $(document).on('click', '#load-all', function(){
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').removeClass('active');
            $('.sorting-filters').removeClass('active');
            resetRangeInputs();
            location.reload();
        });

        if(status == 'inactive'){
            status = 'active';
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        }

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() > $('#category-gifts').height() && status == 'inactive') {
                status = 'active';
                start += limit;
                categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
            }
        });
    });
</script>