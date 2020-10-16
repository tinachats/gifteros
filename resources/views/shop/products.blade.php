@include('includes.products-header')
<!-- Page Content -->
<div class="container filtered-products">
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Customizable Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
        </div>
    </div>
    <div class="d-grid grid-view grid-p-1 products-shelf products-preloader mt-3" id="all-gifts"></div>
</div>
<!-- /.Page Content -->
@include('includes.prooducts-footer')
