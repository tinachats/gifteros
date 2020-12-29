@include('layouts.includes.header')
@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">My Wishlist</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item">
                        <a href="index.php" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                            <span class="d-none d-md-inline text-primary">Store</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/account/{{ username() }}">Account</a>
                    </li>
                    <li class="breadcrumb-item acctive">
                        Wishlist
                    </li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5">
        <div class="row border-top border-bottom py-2">
            <div class="col-12">
                <h3 class="display-5 font-600 mb-0 pb-0">My Wishlist</h3>
                <div class="d-flex align-items-center" id="saved-gifts">
                    <i class="material-icons text-faded">favorite_border</i>
                    <div class="text-sm font-500 ml-1">
                        0 gifts saved
                    </div>
                </div>
            </div>
        </div>
        <div id="wishlist">
            <!-- All my wishlisted gifts will be shown here -->
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
        </div>
    </div>
    <!-- Page Content -->
</div>
@include('layouts.includes.footer')
<script>
    $(function(){
        myWishlist();
    });
</script>