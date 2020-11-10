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
                success: function(data) {
                    if(data.result.length > 0){
                        status = 'inactive';
                        $('#occasional-gifts').append(data.gifts);
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
            occasionalGifts(start, limit, occasion, price_ordering, currency);
        }

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() > $('#category-gifts').height() && status == 'inactive') {
                status = 'active';
                start += limit;
                occasionalGifts(start, limit, occasion, price_ordering, currency);
            }
        });
    });
</script>