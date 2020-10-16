<style>
    @media(max-width: 660px){
        .range-slider-settings{
            display: inline-block
        }
    }
</style>
<div class="page-content filter-page">
    <div class="content">
        <!-- Filter Settings Pane -->
        <div class="filter-pane">
            <h6 class="font-600 text-faded m-2 d-sm-block d-md-none">
                <i class="fa fa-sliders mr-1 text-faded"></i>
                Filter Options
            </h6>
            <h6 class="font-600 text-faded d-none d-md-block">
                Showing results for <span class="text-faded text-capitalize"><?= $category_name; ?></span>
            </h6>
            <div class="d-none d-md-block mt-md-1">
                <h6 class="text-sm text-capitalize">Refine by Price</h6>
                <ul class="price-filters">
                    <li class="text-sm text-capitalize mb-2 ml-2">
                        <a href="" class="usd-price font-600">Under $25</a>
                        <a href="" class="zar-price d-none font-600">Under R412.5</a>
                        <a href="" class="zwl-price d-none font-600">Under ZW$2500</a>
                    </li>
                    <li class="text-sm text-capitalize mb-2 ml-2">
                        <a href="" class="usd-price font-600">US$5 to US$20</a>
                        <a href="" class="zar-price font-600">R82.5 to R330</a>
                        <a href="" class="zwl-price font-600">US$500 to US$2000</a>
                    </li>
                    <li class="text-sm text-capitalize mb-2 ml-2">
                        <a href="" class="usd-price font-600">US$20 to US$50</a>
                        <a href="" class="zar-price d-none font-600">R330 to R825</a>
                        <a href="" class="zwl-price d-none font-600">ZW$2000 to ZW$5000</a>
                    </li>
                    <li class="text-sm text-capitalize mb-2 ml-2">
                        <a href="" class="usd-price d-none font-600">US$50 to US$100</a>
                        <a href="" class="zar-price d-none font-600">R825 to R1,650</a>
                        <a href="" class="zwl-price d-none font-600">ZW$5000 to ZW$10000</a>
                    </li>
                    <li class="text-sm text-capitalize mb-2 ml-2">
                        <a href="" class="usd-price d-none font-600">US$100 and Above</a>
                        <a href="" class="zar-price d-none font-600">R1,650 and Above</a>
                        <a href="" class="zwl-price d-none font-600">ZW$10000 and Above</a>
                    </li>
                </ul>
                <div class="w-100">
                    <form method="post" id="price-range-form" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <input type="text" id="min-price" name="min-price" class="input form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <input type="text" id="max-price" name="max-price" class="input form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <button type="submit" class="btn btn-primary btn-sm font-600 btn-block">Go</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <h6 class="text-sm text-capitalize">Average customer ratings</h6>
                <a href="#" class="customer-rated-value" id="above-4-rating">
                    <ul class="list-inline align-items-center container my-0 py-0">
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-faded">&star;</li>
                        <span class="text-sm text-blue font-600">& Up</span>
                    </ul>
                </a>
                <a href="#" class="customer-rated-value" id="above-3-rating">
                    <ul class="list-inline align-items-center container my-0 py-0">
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&star;</li>
                        <li class="list-inline-item star-rating text-faded">&star;</li>
                        <span class="text-sm text-blue font-600">& Up</span>
                    </ul>
                </a>
                <a href="#" class="customer-rated-value" id="above-2-rating">
                    <ul class="list-inline align-items-center container my-0 py-0">
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&star;</li>
                        <li class="list-inline-item star-rating text-faded">&star;</li>
                        <span class="text-sm text-blue font-600">& Up</span>
                    </ul>
                </a>
                <a href="#" class="customer-rated-value" id="above-1-rating">
                    <ul class="list-inline align-items-center container my-0 py-0" class="customer-rated-value" id="above-1-rating">
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&starf;</li>
                        <li class="list-inline-item star-rating text-warning">&star;</li>
                        <li class="list-inline-item star-rating text-faded">&star;</li>
                        <span class="text-sm text-blue font-600">& Up</span>
                    </ul>
                </a>
            </div>
            <div class="d-md-none d-sm-block">
                <form method="post" id="gift-filter-form">
                    <div class="row w-100">
                        <!-- Price Range -->
                        <div class="col-6 col-md-4">
                            <div class="form-group mb-1">
                                <label for="price-range" class="text-sm font-500 my-0 w-100">
                                    <div class="usd-price">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted">Price:</span>
                                            <span class="text-muted">US$0.00</span>
                                        </div>
                                    </div>
                                    <div class="zar-price d-none">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted">Price:</span>
                                            <span class="text-muted">R3,300.00</span>
                                        </div>
                                    </div>
                                    <div class="zwl-price d-none">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted">Price:</span>
                                            <span class="text-muted">ZW$20000.00</span>
                                        </div>
                                    </div>
                                </label>
                                <input type="range" class="custom-range" name="price-range" id="price-range" min="0" max="200" step="0.5" value="0">
                            </div>
                        </div>
                        <!-- /.Price Range -->

                        <!-- Ratings Range -->
                        <div class="col-6 col-md-4">
                            <div class="form-group mb-1">
                                <label for="price-range" class="text-sm font-500 my-0 w-100">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted">Rating:</span>
                                        <span class="text-muted">0</span>
                                    </div>
                                </label>
                                <input type="range" class="custom-range" name="ratings-range" id="ratings-range" min="0" max="5" step="1" value="0">
                            </div>
                        </div>
                        <!-- /.Ratings Range -->
                    </div>
                </form>
            </div>
        </div>
        <!-- /.Filter Settings Pane -->

        <!-- Main Content -->
        <div class="main-content">
            <!-- Categories Chips Slider -->
            @include('product-chips')
            <!-- /.Categories Chips Slider -->