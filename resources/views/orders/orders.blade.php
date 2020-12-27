@include('layouts.includes.header')
@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="text-capitalize font-600 m-0 p-0">
                My Orders
            </h5>
            <ol class="breadcrumb float-sm-right bg-transparent">
                <li class="breadcrumb-item d-none d-md-inline">
                    <a href="/" class="d-flex align-items-center text-primary">
                        <i class="material-icons">store</i>
                    </a>
                </li>
                <li class="breadcrumb-item text-capitalize d-none d-md-inline">Account</li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container justify-content-center mb-5">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3 d-none d-md-block" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a href="#v-pills-sent" data-toggle="pill" class="nav-link active" id="v-pills-sent-orders-tab" role="tab" aria-controls="v-pills-sent" aria-selected="true">
                    Sent Orders
                    <span class="badge badge-light ml-auto">
                        {{ countSentOrders() }}
                    </span>
                </a>
                <a href="#v-pills-received" data-toggle="pill" class="nav-link" id="v-pills-received-orders-tab" role="tab" aria-controls="v-pills-received" aria-selected="false">
                    Received Orders
                    <span class="badge badge-light ml-auto">
                        {{ countReceivedOrders() }}
                    </span>
                </a>
                <a href="#v-pills-cancelled" data-toggle="pill" class="nav-link" id="v-pills-cancelled-orders-tab" role="tab" aria-controls="v-pills-cancelled" aria-selected="false">
                    Cancelled Orders
                    <span class="badge badge-light ml-auto">
                        {{ countCancelledOrders() }}
                    </span>
                </a>
            </div>
            <div class="tab-content w-75 ml-md-5" id="v-pills-tabContent">
                <!-- Sent Orders -->
                <div class="tab-pane fade show active" id="v-pills-sent" role="tabpanel" aria-labelledby="v-pills-sent-orders-tab">
                    @if(countSentOrders() > 0)
                        @foreach (sentOrders() as $order)
                            <div class="row main-section justify-content-center mb-2">
                                <!-- Order Details -->
                                <div class="jumbotron rounded mb-1 py-2 w-100">
                                    <div class="d-flex align-items-center">
                                        <div class="media">
                                            <img src="{{ recipientsPic($order->customer_phone) }}" alt="{{ recipientsName($order->customer_phone) }}" height="30" width="30" class="img-circle box-shadow-sm mr-2 align-self-center">
                                            <div class="media-body mt-2">
                                                <a href="">
                                                    <h6 class="text-sm font-700 my-0 py-0 text-capitalize">
                                                        {{ recipientsName($order->customer_phone) }}
                                                    </h6>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center ml-auto">
                                            <div class="d-flex align-items-center bg-light-blue">
                                                {!! orderStatus($order->id) !!}
                                            </div>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center ml-3" data-toggle="dropdown" aria-expanded="false" id="order-dropdown">
                                                    <i class="material-icons">more_horiz</i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2" aria-labelledby="order-dropdown">
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">settings</i>
                                                        <span>Notification settings</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">cancel</i>
                                                        <span>Cancel order</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">share</i>
                                                        <span>Export gift order</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">print</i>
                                                        <span>Print gift order</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-8 pr-md-0">
                                        <div class="box-shadow-sm bg-whitesmoke rounded p-2">
                                            <h5 class="font-600 lead">Order Details</h5>
                                            <div class="media">
                                                <div class="order-date box-shadow-sm rounded-2">
                                                    <div class="date-header bg-brick-red w-100"></div>
                                                    <div class="ordered-on bg-white text-center">
                                                        <h5 class="font-700 lead-2x text-dark my-0 py-0">{{ date('d', strtotime($order->delivery_date)) }}</h5>
                                                        <h6 class="my-0 py-0 text-uppercase text-dark font-600">{{ date('M', strtotime($order->delivery_date)) }}</h6>
                                                    </div>
                                                </div>
                                                <div class="w-100 ml-2">
                                                    <h6 class="font-weight-bold text-sm text-faded text-uppercase d-flex align-items-center my-0">
                                                        <i class="material-icons mr-2">access_time</i>
                                                        {{ date('M d, Y', strtotime($order->created_at)) }} 
                                                        <span class="text-lowercase mx-1 text-faded">at</span> 
                                                        {{ date('H:ia', strtotime($order->created_at)) }} 
                                                    </h6>
                                                    <h6 class="font-weight-bold text-sm text-faded d-flex align-items-center my-0">
                                                        <i class="material-icons mr-2">redeem</i> 
                                                        @if($order->ordered_items == 1)
                                                            1 gift item
                                                        @else
                                                            {{ $order->ordered_items}} gift items
                                                        @endif
                                                    </h6>
                                                    <h5 class="font-600 text-faded text-capitalize">Birthday present</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-shadow-sm bg-whitesmoke rounded mt-1">
                                            <div class="owl-carousel owl-theme ordered-gifts">
                                                @foreach (orderedItems($order->id) as $gift)
                                                    <!-- Ordered Gift -->
                                                    <div class="item mx-2 my-2">
                                                        <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                                                            <div class="gift-content mx-1">
                                                                <h6 class="my-0 py-0 text-capitalize text-sm">{{ mb_strimwidth($gift->gift_name, 0, 25, '...') }}</h6>
                                                                <div class="d-inline-block w-100 lh-100">
                                                                    @if ($gift->quantity == 1)
                                                                        <h6 class="my-0 py-0 text-sm text-capitalize">1 item</h6>
                                                                    @else
                                                                        <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->quantity }} items</h6> 
                                                                    @endif
                                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                                        <div>
                                                                            @if (giftRating($gift->gift_id) > 0)
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="text-warning mr-1">&starf;</span>
                                                                                    <span class="text-sm text-muted">{{ number_format(giftRating($gift->gift_id), 1) }}</span>
                                                                                </div>
                                                                            @else 
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="text-muted mr-1">&star;</span>
                                                                                    <span class="text-sm text-muted">0.0</span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        @if (soldCategoryGifts($gift->gift_id) > 0)
                                                                            <span class="text-sm text-muted mr-2">{{ soldCategoryGifts($gift->gift_id) }} Sold</span> 
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="usd-price">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">US${{ number_format($gift->usd_price, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="zar-price d-none">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">R{{ number_format($gift->zar_price * 16.5, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="zwl-price d-none">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">ZW${{ number_format($gift->zwl_price * 100, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.Ordered Gift -->
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="card bg-whitesmoke box-shadow-sm rounded-2 border-0">
                                            <div class="card-img-top">
                                                <img src="{{ asset('img/app/order-map.PNG') }}" alt="" class="img-fluid">
                                            </div>
                                            <div class="card-body rounded-2">
                                                <h6 class="font-600 mb-0">{{ $order->customer_name }}'s location</h6>
                                                <p class="my-0 text-capitalize">{{ $order->customer_address }}, {{ $order->customer_city }}</p>
                                            </div>
                                        </div>
                                        <div class="box-shadow-sm bg-whitesmoke rounded-2 mt-1 p-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="font-600 ml-1">Order History</h5>
                                                @if(recipientOrders(Auth::user()->id, $order->customer_phone) > 1)
                                                    <a href="">See All</a>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-around mt-1 w-100">
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0">{{ recipientOrders(Auth::user()->id, $order->customer_phone) }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">times</h6>
                                                </div>
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0 usd-price">${{ $order->usd_total }}</h6>
                                                    <h6 class="font-600 my-0 zar-price d-none">R{{ $order->zar_total }}</h6>
                                                    <h6 class="font-600 my-0 zwl-price d-none">${{ $order->zwl_total }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">total</h6>
                                                </div>
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0">{{ recipientGifts(Auth::user()->id, $order->customer_phone) }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">gifts</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Order Details -->
                            </div>
                        @endforeach
                    @else 
                        <div class="box-shadow-sm bg-whitesmoke rounded-2 d-grid py-5">
                            <div class="m-auto d-flex flex-column text-center w-50">
                                <i class="material-icons fa-5x text-muted">local_shipping</i>
                                <h6 class="font-600 text-muted lead mt-3">
                                    You've not sent any gifts to anyone yet! If you do, they'll show up here.
                                </h6>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.Sent Orders -->

                <!-- Received Orders -->
                <div class="tab-pane fade" id="v-pills-received" role="tabpanel" aria-labelledby="v-pills-received-orders-tab">
                    @if(countReceivedOrders() > 0)
                        @foreach (receivedOrders() as $order)
                            <div class="row main-section justify-content-center mb-2">
                                <!-- Order Details -->
                                <div class="jumbotron rounded mb-1 py-2 w-100">
                                    <div class="d-flex align-items-center">
                                        <div class="media">
                                            <img src="{{ sendersPic($order->user_id) }}" alt="{{ sendersName($order->user_id) }}" height="30" width="30" class="img-circle box-shadow-sm mr-2 align-self-center">
                                            <div class="media-body mt-2">
                                                <a href="">
                                                    <h6 class="text-sm font-700 my-0 py-0 text-capitalize">
                                                        {{ sendersName($order->user_id) }}
                                                    </h6>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center ml-auto">
                                            <div class="d-flex align-items-center bg-light-blue">
                                                {!! orderStatus($order->id) !!}
                                            </div>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center ml-3" data-toggle="dropdown" aria-expanded="false" id="order-dropdown">
                                                    <i class="material-icons">more_horiz</i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2" aria-labelledby="order-dropdown">
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">settings</i>
                                                        <span>Notification settings</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">cancel</i>
                                                        <span>Cancel order</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">share</i>
                                                        <span>Export gift order</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">print</i>
                                                        <span>Print gift order</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-8 pr-md-0">
                                        <div class="box-shadow-sm bg-whitesmoke rounded p-2">
                                            <h5 class="font-600 lead">Order Details</h5>
                                            <div class="media">
                                                <div class="order-date box-shadow-sm rounded-2">
                                                    <div class="date-header bg-brick-red w-100"></div>
                                                    <div class="ordered-on bg-white text-center">
                                                        <h5 class="font-700 lead-2x text-dark my-0 py-0">{{ date('d', strtotime($order->delivery_date)) }}</h5>
                                                        <h6 class="my-0 py-0 text-uppercase text-dark font-600">{{ date('M', strtotime($order->delivery_date)) }}</h6>
                                                    </div>
                                                </div>
                                                <div class="w-100 ml-2">
                                                    <h6 class="font-weight-bold text-sm text-faded text-uppercase d-flex align-items-center my-0">
                                                        <i class="material-icons mr-2">access_time</i>
                                                        {{ date('M d, Y', strtotime($order->created_at)) }} 
                                                        <span class="text-lowercase mx-1 text-faded">at</span> 
                                                        {{ date('H:ia', strtotime($order->created_at)) }} 
                                                    </h6>
                                                    <h6 class="font-weight-bold text-sm text-faded d-flex align-items-center my-0">
                                                        <i class="material-icons mr-2">redeem</i> 
                                                        @if($order->ordered_items == 1)
                                                            1 gift item
                                                        @else
                                                            {{ $order->ordered_items}} gift items
                                                        @endif
                                                    </h6>
                                                    <h5 class="font-600 text-faded text-capitalize">Birthday present</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-shadow-sm bg-whitesmoke rounded mt-1">
                                            <div class="owl-carousel owl-theme ordered-gifts">
                                                @foreach (orderedItems($order->id) as $gift)
                                                    <!-- Ordered Gift -->
                                                    <div class="item mx-2 my-2">
                                                        <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                                                            <div class="gift-content mx-1">
                                                                <h6 class="my-0 py-0 text-capitalize text-sm">{{ mb_strimwidth($gift->gift_name, 0, 25, '...') }}</h6>
                                                                <div class="d-inline-block w-100 lh-100">
                                                                    @if ($gift->quantity == 1)
                                                                        <h6 class="my-0 py-0 text-sm text-capitalize">1 item</h6>
                                                                    @else
                                                                        <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->quantity }} items</h6> 
                                                                    @endif
                                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                                        <div>
                                                                            @if (giftRating($gift->gift_id) > 0)
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="text-warning mr-1">&starf;</span>
                                                                                    <span class="text-sm text-muted">{{ number_format(giftRating($gift->gift_id), 1) }}</span>
                                                                                </div>
                                                                            @else 
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="text-muted mr-1">&star;</span>
                                                                                    <span class="text-sm text-muted">0.0</span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        @if (soldCategoryGifts($gift->gift_id) > 0)
                                                                            <span class="text-sm text-muted mr-2">{{ soldCategoryGifts($gift->gift_id) }} Sold</span> 
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="usd-price">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">US${{ number_format($gift->usd_price, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="zar-price d-none">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">R{{ number_format($gift->zar_price * 16.5, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="zwl-price d-none">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">ZW${{ number_format($gift->zwl_price * 100, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.Ordered Gift -->
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="card bg-whitesmoke box-shadow-sm rounded-2 border-0">
                                            <div class="card-img-top">
                                                <img src="{{ asset('img/app/order-map.PNG') }}" alt="" class="img-fluid">
                                            </div>
                                            <div class="card-body rounded-2">
                                                <h6 class="font-600 mb-0">{{ sendersFname($order->user_id) }}'s location</h6>
                                                <p class="my-0 text-capitalize">{{ sendersAddress($order->user_id) ?? 'Location not found.' }}</p>
                                            </div>
                                        </div>
                                        <div class="box-shadow-sm bg-whitesmoke rounded-2 mt-1 p-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="font-600 ml-1">Order History</h5>
                                                @if(recipientOrders(Auth::user()->id, $order->customer_phone) > 1)
                                                    <a href="">See All</a>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-around mt-1 w-100">
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0">{{ recipientOrders($order->user_id, Auth::user()->mobile_phone) }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">times</h6>
                                                </div>
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0 usd-price">${{ $order->usd_total }}</h6>
                                                    <h6 class="font-600 my-0 zar-price d-none">R{{ $order->zar_total }}</h6>
                                                    <h6 class="font-600 my-0 zwl-price d-none">${{ $order->zwl_total }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">total</h6>
                                                </div>
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0">{{ recipientGifts($order->user_id, Auth::user()->mobile_phone) }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">gifts</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Order Details -->
                            </div>
                        @endforeach
                    @else
                        <div class="box-shadow-sm bg-whitesmoke rounded-2 d-grid py-5">
                            <div class="m-auto d-flex flex-column text-center w-50">
                                <i class="fa fa-dropbox fa-5x text-muted"></i>
                                <h6 class="font-600 text-muted lead mt-3">
                                    You've not received any gifts from anyone yet! If you do, they'll show up here.
                                </h6>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.Received Orders -->

                <!-- Cancelled Orders -->
                <div class="tab-pane fade" id="v-pills-cancelled" role="tabpanel" aria-labelledby="v-pills-cancelled-orders-tab">
                    @if(countCancelledOrders() > 0)
                        @foreach (cancelledOrders() as $order)
                            <div class="row main-section justify-content-center mb-2">
                                <!-- Order Details -->
                                <div class="jumbotron rounded mb-1 py-2 w-100">
                                    <div class="d-flex align-items-center">
                                        <div class="media">
                                            <img src="/storage/users/{{ Auth::user()->profile_pic }}" alt="{{ Auth::user()->name }}" height="30" width="30" class="img-circle box-shadow-sm mr-2 align-self-center">
                                            <div class="media-body mt-2">
                                                <a href="">
                                                    <h6 class="text-sm font-700 my-0 py-0 text-capitalize">
                                                        Me
                                                    </h6>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center ml-auto">
                                            <div class="d-flex align-items-center bg-light-blue">
                                                <i class="material-icons text-danger">cancel</i>
                                                <p class="my-0 py-0 text-sm font-600 ml-1 text-capitalize">Cancelled</p>
                                            </div>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center ml-3" data-toggle="dropdown" aria-expanded="false" id="order-dropdown">
                                                    <i class="material-icons">more_horiz</i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2" aria-labelledby="order-dropdown">
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">settings</i>
                                                        <span>Notification settings</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">cancel</i>
                                                        <span>Cancel order</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">share</i>
                                                        <span>Export gift order</span>
                                                    </a>
                                                    <a href="" class="dropdown-item d-flex align-items-center">
                                                        <i class="material-icons mr-2">print</i>
                                                        <span>Print gift order</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-8 pr-md-0">
                                        <div class="box-shadow-sm bg-whitesmoke rounded p-2">
                                            <h5 class="font-600 lead">Order Details</h5>
                                            <div class="media">
                                                <div class="order-date box-shadow-sm rounded-2">
                                                    <div class="date-header bg-brick-red w-100"></div>
                                                    <div class="ordered-on bg-white text-center">
                                                        <h5 class="font-700 lead-2x text-dark my-0 py-0">{{ date('d', strtotime($order->delivery_date)) }}</h5>
                                                        <h6 class="my-0 py-0 text-uppercase text-dark font-600">{{ date('M', strtotime($order->delivery_date)) }}</h6>
                                                    </div>
                                                </div>
                                                <div class="w-100 ml-2">
                                                    <h6 class="font-weight-bold text-sm text-faded text-uppercase d-flex align-items-center my-0">
                                                        <i class="material-icons mr-2">access_time</i>
                                                        {{ date('M d, Y', strtotime($order->created_at)) }} 
                                                        <span class="text-lowercase mx-1 text-faded">at</span> 
                                                        {{ date('H:ia', strtotime($order->created_at)) }} 
                                                    </h6>
                                                    <h6 class="font-weight-bold text-sm text-faded d-flex align-items-center my-0">
                                                        <i class="material-icons mr-2">redeem</i> 
                                                        @if($order->ordered_items == 1)
                                                            1 gift item
                                                        @else
                                                            {{ $order->ordered_items}} gift items
                                                        @endif
                                                    </h6>
                                                    <h5 class="font-600 text-faded text-capitalize">Birthday present</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-shadow-sm bg-whitesmoke rounded mt-1">
                                            <div class="owl-carousel owl-theme ordered-gifts">
                                                @foreach (orderedItems($order->id) as $gift)
                                                    <!-- Ordered Gift -->
                                                    <div class="item mx-2 my-2">
                                                        <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                                            <img src="/storage/gifts/{{ $gift->gift_image }}" height="150" class="card-img-top w-100 rounded-0">
                                                            <div class="gift-content mx-1">
                                                                <h6 class="my-0 py-0 text-capitalize text-sm">{{ mb_strimwidth($gift->gift_name, 0, 25, '...') }}</h6>
                                                                <div class="d-inline-block w-100 lh-100">
                                                                    @if ($gift->quantity == 1)
                                                                        <h6 class="my-0 py-0 text-sm text-capitalize">1 item</h6>
                                                                    @else
                                                                        <h6 class="my-0 py-0 text-sm text-capitalize">{{ $gift->quantity }} items</h6> 
                                                                    @endif
                                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                                        <div>
                                                                            @if (giftRating($gift->gift_id) > 0)
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="text-warning mr-1">&starf;</span>
                                                                                    <span class="text-sm text-muted">{{ number_format(giftRating($gift->gift_id), 1) }}</span>
                                                                                </div>
                                                                            @else 
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="text-muted mr-1">&star;</span>
                                                                                    <span class="text-sm text-muted">0.0</span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        @if (soldCategoryGifts($gift->gift_id) > 0)
                                                                            <span class="text-sm text-muted mr-2">{{ soldCategoryGifts($gift->gift_id) }} Sold</span> 
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="usd-price">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">US${{ number_format($gift->usd_price, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="zar-price d-none">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">R{{ number_format($gift->zar_price * 16.5, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="zwl-price d-none">
                                                                    <div class="d-flex align-items-center">
                                                                        <h6 class="text-sm font-600">ZW${{ number_format($gift->zwl_price * 100, 2) }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.Ordered Gift -->
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="card bg-whitesmoke box-shadow-sm rounded-2 border-0">
                                            <div class="card-img-top">
                                                <img src="{{ asset('img/app/order-map.PNG') }}" alt="" class="img-fluid">
                                            </div>
                                            <div class="card-body rounded-2">
                                                <h6 class="font-600 mb-0">{{ sendersFname($order->user_id) }}'s location</h6>
                                                <p class="my-0 text-capitalize">{{ sendersAddress($order->user_id) ?? 'Location not found.' }}</p>
                                            </div>
                                        </div>
                                        <div class="box-shadow-sm bg-whitesmoke rounded-2 mt-1 p-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="font-600 ml-1">Order History</h5>
                                                @if(recipientOrders(Auth::user()->id, $order->customer_phone) > 1)
                                                    <a href="">See All</a>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-around mt-1 w-100">
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0">{{ recipientOrders($order->user_id, Auth::user()->mobile_phone) }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">times</h6>
                                                </div>
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0 usd-price">${{ $order->usd_total }}</h6>
                                                    <h6 class="font-600 my-0 zar-price d-none">R{{ $order->zar_total }}</h6>
                                                    <h6 class="font-600 my-0 zwl-price d-none">${{ $order->zwl_total }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">total</h6>
                                                </div>
                                                <div class="d-block text-center">
                                                    <h6 class="font-600 my-0">{{ recipientGifts($order->user_id, Auth::user()->mobile_phone) }}</h6>
                                                    <h6 class="text-uppercase font-weight-bold text-muted">gifts</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Order Details -->
                            </div>
                        @endforeach
                    @else
                        <div class="box-shadow-sm bg-whitesmoke rounded-2 d-grid py-5">
                            <div class="m-auto d-flex flex-column text-center w-50">
                                <i class="material-icons fa-5x text-muted">cancel</i>
                                <h6 class="font-600 text-muted lead mt-3">
                                    You've not cancelled any orders to anyone yet! If you do, they'll show up here.
                                </h6>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.Cancelled Orders -->
            </div>
        </div>
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')