@include('layouts.includes.header')
<style>
    .product-img{
        height: 180px;
    }
</style>
<!-- Page Content -->
<div class="container page-content" id="index-page">
    @csrf
    {{-- Showcase Products --}}
    @include('layouts.includes.showcase')
    <div class="owl-carousel owl-theme carousel-autoplay" id="gift-categories">
        @yield('categories')
    </div>

    @yield('customizable_gifts')
    @yield('kitchenware')
    @yield('personal-care')
    @yield('plasticware')
    @yield('combo-gifts')
    @yield('appliances')
     <!-- Customer Reviews -->
     <h6 class="font-600 text-uppercase mt-4">Customer Reviews</h6>
     <div class="owl-carousel owl-theme reviews-carousel pb-md-5">
        {!! appReviews() !!}
     </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')
<script>
    $(function(){
        // Showcase all gift categories
        showcase();
        
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
                        overlay: true,
                        close: false,
                        progressBar: false,
                        backgroundColor: 'var(--success)',
                        icon: 'ion-checkmark text-light',
                        message: data.message,
                        messageColor: '#fff',
                        position: 'center'
                    });
                    showcase();
                    userInfo();
                    myWishlist();
                }
            });
        });
    });
</script>