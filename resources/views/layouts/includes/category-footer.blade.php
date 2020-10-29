        </div>
        <!-- /.Main Content -->
    </div>
</div>
@include('layouts.includes.footer')
<script>
    $(function(){
        var start = 0;
        var limit = 8;
        var status = 'inactive';
        var filter = '';
        var category_id = {{ $category_id }};

        categoryGifts(start, limit, category_id, filter);

        // Fetch category gifts
        function categoryGifts(start, limit, category_id, filter) {
            var action = 'category-gifts';
            $.ajax({
                url: '{{ route("category_gifts") }}',
                method: 'post',
                data: {
                    action: action,
                    category_id: category_id,
                    start: start,
                    limit: limit,
                    filter: filter,
                    _token: _token
                },
                dataType: 'json',
                cache: false,
                beforeSend: giftsPreloader(),
                success: function(data) {
                    if (data.gifts) {
                        $('#category-gifts').html(data.gifts);
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
            var filter = $(this).attr('id');
            categoryGifts(start, limit, category_id, filter);
            userCurrency();
        });
    });
</script>