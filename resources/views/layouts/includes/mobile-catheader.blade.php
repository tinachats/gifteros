@include('layouts.includes.header')
<style>
    @media(max-width: 660px){
        #mobile-filter-header{
            display: block
        }
    }

    @media(min-width: 768px){
        #mobile-filter-header{
            display: none
        }
    }
</style>
<!-- Header -->
<div id="mobile-filter-header">
    <header class="header fixed-top box-shadow-sm bg-whitesmoke">
        <!-- Main Navbar -->
        <nav class="nav navbar-expand-md main-nav justify-content-between py-2 px-md-1">
            <a href="/" class="nav-link icon-link go-back">
                <i class="material-icons">arrow_back</i>
            </a>
            <h5 class="font-600 my-0 py-0 text-capitalize">{{ $title }}</h5>
            <a href="#" class="nav-link icon-link toggle-search-form">
                <i class="material-icons search-icon">search</i>
            </a>
        </nav>
        <!-- /.Main Navbar -->

        <!-- Sub Nav -->
        <div class="mobile-sub-nav">
            <!-- Categories Chips Slider -->
            <div class="owl-carousel owl-theme category-filters m-2">
                @isset($sub_categories)
                    @foreach ($sub_categories as $sub_category)
                        <!-- Category Item -->
                        <div class="item">
                            <!-- Category Chip -->
                            <a role="button" href="#" class="sub-category-filter" data-id="{{ $sub_category->id }}">
                                <div class="category-chip rounded-pill">
                                    <img src="/storage/sub-categories/{{ $sub_category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $sub_category->name }}">
                                    <span class="text-lowercase text-faded">{{ mb_strimwidth($sub_category->name, 0, 10, '...') }}</span>
                                </div>
                            </a>
                            <!-- /.Category Chip -->
                        </div>
                        <!-- /.Category Item -->
                    @endforeach
                @endisset

                @isset($filters)
                    @foreach ($filters as $category)
                        <!-- Category Item -->
                        <div class="item">
                            <!-- Category Chip -->
                            <a role="button" href="{{ route('gifts_category', [$category->id, $category->category_slug]) }}" class="sub-category-filter" data-id="{{ $category->id }}">
                                <div class="category-chip rounded-pill">
                                    <img src="/storage/sub-categories/{{ $category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $category->category_name }}">
                                    <span class="text-lowercase text-faded">{{ mb_strimwidth($category->category_name, 0, 10, '...') }}</span>
                                </div>
                            </a>
                            <!-- /.Category Chip -->
                        </div>
                        <!-- /.Category Item -->
                    @endforeach
                @endisset

                @isset($sub_filters)
                    @foreach ($sub_filters as $sub_category)
                        <!-- Category Item -->
                        <div class="item">
                            <!-- Category Chip -->
                            <a role="button" href="#" class="sub-category-filter active" data-id="{{ $sub_category->id }}">
                                <div class="category-chip rounded-pill">
                                    <img src="/storage/sub-categories/{{ $sub_category->image }}" class="img-circle rounded-circle mr-2" width="40" height="40" alt="{{ $sub_category->name }}">
                                    <span class="text-lowercase text-faded">{{ mb_strimwidth($sub_category->name, 0, 10, '...') }}</span>
                                </div>
                            </a>
                            <!-- /.Category Chip -->
                        </div>
                        <!-- /.Category Item -->
                    @endforeach
                @endisset
            </div>
            <!-- /.Categories Chips Slider -->

            @if (isset($sub_categories) || isset($sub_filters))
                <!-- Settings Navbar -->
                <div class="d-flex justify-content-around mb-1">
                    <a href="#" class="nav-link icon-link toggle-filters">
                        <i class="material-icons">tune</i>
                    </a>
                    <select name="sorting-order" id="sorting-order" class="custom-select-sm custom-select text-primary text-sm bg-transparent rounded-0 border-0 w-50 px-1 py-1">
                        <option value="null" class="d-flex align-items-center" selected>
                            Sort gifts by
                        </option>
                        <option value="latest-gifts" class="d-flex align-items-center">
                            Latest gift items
                        </option>
                        <option value="price-asc" class="d-flex align-items-center">
                            Price - Low to High
                        </option>
                        <option value="price-desc" class="d-flex align-items-center">
                            Price - High to low
                        </option>
                        <option value="most-wished" class="d-flex align-items-center">
                            Most Wished for
                        </option>
                        <option value="trending-gifts" class="d-flex align-items-center">
                            Trending gifts
                        </option>
                    </select>
                    <a href="#" class="nav-link icon-link toggle-settings">
                        <i class="material-icons">settings</i>
                    </a>
                </div>
                <!-- /.Settings Navbar -->
            @endif
        </div>
        <!-- Sub Nav -->

        <!-- Search Form -->
        <form method="get" action="/search" id="search-form" class="bg-transparent filter-search-form d-none">
            {{ csrf_field() }}
            <div class="form-group mb-0 icon-form-group mb-0" id="search-bar">
                <i class="material-icons icon text-faded">search</i>
                <input type="search" name="search" id="search" class="form-control" placeholder="What are you looking for?">
                <ul class="list-group search-list box-shadow-sm d-none">
                    @for ($i = 0; $i < 5; $i++)
                        <!-- Search results loading -->
                        <li class="list-group-item rounded-0 lh-100 px-1 py-2 cart-menu-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex w-100">
                                    <!-- Product Item -->
                                    <div class="media align-items-center">
                                        <div class="cart-item-img-placeholder rounded-2 align-self-center mr-2"></div>

                                        <!-- Product Item Details -->
                                        <div class="media-body cart-details-placeholder">
                                            <div class="content-placeholder cart-item-name-placeholder"></div>
                                            <div class="content-placeholder cart-category-placeholder"></div>
                                            <div class="cart-rating-placeholder content-placeholder"></div>
                                            <div class="content-placeholder cart-stock-placeholder"></div>
                                        </div>
                                        <!-- Product Item Details -->
                                    </div>
                                    <!-- /.Product Item -->
                                </div>
                                <div class="d-block text-center">
                                    <p class="content-placeholder my-0 pt-0 pb-1 cart-item-price"></p>
                                    <button class="btn btn-cart-placeholder pt-1"></button>
                                </div>
                            </div>
                        </li>
                        <!-- /.Search Results Loading -->
                    @endfor
                    <!-- Search results will be shown here -->
                </ul>
            </div>
        </form>
        <!-- /.Search form -->
    </header>
    <!-- /.Header -->
</div>
        