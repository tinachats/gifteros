@include('layouts.includes.category-header')
<!-- Page Content -->
<div class="container filtered-products">
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <div class="d-flex align-items-center lh-100">
            <div class="d-block lh-100">
                <h6 class="font-600 text-uppercase">{{ $title }}</h6>
                <p class="text-sm my-0 py-0" id="gift-count">loading gift items in stock...</p>
            </div>
        </div>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
        </div>
    </div>
    <div id="category-gifts">
        <!-- All category gifts will show up here -->
        <div class="d-grid grid-view grid-p-1 mt-3">
            <!-- All fetched products will show up here -->
            @for ($i = 0; $i < 4; $i++)
                <!-- Product Placeholder Card -->
                <div class="card placeholder-card bg-whitesmoke border-0 rounded-0 box-shadow-sm">
                    <div class="img-wrapper-placeholder">
                        <div class="placeholder-label"></div>
                        <div class="placeholder-img"></div>
                    </div>
                    <hr class="grid-view-hr my-0 py-0">
                    <div class="placeholder-card-content">
                        <div class="card-body placeholder-body m-0 p-0">
                            <div class="content-placeholder title-placeholder mt-1 ml-2"></div>
                            <div class="content-placeholder category-placeholder my-1 ml-2"></div>
                            <div class="d-flex align-items-center">
                                <div class="content-placeholder rating-placeholder ml-2"></div>
                                <div class="content-placeholder review-placeholder ml-2"></div>
                            </div>
                            <div class="content-placeholder description-placeholder mt-2 mb-1 mx-2"></div>
                            <div class="content-placeholder half-description-placeholder ml-2"></div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="content-placeholder price-placeholder mr-2 ml-2"></div>
                                <div class="content-placeholder before-price-placeholder mr-2"></div>
                            </div>
                            <div class="text-center w-100 mx-0 px-0 mb-1">
                                <div class="btn-group btn-group-sm mt-0 pt-0 btn-group-placeholder pulse">
                                    <button class="btn btn-sm btn-cart-placeholder rounded-left"></button>
                                    <button class="btn btn-sm compare-btn-placeholder rounded-right"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Product Placeholder Card -->
            @endfor
        </div>
    </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.category-footer')