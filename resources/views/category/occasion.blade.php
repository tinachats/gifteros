@include('layouts.includes.occasion-header')
<!-- Page Content -->
<div class="container occasions-container">
    {{ csrf_field() }}
    <div class="d-flex justify-content-between align-items-center title mt-3">
        <!-- Left Settings -->
        <div class="d-flex align-items-center lh-100">
            <!-- Category Title & Results -->
            <div class="d-block lh-100">
                <p class="text-sm my-0 py-0" id="gift-count">loading gift items in stock...</p>
            </div>
            <!-- /.Category Title & Results -->

            <!-- Filter Progress Bars -->
            <div class="filter-bars d-none">
                <div class="d-flex ml-5 rating-bars">
                    <div class="progress" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ lowestPriceRange() }}% of customers bought gifts in this price range.">
                        <div id="lowest-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ lowestPriceRange() }}%" aria-valuenow="{{ lowestPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ lowerPriceRange() }}% of customers bought gifts in this price range.">
                        <div id="lower-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ lowerPriceRange() }}%" aria-valuenow="{{ lowerPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ mediumPriceRange() }}% of customers bought gifts in this price range.">
                        <div id="medium-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ mediumPriceRange() }}%" aria-valuenow="{{ mediumPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ highPriceRange() }}% of customers bought gifts in this price range.">
                        <div id="high-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ highPriceRange() }}%" aria-valuenow="{{ highPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress"  data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{ highestPriceRange() }}% of customers bought gifts in this price range.">
                        <div id="highest-filter-rating" class="progress-bar bg-grey filter-ratings" role="progressbar" style="width: {{ highestPriceRange() }}%" aria-valuenow="{{ highestPriceRange() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <!-- /.Filter Progress Bars -->
        </div>
        <!-- /Left Settings -->

        <!-- Right Settings -->
        <div class="d-none d-md-block">
            <div class="d-flex justify-content-around align-items-center">
                <div class="d-flex align-items-center">
                    <span class="text-sm">Sort by:</span>
                    <div class="d-flex align-items-center justify-content-around sorting-bar  ml-1 mr-3">
                        <select name="price-sorting" id="price-sorting" class="custom-select-sm text-primary text-sm bg-transparent rounded-0 border-0 px-1 py-1">
                            <option value="asc" class="d-flex align-items-center">
                                Price - Low to High
                            </option>
                            <option value="desc" class="d-flex align-items-center">
                                Price - High to low
                            </option>
                        </select>
                    </div>
                </div>
                <i role="button" class="material-icons view-option grid-icon active" data-view="grid-view" title="Grid View">view_comfy</i>
                <i role="button" class="material-icons view-option list-icon mx-3" data-view="list-view" title="List view">view_list</i>
            </div>
        </div>
        <!-- /.Right Settings -->
    </div>
    <div id="occasional-gifts">
        <!-- All category gifts will show up here -->
        <div class="d-grid grid-view grid-p-1 mt-3">
            <!-- All fetched products will show up here -->
        </div>
    </div>
    <!-- Gifts Preloader -->
    <div id="fuzzy-loader">
        <div class="d-grid grid-view grid-p-1 mt-3 gifts-preloader">
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
    <!-- /.Gifts Preloader -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.occasion-footer')