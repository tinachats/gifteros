        </div>
        <!-- /.Main Content -->
    </div>
<!-- /.Page Content -->
</div>
@include('layouts.includes.footer')
<script>
    $(function(){
        var start = 0;
        var limit = 12;
        var status = 'inactive';
        var occasion = "{{ $occasion }}";
        var currency = userCurrency();
        var price_ordering =  priceOrdering();

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
        
        // Fetch occasional gifts
        function occasionalGifts(start, limit, occasion, price_ordering, currency) {
            var action = 'occasional-gifts';
            $.ajax({
                url: '{{ route("occasional_gifts") }}',
                method: 'post',
                data: {
                    action: action,
                    occasion: occasion,
                    start: start,
                    limit: limit,
                    currency: currency,
                    price_ordering: price_ordering,
                    _token: _token
                },
                dataType: 'json',
                cache: false,
                beforeSend: viewOption(),
                success: function(data) {
                    if(data.result.length > 0){
                        status = 'inactive';
                        $('#occasional-gifts').append(data.gifts);
                        $('#gift-count').html(data.gift_count);
                        userCurrency();
                        viewOption();
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
            occasionalGifts(start, limit, occasion, price_ordering, currency);
        }

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() > $('#occasional-gifts').height() && status == 'inactive') {
                status = 'active';
                start += limit;
                occasionalGifts(start, limit, occasion, price_ordering, currency);
            }
        });
    });
</script>