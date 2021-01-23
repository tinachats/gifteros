@include('layouts.includes.main-nav')
<style>
    .fixed-md-top {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
    }
    .product-img{
        height: 180px;
    }
</style>
<!-- Page Content -->
<div class="container page-content" id="index-page">
    {{-- Showcase Products --}}
    @include('layouts.includes.showcase')
    <div class="box-shadow-sm bg-whitesmoke rounded-bottom-2 p-3">
        <div class="owl-carousel owl-theme carousel-autoplay" id="gift-categories">
            @yield('categories')
        </div>
        <a href="#" class="text-faded d-flex align-items-center justify-content-center my-0 font-600">
            Explore gift categories <i class="material-icons ml-1 text-faded">keyboard_arrow_right</i>
        </a>
    </div>

    @yield('customizable_gifts')
    @yield('kitchenware')
    @yield('personal-care')
    @yield('plasticware')
    @yield('combo-gifts')
    @yield('appliances')
    @yield('city-exchange')
    @yield('recommended-gifts')
    @yield('browsed-gifts')
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
            var gift_image = $('#image' + gift_id).val();
            var action = $(this).data('action');
            $.ajax({
                url: `/${action}`,
                method: 'post',
                data: {
                    action: action,
                    gift_id: gift_id,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(data) {
                    iziToast.show({
                        animateInside: true,
                        theme: 'dark',
                        timeout: 3000,
                        closeOnClick: true,
                        overlay: false,
                        close: false,
                        backgroundColor: 'var(--success)',
                        progressBar: false,
                        icon: 'ion-checkmark text-light',
                        image: '../storage/gifts/' + gift_image,
                        imageWidth: 60,
                        message: data.message,
                        messageColor: '#fff',
                        position: 'topCenter'
                    });
                    showcase();
                    userInfo();
                    myWishlist();
                }
            });
        });

        // Clear the cart
        $(document).on('click', '.clear-cart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearCart();
            showcase();
        });
    });
</script>