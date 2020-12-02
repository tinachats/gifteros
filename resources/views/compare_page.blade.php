@include('layouts.includes.header')
@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">Gift Comparisons</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item d-none d-md-inline">
                        <a href="index.php" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ count(Session::get('comparisons')) }} Comparisons</li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid justify-content-center mb-5">
        <div class="d-grid grid-3 grid-p-1 account-page">
            <!-- Gift Comparisons will be shown here -->
            @foreach (Session::get('comparisons') as $gift_name)
                <p class="text-capitalize">
                    {{ $gift_name }}
                </p>
            @endforeach
        </div>
        <div class="row justify-content-md-start justify-content-sm-center">
            <button class="btn btn-primary d-flex align-items-center my-3 expire-session">
                <i class="material-icons mr-1">arrow_back</i>
                <span class="font-500 text-white">Continue shopping</span>
            </button>
        </div>
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')