@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content" id="checkout-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="text-capitalize font-600 m-0 p-0">Success Page</h5>
            <ol class="breadcrumb float-sm-right bg-transparent">
                <li class="breadcrumb-item">
                    <a href="/" class="d-flex align-items-center text-primary">
                        <i class="material-icons">store</i>
                        <span class="d-none d-md-inline text-primary">Store</span>
                    </a>
                </li>
                <li class="breadcrumb-item">Orders</li>
                <li class="breadcrumb-item active">Success</li>
            </ol>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Order Summary Details -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 order-md-2">
            <div class="bg-whitesmoke box-shadow-sm rounded-2 bordered">
                <div class="d-flex align-items-center justify-content-between box-shadow-sm p-2">
                    <div class="media">
                        <img src="{{ recipientsPic($cell) }}" alt="" height="50" width="50" class="align-self-start mr-2 rounded-circle">
                        <div class="media-body">
                            <h6 class="font-600 text-capitalize my-0">
                                {{ $name . ' ' . $surname }}
                            </h6>
                            <address class="lh-100">
                                <p class="my-0 text-capitalize text-sm">{{ $address }}</p>
                                <p class="my-0 text-capitalize text-sm">{{ $suburb }}</p>
                                <p class="my-0 text-sm">+263{{ $cell }}</p>
                                <p class="my-0 text-sm">{{ $email ?? ''}}</p>
                            </address>
                        </div>
                    </div>
                    <div class="media">
                        <div class="order-date box-shadow-sm rounded-2">
                            <div class="date-header bg-brick-red w-100"></div>
                            <div class="ordered-on bg-white text-center">
                                <h5 class="font-700 lead-2x text-dark my-0 py-0">{{ $date }}</h5>
                                <h6 class="my-0 py-0 text-uppercase text-dark font-600">{{ $month }}</h6>
                            </div>
                        </div>
                        <div class="w-100 ml-2">
                            <h6 class="font-weight-bold text-sm text-faded text-uppercase my-0">
                                Delivery details:
                            </h6>
                            <h6 class="font-weight-bold text-sm text-faded d-flex align-items-center my-0">
                                <i class="material-icons mr-2">redeem</i> 
                                @if($items == 1)
                                    1 gift item
                                @else 
                                    {{ $items }} gift items
                                @endif
                            </h6>
                            <h5 class="font-600 text-faded text-capitalize">{{ $occasion }}</h5>
                        </div>
                    </div>
                </div>
                <div class="delivery-animation">
                    <img src="{{ asset('img/app/animated/truck-load.gif') }}" height="400" alt="" class="w-100">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 order-md-1">
            <ul class="list-group box-shadow-sm rounded-2">
                <li class="list-group-item d-flex align-items-center justify-content-between rounded-top-2">
                    <div class="d-flex align-items-center">
                        <i class="material-icons text-success">check_circle</i>
                        <h6 class="font-600 my-0">Order Success</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="material-icons text-faded mr-1">receipt</i>
                        <span class="text-faded text-sm">{{ $trackid }}</span>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-around rounded-bottom-2">
                    <div class="d-block text-center lh-100">
                        <p class="text-sm text-faded mb-0">Delivery In</p>
                        <p class="text-sm mt-1">{{ deliveryTime($delivery_date) }}</p>
                    </div>

                    <div class="d-block text-center lh-100">
                        <p class="text-sm text-faded mb-0">Amount</p>
                        <p class="text-sm mt-1 usd-price">US${{ $total }}</p>
                        <p class="text-sm mt-1 zar-price d-none">R{{ number_format($total * zaRate(), 2) }}</p>
                        <p class="text-sm mt-1 zwl-price d-none">ZW${{ number_format($total * zwRate(), 2) }}</p>
                    </div>

                    <div class="d-block text-center lh-100">
                        <p class="text-sm text-faded mb-0">Coupon</p>
                        @if ($coupon == true)
                            <i class="material-icons text-success">done_all</i>
                        @else
                            <p class="text-sm mt-1">Null</p>
                        @endif
                    </div>
                    <div class="d-block text-center lh-100">
                        <p class="text-sm text-faded mb-0">Items</p>
                        <p class="text-sm mt-1">{{ $items }}</p>
                    </div>
                </li>
            </ul>
            <div class="my-2">
                <a href="/orders" role="button" class="btn btn-primary px-3 rounded-pill d-flex align-items-center justify-content-center">
                    <i class="material-icons mr-1">arrow_back</i> View Order Details
                </a>
            </div>
        </div>
    </div>
    <!-- /.Order Summary Details -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')