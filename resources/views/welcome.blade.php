@include('layouts.includes.header')
<style>
    .product-img{
        height: 180px;
    }
</style>
<!-- Page Content -->
<div class="container page-content" id="index-page">
    {{-- Showcase Products --}}
    @include('layouts.includes.showcase')
    <div class="owl-carousel owl-theme carousel-autoplay showcase-gifts">
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
     <div class="owl-carousel owl-theme reviews-carousel">
        {!! appReviews() !!}
     </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')