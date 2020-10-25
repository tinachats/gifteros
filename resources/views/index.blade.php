@extends('welcome')

@section('categories')
    @foreach($showcase_gifts as $gift)
        <?php
            // Gift star rating
            $star_rating = giftStarRating($gift->id);

            $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
            $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
            $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
            $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');
        ?>
        <!-- Related Gift -->
        <div class="item w-100">
            <a href="details/{{ $gift->slug }}/{{ $gift->id }}" class="stretched-link">
                <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                    <div class="gift-actions d-flex align-items-center justify-content-between w-100">
                        {!!giftLabel($gift->id)!!}
                    </div>
                    <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                    <div class="gift-content mx-1">
                        <h6 class="my-0 py-0 text-capitalize font-600 text-primary">{{ mb_strimwidth($gift->gift_name, 0, 17, '...') }}</h6>
                        <div class="d-inline-block lh-100">
                            <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->category_name }}</h6>
                            <div class="d-flex align-items-center justify-content-around">
                                {!!$star_rating!!}
                            </div>
                        </div>
                        <div class="usd-price">
                            <div class="d-flex align-items-center">
                                <h6 class="text-brick-red font-600">US${{ number_format($gift->usd_price, 2) }}</h6>
                                <h6 class="text-muted strikethrough font-600 ml-3">US${{ $usd_before }}</h6>
                            </div>
                        </div>
                        <div class="zar-price d-none">
                            <div class="d-flex align-items-center">
                                <h6 class="text-brick-red font-600">R{{ number_format($gift->zar_price, 2) }}</h6>
                                <h6 class="text-muted strikethrough font-600 ml-3">R{{ $zar_before }}</h6>
                            </div>
                        </div>
                        <div class="zwl-price d-none">
                            <div class="d-flex align-items-center">
                                <h6 class="text-brick-red font-600">ZW${{ number_format($gift->zwl_price, 2) }}</h6>
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
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/25/customizable" class="btn btn-sm btn-outline-dark rounded-0" id="all-customizable">
                <span class="text-dark-inverse">View all</span>
                <i class="ion ion-chevron-right text-dark-inverse ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="customizable-gifts">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Customizable Gifts -->

<!-- Kitchenware Gifts -->
@section('kitchenware')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Kitchenware Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/9/kitchenware" class="btn btn-sm btn-outline-dark rounded-0" id="all-kitchenware">
                <span class="text-dark-inverse">View all</span>
                <i class="ion ion-chevron-right text-dark-inverse ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="kitchenware">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Kitchenware Gifts -->

<!-- Personal Care Gifts -->
@section('personal-care')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Personal Care Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/12/personal care" class="btn btn-sm btn-outline-dark rounded-0" id="all-persomal-care">
                <span class="text-dark-inverse">View all</span>
                <i class="ion ion-chevron-right text-dark-inverse ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="kitchenware">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Kitchenware Gifts -->

<!-- Plasticware Gifts -->
@section('plasticware')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Plasticware Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/21/plasticware" class="btn btn-sm btn-outline-dark rounded-0" id="all-plasticware">
                <span class="text-dark-inverse">View all</span>
                <i class="ion ion-chevron-right text-dark-inverse ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="plasticware">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Plasticware Gifts -->

<!-- Combo Gifts -->
@section('combo-gifts')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Combo Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/34/combo" class="btn btn-sm btn-outline-dark rounded-0" id="all-combos">
                <span class="text-dark-inverse">View all</span>
                <i class="ion ion-chevron-right text-dark-inverse ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="combos">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Combo Gifts -->

<!-- Appliances Gifts -->
@section('appliances')
    <!-- Customizable Gifts -->
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <h6 class="font-600 text-uppercase">Appliances Gifts</h6>
        <div class="d-flex justify-content-around align-items-center">
            <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
            <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            <a role="button" href="/category/8/appliances" class="btn btn-sm btn-outline-dark rounded-0" id="all-appliances">
                <span class="text-dark-inverse">View all</span>
                <i class="ion ion-chevron-right text-dark-inverse ml-2"></i>
            </a>
        </div>
    </div>
    <!-- Products -->
    <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="appliances">
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
    <!-- /.Customizable Gifts -->
@endsection
<!-- /.Appliances Gifts -->

  