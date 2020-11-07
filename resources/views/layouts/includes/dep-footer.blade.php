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
        var category = {{ $category }};
        var sub_category_id = '';
        var currency = userCurrency();
        var price_ordering =  priceOrdering();

        console.log(category);

        // Fetch category gifts
        categoryGifts(start, limit, category, sub_category_id, filter, min_price, max_price, rating, price_ordering, latest, likes, trending, currency);
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
    });
</script>