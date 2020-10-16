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

    @yield('customizable_gifts')
    @yield('kitchenware')
    @yield('plasticware')
    @yield('combo-gifts')
    @yield('appliances')
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')