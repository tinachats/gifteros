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
        var category = "{{ $category }}";
        var sub_category_id = '';
        var currency = userCurrency();
        var price_ordering =  priceOrdering();

        // Fetch category gifts
        function categoryGifts(start, limit, category, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency) {
            var action = 'department-gifts';
            $.ajax({
                url: '{{ route("department_gifts") }}',
                method: 'post',
                data: {
                    action: action,
                    category: category,
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
                        $('#null-gifts').addClass('d-none');
                    }
                }
            });
        }

        if(status == 'inactive'){
            status = 'active';
            categoryGifts(start, limit, category, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
        }

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() > $('#category-gifts').height() && status == 'inactive') {
                status = 'active';
                start += limit;
                categoryGifts(start, limit, category, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
            }
        });
    });
</script>