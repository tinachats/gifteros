        </div>
        <!-- /.Main Content -->
        @include('layouts.includes.inline-footer')
    </div>
    <!-- /.Page Content -->
</div>
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
                    trending: trending,
                    _token: _token
                },
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data.result.length > 0){
                        status = 'inactive';
                        $('#category-gifts').append(data.gifts);
                        $('#gift-count').html(data.gift_count);
                        userCurrency();
                    } else {
                        status = 'active';
                        $('#fuzzy-loader').addClass('d-none');
                        $('.gifts-preloader').html(' ');
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
                    trending: trending,
                    _token: _token
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

        // Customer's price range
        $(document).on('click', '#submit-range', function(e){
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

        // Filter category gifts by customer ratigs
        $(document).on('click', '.customer-rated-value', function(e){
            e.preventDefault();
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.price-filter').removeClass('active');
            $('.customer-rated-value').not(this).removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $(this).addClass('active');
            var rating = $(this).attr('id');
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