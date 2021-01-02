@extends('welcome')

@section('categories')
    @foreach($categories as $gift)
        <!-- Related Gift -->
        <div class="item w-100">
            <a href="/category/{{ $gift->id }}/{{ $gift->category_slug }}" class="stretched-link">
                <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-2 w-100">
                    <img src="/storage/categories/{{ $gift->image }}" height="150" class="card-img-top w-100 rounded-top-2">
                    <div class="gift-content mx-1">
                        <h6 class="my-0 py-0 text-capitalize text-sm">{{ mb_strimwidth($gift->category_name, 0, 17, '...') }}</h6>
                        <div class="d-inline-block w-100 lh-100">
                            @if (categoriesGifts($gift->id) == 1)
                                <h6 class="my-0 py-0 text-sm text-capitalize">1 gift</h6>
                            @else
                                <h6 class="my-0 py-0 text-sm text-capitalize">{{ categoriesGifts($gift->id) }} gifts</h6> 
                            @endif
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div>
                                    @if (maxRatedInCategory($gift->id) > 0)
                                        <div class="d-flex align-items-center">
                                            <span class="text-warning mr-1">&starf;</span>
                                            <span class="text-sm text-muted">{{ number_format(maxRatedInCategory($gift->id), 1) }}</span>
                                        </div>
                                    @else 
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted mr-1">&star;</span>
                                            <span class="text-sm text-muted">0.0</span>
                                        </div>
                                    @endif
                                </div>
                                @if (soldCategoryGifts($gift->id) > 0)
                                    <span class="text-sm text-muted mr-2">{{ soldCategoryGifts($gift->id) }} Sold</span> 
                                @endif
                            </div>
                        </div>
                        <div class="usd-price">
                            <div class="d-flex align-items-center">
                                <h6 class="text-sm">From US${{ number_format(minPricedInCategory($gift->id), 2) }}</h6>
                            </div>
                        </div>
                        <div class="zar-price d-none">
                            <div class="d-flex align-items-center">
                                <h6 class="text-sm">From R{{ number_format(minPricedInCategory($gift->id) * 16.5, 2) }}</h6>
                            </div>
                        </div>
                        <div class="zwl-price d-none">
                            <div class="d-flex align-items-center">
                                <h6 class="text-sm">From ZW${{ number_format(minPricedInCategory($gift->id) * 100, 2) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- /.Related Gift -->
    @endforeach
@endsection

<!-- Customizable Gifts -->
@section('customizable_gifts')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Customizable Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active d-none d-md-inline-block" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3 d-none d-md-block" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/25/customizable" class="btn btn-sm bg-switch" id="all-customizable">
                <span class="text-white">View all</span>
                <i class="ion ion-chevron-right text-white ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="customizable-gifts">
        <!-- All fetched products will show up here -->
        @for ($i = 0; $i < 4; $i++)
            <!-- Product Placeholder Card -->
            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                <div class="img-wrapper-placeholder">
                    <div class="placeholder-label"></div>
                    <div class="placeholder-img"></div>
                </div>
                <hr class="grid-view-hr my-0 py-0">
                <div class="placeholder-card-content">
                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Customizable Gifts -->

<!-- Kitchenware Gifts -->
@section('kitchenware')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Kitchenware Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active d-none d-md-inline-block" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3 d-none d-md-block" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/9/kitchenware" class="btn btn-sm bg-switch" id="all-kitchenware">
                <span class="text-white">View all</span>
                <i class="ion ion-chevron-right text-white ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="kitchenware">
        <!-- All fetched products will show up here -->
        @for ($i = 0; $i < 4; $i++)
            <!-- Product Placeholder Card -->
            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                <div class="img-wrapper-placeholder">
                    <div class="placeholder-label"></div>
                    <div class="placeholder-img"></div>
                </div>
                <hr class="grid-view-hr my-0 py-0">
                <div class="placeholder-card-content">
                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Kitchenware Gifts -->

<!-- Personal Care Gifts -->
@section('personal-care')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Personal Care Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active d-none d-md-inline-block" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3 d-none d-md-block" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/12/personal care" class="btn btn-sm bg-switch" id="all-persomal-care">
                <span class="text-white">View all</span>
                <i class="ion ion-chevron-right text-white ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="personal-care-gifts">
        <!-- All fetched products will show up here -->
        @for ($i = 0; $i < 4; $i++)
            <!-- Product Placeholder Card -->
            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                <div class="img-wrapper-placeholder">
                    <div class="placeholder-label"></div>
                    <div class="placeholder-img"></div>
                </div>
                <hr class="grid-view-hr my-0 py-0">
                <div class="placeholder-card-content">
                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Kitchenware Gifts -->

<!-- Plasticware Gifts -->
@section('plasticware')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Plasticware Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active d-none d-md-inline-block" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3 d-none d-md-block" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/21/plasticware" class="btn btn-sm bg-switch" id="all-plasticware">
                <span class="text-white">View all</span>
                <i class="ion ion-chevron-right text-white ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="plasticware">
        <!-- All fetched products will show up here -->
        @for ($i = 0; $i < 4; $i++)
            <!-- Product Placeholder Card -->
            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                <div class="img-wrapper-placeholder">
                    <div class="placeholder-label"></div>
                    <div class="placeholder-img"></div>
                </div>
                <hr class="grid-view-hr my-0 py-0">
                <div class="placeholder-card-content">
                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Plasticware Gifts -->

<!-- Combo Gifts -->
@section('combo-gifts')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Combo Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active d-none d-md-inline-block" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3 d-none d-md-block" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/34/combo" class="btn btn-sm bg-switch" id="all-combos">
                <span class="text-white">View all</span>
                <i class="ion ion-chevron-right text-white ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="combo-gifts">
        <!-- All fetched products will show up here -->
        @for ($i = 0; $i < 4; $i++)
            <!-- Product Placeholder Card -->
            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                <div class="img-wrapper-placeholder">
                    <div class="placeholder-label"></div>
                    <div class="placeholder-img"></div>
                </div>
                <hr class="grid-view-hr my-0 py-0">
                <div class="placeholder-card-content">
                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Combo Gifts -->

<!-- Appliances Gifts -->
@section('appliances')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Appliances Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active d-none d-md-inline-block" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3 d-none d-md-block" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/8/appliances" class="btn btn-sm bg-switch" id="all-appliances">
                <span class="text-white">View all</span>
                <i class="ion ion-chevron-right text-white ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="appliances">
        <!-- All fetched products will show up here -->
        @for ($i = 0; $i < 4; $i++)
            <!-- Product Placeholder Card -->
            <div class="card placeholder-card bg-whitesmoke rounded-2 box-shadow-sm">
                <div class="img-wrapper-placeholder">
                    <div class="placeholder-label"></div>
                    <div class="placeholder-img"></div>
                </div>
                <hr class="grid-view-hr my-0 py-0">
                <div class="placeholder-card-content">
                    <div class="card-body placeholder-body m-0 p-0 rounded-bottom-2">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Appliances Gifts -->

  