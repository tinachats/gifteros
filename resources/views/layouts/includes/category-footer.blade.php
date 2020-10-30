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
        var category_id = {{ $category_id }};
        var sub_category_id = '';

        categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating);

        // Fetch category gifts
        function categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating) {
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

        // Filter category gifts by price
        $(document).on('click', '.price-filter', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').not(this).removeClass('active');
            $(this).addClass('active');
            var filter = $(this).attr('id');
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating);
            userCurrency();
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
                categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating);
                userCurrency();
            }
        });

        // Filter category gifts by customer ratigs
        $(document).on('click', '.customer-rated-value', function(e){
            e.preventDefault();
            $('.price-filter').removeClass('active');
            $('.customer-rated-value').not(this).removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $(this).addClass('active');
            var rating = $(this).attr('id');
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating);
        });

        // Filter gifts by their sub-category
        $(document).on('click', '.sub-category-filter', function(e){
            e.preventDefault();
            $('.customer-rated-value').removeClass('active');
            $('.price-filter').removeClass('active');
            $('.sub-category-filter').not(this).removeClass('active');
            $(this).addClass('active');
            var sub_category_id = $(this).data('id');
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating);
            userCurrency();
        });

        // Fetch all gifts
        $(document).on('click', '#fetch-all-btn', function(){
            $('.customer-rated-value').removeClass('active');
            $('.sub-category-filter').removeClass('active');
            $('.price-filter').removeClass('active');
            categoryGifts(start, limit, category_id, sub_category_id, filter, min_price, max_price, rating);
        });
    });
</script>