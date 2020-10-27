@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">Design Page</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item d-none d-md-inline">
                        <a href="index.php" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                        </a>
                    </li>
                    <li class="breadcrumb-item text-capitalize d-none d-md-inline">Web</li>
                    <li class="breadcrumb-item active">Layouts</a></li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5">
        <div class="d-grid grid-5">
            <!-- Related Gifts Placeholder -->
            <div class="related-gift placeholder-card card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                <div class="placeholder-relative-img"></div>
                <div class="gift-content mx-1">
                    <div class="placeholder-title content-placeholder"></div>
                    <div class="d-inline-block w-100 lh-100">
                        <div class="gift-count-placeholder content-placeholder"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="gift-rating-placeholder content-placeholder"></div>
                        <div class="gift-rating-placeholder content-placeholder mr-2"></div>
                    </div>
                    <div class="price-range-placeholder mt-1 content-placeholder"></div>
                </div>
            </div>
            <!-- /.Related Gifts Placeholder -->
        </div>
    </div>
    <!-- /.Page Content -->
</div>
<!-- Page Content -->
@include('layouts.includes.footer')