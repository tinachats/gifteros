 <!-- Side Nav -->
 <aside class="main-sidebar box-shadow-sm" tabindex="-1">
    <!-- Sidebar-header -->
    <div class="sidebar-header d-flex align-items-center pl-3 box-shadow-sm sticky-top">
        <span role="button" class="material-icons menu-btn" title="Toggle Sidebar">menu</span>
        <a href="/" class="navbar-brand font-700 ml-4">
            <img src="{{ asset('img/app/visionaries-logo.png') }}" height="35" width="35" alt=""> {{ config('app.name') }}
        </a>
    </div>
    <!-- /.Sidebar-header -->
    <!-- Sidebar Menu -->
    <nav class="side-menu">
        <!-- User Panel -->
        @auth
        <div class="media px-2">
            <a href="/account">
                <img src="/storage/users/{{ Auth::user()->profile_pic }}" height="40" width="40" class="img align-self-center rounded-circle prof-pic mr-2">
            </a>
            <div class="media-body">
                <a href="/account">
                    <h6 class="text-capitalize my-0 py-0">{!!greeting()!!}</h6>
                    <div class="d-flex align-items-center text-capitalize">
                        {{ Auth::user()->name }}
                    </div>
                </a>
            </div>
        </div>
        @endauth

        @guest
        <div class="media px-2">
            <a href="/login">
                <img src="/storage/users/user.png" height="40" width="40" class="img align-self-center rounded-circle prof-pic mr-2">
            </a>
            <div class="media-body">
                <a href="/login">
                    <h6 class="text-capitalize my-0 py-0">{!!greeting()!!}</h6>
                    <div class="d-flex align-items-center text-capitalize">
                        Sign-in
                    </div>
                </a>
            </div>
        </div>
        @endguest
        <!-- /.User Panel -->
        
        <hr class="bg-light">

        <!-- Menu list -->
        <ul class="px-2">
            <!-- Side-menu-item -->
            <li class="side-menu-item p-2">
                <a href="/" class="d-flex align-items-center">
                    <i class="material-icons mr-2">home</i>
                    <span class="text-capitalize">Home</span>
                </a>
            </li>
            <!-- /.Side-menu-item -->

            @auth
            <!-- Side-menu-item -->
            <li class="side-menu-item p-2">
                <a href="/account" class="d-flex align-items-center">
                    <i class="material-icons mr-2">person</i>
                    <span class="text-capitalize">Account</span>
                </a>
            </li>
            <!-- /.Side-menu-item -->
            @endauth

            <!-- Side-menu-item -->
            <li class="side-menu-item d-sm-block d-md-none p-2">
                <a href="" class="d-flex align-items-center">
                    <i class="material-icons mr-2">store</i>
                    <span class="text-capitalize">Gift store</span>
                </a>
            </li>
            <!-- /.Side-menu-item -->
            
            <!-- Side-menu-item -->
            <li role="button" class="side-menu-item collapsible-item d-sm-block d-md-none p-2" data-toggle="collapse" href="#categories" aria-expanded="false" aria-controls="fireplaces">
                <a class="d-flex align-items-center">
                    <i class="material-icons mr-2">apps</i>
                    <span class="text-capitalize">Gift Categories</span>
                    <span role="button" class="material-icons ml-auto collapse-icon expand">expand_more</span>
                    <span role="button" class="material-icons ml-auto collapse-icon compress">expand_less</span>
                </a>
            </li>
            <div class="collapse d-sm-block d-md-none ml-2" id="categories">
                <ul class="px-1">
                    {{-- Show a list of all product categories --}}
                </ul>
            </div>
            <!-- /.Side-menu-item -->

            <?php if(isset($_SESSION['user_id'])): ?>
            <!-- Side-menu-item -->
            <li class="side-menu-item p-2">
                <a class="d-flex align-items-center" href="orders.php">
                    <i class="material-icons mr-2">local_shipping</i>
                    <span class="text-capitalize">My Orders</span>
                    <span class="badge app-badge ml-auto">
                        {{-- Count user's orders --}}
                    </span>
                </a>
            </li>
            <!-- /.Side-menu-item -->

            <?php if(countOrders($connect, $_SESSION['user_id']) > 0): ?>
            <!-- Side-menu-item -->
            <li class="d-flex align-items-center side-menu-item p-2">
                <i class="material-icons mr-2">sync</i>
                <span class="text-capitalize">Buy again</span>
            </li>
            <!-- /.Side-menu-item -->

            <!-- Side-menu-item -->
            <li class="side-menu-item p-2">
                <a href="fireplaces.php" class="d-flex align-items-center">
                    <i class="material-icons mr-2">monetization_on</i>
                    <span class="text-capitalize">my coupons</span>
                </a>
            </li>
            <!-- /.Side-menu-item -->
            <?php endif; ?>
            <?php endif; ?>

            <hr class="border-inverse my-1">

            <?php if(isset($_SESSION['user_id'])): ?>
            <!-- Side-menu-item -->
            <li class="side-menu-item p-2">
                <a href="javascript:void()" class="d-flex align-items-center toggle-ratingbox">
                    <i class="material-icons mr-2">stars</i>
                    <span class="text-capitalize">rate & review</span>
                </a>
            </li>
            <!-- /.Side-menu-item -->
            <?php endif; ?>

            <!-- Side-menu-item -->
            <li class="side-menu-item p-2">
                <a href="about.php" class="d-flex align-items-center">
                    <i class="material-icons mr-2">info_outline</i>
                    <span class="text-capitalize">about</span>
                </a>
            </li>
            <!-- /.Side-menu-item -->

        </ul>
        <!-- /.Menu list -->
    </nav>
    <!-- /.Sidebar Menu -->
</aside>
<!-- /.Side bar -->