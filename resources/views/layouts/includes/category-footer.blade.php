        </div>
        <!-- /.Main Content -->
    </div>
</div>
@include('layouts.includes.footer')
<script>
    $(function(){
        var start = 0;
        var limit = 8;
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
        var price_ordering =  priceOrdering();

        categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);

        // Fetch category gifts
        function categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending) {
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
                beforeSend: giftsPreloader(),
                success: function(data) {
                    if (data.gifts) {
                        $('#category-gifts').html(data.gifts);
                        $('#gift-count').html(data.gift_count);
                        status = 'inactive';
                        userCurrency();
                    } else {
                        giftsPreloader();
                        status = 'active';
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

        // Filter category gifts by price
        $(document).on('click', '.price-filter', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').not(this).removeClass('active');
            $(this).addClass('active');
            var filter = $(this).attr('id');
            $('.filter-bars').removeClass('d-none');
            filterBars(filter, min_price, max_price);
            // Change the filter ratings background color based on price filter value
            filterBars(filter, min_price, max_price);
            resetRangeInputs();
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
            userCurrency();
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
                categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
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
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
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
            var sub_category_id = $(this).data('id');
            resetRangeInputs();
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
            userCurrency();
        });

        // Fetch all category gifts based on date inserted
        $('.latest-gifts').on('click', function(e){
            e.preventDefault();
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.sorting-filters').not(this).removeClass('active');
            $(this).addClass('active');
            latest = 'created_at';
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
            userCurrency();
        }); 

        // Fetch all category gifts based on likes
        $('.liked-gifts').on('click', function(e){
            e.preventDefault();
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.sorting-filters').not(this).removeClass('active');
            $(this).addClass('active');
            likes = 'top-wishlisted';
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
            userCurrency();
        });
        
        // Fetch all category gifts based on their orders
        $('.trending-gifts').on('click', function(e){
            e.preventDefault();
            // Hide the filter-ratings bars
            $('.filter-bars').addClass('d-none');
            $('.sorting-filters').not(this).removeClass('active');
            $(this).addClass('active');
            trending = 'top-sold';
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
            userCurrency();
        });

        // Sorting category gifts by user prefence settings
        $(document).on('change', '#price-sorting', function(e){
            e.stopPropagation();
            price_ordering = $(this).val();
            localStorage.setItem('price-sorting-order', price_ordering);
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
            if(price_ordering == 'asc'){
                $('#price-ordering-label').text('Ascending');
                $('#price-ordering').attr('checked', true);
            } else {
                $('#price-ordering-label').text('Descending');
                $('#price-ordering').attr('checked', false);
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

         // Wishlist actions
         $(document).on('click', '.wishlist-icon', function() {
            var gift_id = $(this).data('id');
            var user_id = $(this).data('user');
            var action = $(this).data('action');
            $.ajax({
                url: `/${action}`,
                method: 'post',
                data: {
                    action: action,
                    gift_id: gift_id,
                    user_id: user_id,
                    _token: _token
                },
                dataType: 'json',
                success: function(data) {
                    iziToast.show({
                        theme: 'dark',
                        timeout: 2000,
                        closeOnClick: true,
                        overlay: false,
                        close: false,
                        progressBar: false,
                        backgroundColor: 'var(--success)',
                        icon: 'ion-checkmark text-light',
                        message: data.message,
                        messageColor: '#fff',
                        position: 'center'
                    });
                    categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending);
                    userInfo();
                    myWishlist();
                }
            });
        });
    });
</script>