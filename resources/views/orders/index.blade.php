@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5 d-none d-md-block">
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
        <!-- Small Screen Order Tabs -->
        <div class="row align-items-md-start">
            <div class="col-12 col-md-3 col-xl-2">
                <nav class="rounded-0 bg-whitesmoke box-shadow-sm border-top d-sm-block d-md-none fixed-top" id="mobile-tabs">
                    <div class="nav nav-tabs px-0 w-100 justify-content-around" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link rounded-0 active" id="nav-sent-tab" data-toggle="tab" href="#nav-sent" role="tab" aria-controls="nav-sent" aria-selected="true">
                            <div class="d-flex flex-column text-center font-600">
                                <i class="material-icons">local_shipping</i>
                                <span class="text-capitalize ml-1">Sent</span>
                            </div>
                        </a>
                        <a class="nav-item nav-link rounded-0" id="nav-receiving-tab" data-toggle="tab" href="#nav-received" role="tab" aria-controls="nav-receiving" aria-selected="false">
                            <div class="d-flex flex-column text-center font-600">
                                <i class="fa fa-dropbox icon-md"></i>
                                <span class="text-capitalize ml-1">Received</span>
                            </div>
                        </a>
                        <a class="nav-item nav-link rounded-0" id="nav-cancelled-tab" data-toggle="tab" href="#nav-cancelled" role="tab" aria-controls="nav-cancelled" aria-selected="false">
                            <div class="d-flex flex-column text-center font-600">
                                <i class="material-icons">cancel</i>
                                <span class="text-capitalize ml-1">Cancelled</span>
                            </div>
                        </a>
                    </div>
                </nav>
                <div class="nav flex-column nav-pills d-none d-md-block" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a href="#nav-sent" data-toggle="pill" class="nav-link active" id="nav-sent-tab" role="tab" aria-controls="nav-sent" aria-selected="true">
                        Sent 
                        <span class="badge badge-light ml-auto">
                            {{ countSentOrders() }}
                        </span>
                    </a>
                    <a href="#nav-received" data-toggle="pill" class="nav-link" id="nav-receiving-tab" role="tab" aria-controls="nav-receiving" aria-selected="false">
                        Received 
                        <span class="badge badge-light ml-auto">
                            {{ countReceivedOrders() }}
                        </span>
                    </a>
                    <a href="#nav-cancelled" data-toggle="pill" class="nav-link" id="nav-cancelled-tab" role="tab" aria-controls="nav-cancelled" aria-selected="false">
                        Cancelled
                        <span class="badge badge-light ml-auto">
                            {{ countCancelledOrders() }}
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-9 col-xl-10">
                <div class="tab-content rounded-0 mt-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-sent" role="tabpanel" aria-labelledby="nav-sent-tab">
                        @if(countSentOrders() > 0)
                            @foreach (sentOrders() as $order)
                                {{-- Order Details --}}
                                <div class="row main-section justify-content-center mb-2">
                                    <!-- Order Details -->
                                    <div class="bg-whitesmoke box-shadow-sm rounded mb-1 p-2 w-100">
                                        <div class="row justify-content-between align-items-center w-100">
                                            <div class="col">
                                                <h6 class="font-600 my-0 lead text-capitalize">
                                                    {{ $order->occasion }} Present
                                                </h6>
                                            </div>
                                            <div class="col d-flex justify-content-end">
                                                <h6 class="font-600 text-sm text-muted my-0">
                                                    Track-ID: {{ getTrackID($order->id) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-md-center">
                                            <div class="col">
                                                <div class="media">
                                                    <img src="{{ recipientsPic($order->customer_phone) }}" alt="{{ recipientsName($order->customer_phone) }}" height="45" width="45" class="img-circle box-shadow-sm mr-2 align-self-center">
                                                    <div class="media-body mt-2">
                                                        <a href="">
                                                            <h6 class="text-sm font-700 my-0 py-0 text-uppercase">
                                                                {{ recipientsName($order->customer_phone) }}
                                                            </h6>
                                                            <p class="text-sm font-700 my-0 py-0 text-capitalize text-faded">
                                                                {{ $order->customer_address }}
                                                            </p>
                                                            <p class="text-sm font-700 my-0 py-0 text-capitalize text-faded">
                                                                {{ $order->customer_phone }}
                                                            </p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col text-center">
                                                <h6 class="text-muted text-sm font-600 my-0 text-uppercase">ordered on</h6>
                                                <p class="lead my-0 text-muted">
                                                    {{ date('d M Y', strtotime($order->created_at)) }}
                                                </p>
                                            </div>
                                            <div class="col text-center">
                                                <h6 class="text-muted text-sm font-600 my-0 text-uppercase">delivery in</h6>
                                                <p class="lead my-0 text-muted">
                                                    {{ deliveryTime($order->delivery_date) }}
                                                </p>
                                            </div>
                                            <div class="col d-flex align-items-center justify-content-xl-end ml-auto">
                                                <div class="d-block text-center">
                                                    <h6 class="text-muted text-sm font-600 my-0 text-uppercase">status</h6>
                                                    <div class="d-flex align-items-center bg-light-blue">
                                                        {!! orderStatus($order->id) !!}
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center ml-3" id="order-menu-{{ $order->id }}" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_horiz</i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2" aria-labelledby="order-menu-{{ $order->id }}">
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
                                            <div class="card box-shadow-sm bg-whitesmoke">
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-hover table-sm mb-0 pb-0">
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Category</th>
                                                            <th>Item</th>
                                                            <th>Price</th>
                                                            <th class="text-center">Qty</th>
                                                        </tr>
                                                        @foreach (orderedItems($order->id) as $gift)
                                                        <tr>
                                                            <td>
                                                                    <img src="/storage/gifts/{{ giftImg($gift->gift_id) }}" height="50" class="rounded">
                                                            </td>
                                                            <td class="text-capitalize">{{ categoryName($gift->gift_id) }}</td>
                                                            <td class="text-capitalize">{{ giftName($gift->gift_id) }}</td>
                                                            <td>
                                                                <span class="usd-price">US${{ number_format(giftPrice($gift->gift_id), 2) }}</span>
                                                                <span class="zar-price d-none">R{{ number_format(giftPrice($gift->gift_id) * zaRate(), 2) }}</span>
                                                                <span class="zwl-price d-none">ZW${{ number_format(giftPrice($gift->gift_id) * zwRate(), 2) }}</span>
                                                            </td>
                                                            <td class="text-center">{{ $gift->qty }}</td>
                                                        </tr> 
                                                        @endforeach
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="card bg-whitesmoke box-shadow-sm rounded-2 border-0">
                                                <div class="card-img-top">
                                                    <img src="{{ asset('img/app/order-map.PNG') }}" alt="" class="img-fluid">
                                                </div>
                                                <div class="card-body rounded-2">
                                                    <h6 class="font-600 mb-0 text-capitalize">{{ $order->customer_name }}'s location</h6>
                                                    <p class="my-0 text-capitalize">{{ $order->customer_address }}, {{ $order->customer_city }}</p>
                                                </div>
                                            </div>
                                            <div class="box-shadow-sm bg-whitesmoke rounded-2 mt-1 p-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5 class="font-600 ml-1">Order Summary</h5>
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
                                                        <h6 class="font-600 my-0">{{ $order->ordered_items }}</h6>
                                                        <h6 class="text-uppercase font-weight-bold text-muted">gifts</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.Order Details -->
                                </div>
                                {{-- Order Details --}}
                            @endforeach
                        @else 
                            <div class="null-set container d-grid py-5">
                                <div class="m-auto d-flex flex-column text-center w-md-50">
                                    <i class="material-icons fa-5x text-muted">local_shipping</i>
                                    <h6 class="font-600 lead text-muted mt-3 px-2">
                                        You've not sent any gifts to anyone yet! If you do, they'll show up here.
                                    </h6>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="nav-received" role="tabpanel" aria-labelledby="nav-receiving-tab">
                        @if(countReceivedOrders() > 0)
                            @foreach (receivedOrders() as $order)
                                {{-- Order Details --}}
                                <div class="row main-section justify-content-center mb-2">
                                    <!-- Order Details -->
                                    <div class="bg-whitesmoke box-shadow-sm rounded mb-1 p-2 w-100">
                                        <div class="row justify-content-between align-items-center w-100">
                                            <div class="col">
                                                <h6 class="font-600 my-0 lead text-capitalize">
                                                    {{ $order->occasion }} Present
                                                </h6>
                                            </div>
                                            <div class="col d-flex justify-content-end">
                                                <h6 class="font-600 text-sm text-muted my-0">
                                                    Track-ID: {{ getTrackID($order->id) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-md-center">
                                            <div class="col">
                                                <div class="media">
                                                    <img src="{{ sendersPic($order->user_id) }}" alt="{{ sendersName($order->user_id) }}" height="45" width="45" class="img-circle box-shadow-sm mr-2 align-self-center">
                                                    <div class="media-body mt-2">
                                                        <a href="">
                                                            <h6 class="text-sm font-700 my-0 py-0 text-uppercase">
                                                                {{ sendersName($order->user_id) }}
                                                            </h6>
                                                            <p class="text-sm font-700 my-0 py-0 text-capitalize text-faded">
                                                                {{ sendersAddress($order->user_id) }}
                                                            </p>
                                                            <p class="text-sm font-700 my-0 py-0 text-capitalize text-faded">
                                                                {{ sendersCell($order->user_id) }}
                                                            </p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col text-center">
                                                <h6 class="text-muted text-sm font-600 my-0 text-uppercase">ordered on</h6>
                                                <p class="lead my-0 text-muted">
                                                    {{ date('d M Y', strtotime($order->created_at)) }}
                                                </p>
                                            </div>
                                            <div class="col text-center">
                                                <h6 class="text-muted text-sm font-600 my-0 text-uppercase">delivery in</h6>
                                                <p class="lead my-0 text-muted">
                                                    {{ deliveryTime($order->delivery_date) }}
                                                </p>
                                            </div>
                                            <div class="col d-flex align-items-center justify-content-xl-end ml-auto">
                                                <div class="d-block text-center">
                                                    <h6 class="text-muted text-sm font-600 my-0 text-uppercase">status</h6>
                                                    <div class="d-flex align-items-center bg-light-blue">
                                                        {!! orderStatus($order->id) !!}
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center ml-3" id="order-menu-{{ $order->id }}" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_horiz</i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2" aria-labelledby="order-menu-{{ $order->id }}">
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
                                            <div class="card box-shadow-sm bg-whitesmoke">
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-hover table-sm mb-0 pb-0">
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Category</th>
                                                            <th>Item</th>
                                                            <th>Price</th>
                                                            <th class="text-center">Qty</th>
                                                        </tr>
                                                        @foreach (orderedItems($order->id) as $gift)
                                                        <tr>
                                                            <td>
                                                                    <img src="/storage/gifts/{{ giftImg($gift->gift_id) }}" height="50" class="rounded">
                                                            </td>
                                                            <td class="text-capitalize">{{ categoryName($gift->gift_id) }}</td>
                                                            <td class="text-capitalize">{{ giftName($gift->gift_id) }}</td>
                                                            <td>
                                                                <span class="usd-price">US${{ number_format(giftPrice($gift->gift_id), 2) }}</span>
                                                                <span class="zar-price d-none">R{{ number_format(giftPrice($gift->gift_id) * zaRate(), 2) }}</span>
                                                                <span class="zwl-price d-none">ZW${{ number_format(giftPrice($gift->gift_id) * zwRate(), 2) }}</span>
                                                            </td>
                                                            <td class="text-center">{{ $gift->qty }}</td>
                                                        </tr> 
                                                        @endforeach
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="card bg-whitesmoke box-shadow-sm rounded-2 border-0">
                                                <div class="card-img-top">
                                                    <img src="{{ asset('img/app/order-map.PNG') }}" alt="" class="img-fluid">
                                                </div>
                                                <div class="card-body rounded-2">
                                                    <h6 class="font-600 mb-0 text-capitalize">{{ sendersFname($order->user_id) }}'s location</h6>
                                                    <p class="my-0 text-capitalize">{{ sendersAddress($order->user_id) }}</p>
                                                </div>
                                            </div>
                                            <div class="box-shadow-sm bg-whitesmoke rounded-2 mt-1 p-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5 class="font-600 ml-1">Order Summary</h5>
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
                                                        <h6 class="font-600 my-0">{{ $order->ordered_items }}</h6>
                                                        <h6 class="text-uppercase font-weight-bold text-muted">gifts</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.Order Details -->
                                </div>
                                {{-- Order Details --}}
                            @endforeach
                        @else
                            <div class="null-set container d-grid py-5">
                                <div class="m-auto d-flex flex-column text-center w-md-50">
                                    <i class="fa fa-dropbox fa-5x text-muted"></i>
                                    <h6 class="font-600 lead text-muted mt-3 px-2">
                                        You've not received any gifts from anyone yet! If you do, they'll show up here.
                                    </h6>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="nav-cancelled" role="tabpanel" aria-labelledby="nav-cancelled-tab">
                        @if(countCancelledOrders() > 0)
                            @foreach (cancelledOrders() as $order)
                                 {{-- Order Details --}}
                                 <div class="row main-section justify-content-center mb-2">
                                    <!-- Order Details -->
                                    <div class="bg-whitesmoke box-shadow-sm rounded mb-1 p-2 w-100">
                                        <div class="row justify-content-between align-items-center w-100">
                                            <div class="col">
                                                <h6 class="font-600 my-0 lead text-capitalize">
                                                    {{ $order->occasion }} Present
                                                </h6>
                                            </div>
                                            <div class="col d-flex justify-content-end">
                                                <h6 class="font-600 text-sm text-muted my-0">
                                                    Track-ID: {{ getTrackID($order->id) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-md-center">
                                            <div class="col">
                                                <div class="media">
                                                    <img src="{{ recipientsPic($order->customer_phone) }}" alt="{{ recipientsName($order->customer_phone) }}" height="45" width="45" class="img-circle box-shadow-sm mr-2 align-self-center">
                                                    <div class="media-body mt-2">
                                                        <a href="">
                                                            <h6 class="text-sm font-700 my-0 py-0 text-uppercase">
                                                                {{ recipientsName($order->customer_phone) }}
                                                            </h6>
                                                            <p class="text-sm font-700 my-0 py-0 text-capitalize text-faded">
                                                                {{ $order->customer_address }}
                                                            </p>
                                                            <p class="text-sm font-700 my-0 py-0 text-capitalize text-faded">
                                                                {{ $order->customer_phone }}
                                                            </p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col text-center">
                                                <h6 class="text-muted text-sm font-600 my-0 text-uppercase">ordered on</h6>
                                                <p class="lead my-0 text-muted">
                                                    {{ date('d M Y', strtotime($order->created_at)) }}
                                                </p>
                                            </div>
                                            <div class="col text-center">
                                                <h6 class="text-muted text-sm font-600 my-0 text-uppercase">delivery in</h6>
                                                <p class="lead my-0 text-muted">
                                                    {{ deliveryTime($order->delivery_date) }}
                                                </p>
                                            </div>
                                            <div class="col d-flex align-items-center justify-content-xl-end ml-auto">
                                                <div class="d-block text-center">
                                                    <h6 class="text-muted text-sm font-600 my-0 text-uppercase">status</h6>
                                                    <div class="d-flex align-items-center bg-light-blue">
                                                        {!! orderStatus($order->id) !!}
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center ml-3" id="order-menu-{{ $order->id }}" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="material-icons">more_horiz</i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right app-dropdown box-shadow-sm rounded-2" aria-labelledby="order-menu-{{ $order->id }}">
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
                                            <div class="card box-shadow-sm bg-whitesmoke">
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-hover table-sm mb-0 pb-0">
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Category</th>
                                                            <th>Item</th>
                                                            <th>Price</th>
                                                            <th class="text-center">Qty</th>
                                                        </tr>
                                                        @foreach (orderedItems($order->id) as $gift)
                                                        <tr>
                                                            <td>
                                                                    <img src="/storage/gifts/{{ giftImg($gift->gift_id) }}" height="50" class="rounded">
                                                            </td>
                                                            <td class="text-capitalize">{{ categoryName($gift->gift_id) }}</td>
                                                            <td class="text-capitalize">{{ giftName($gift->gift_id) }}</td>
                                                            <td>
                                                                <span class="usd-price">US${{ number_format(giftPrice($gift->gift_id), 2) }}</span>
                                                                <span class="zar-price d-none">R{{ number_format(giftPrice($gift->gift_id) * zaRate(), 2) }}</span>
                                                                <span class="zwl-price d-none">ZW${{ number_format(giftPrice($gift->gift_id) * zwRate(), 2) }}</span>
                                                            </td>
                                                            <td class="text-center">{{ $gift->qty }}</td>
                                                        </tr> 
                                                        @endforeach
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="card bg-whitesmoke box-shadow-sm rounded-2 border-0">
                                                <div class="card-img-top">
                                                    <img src="{{ asset('img/app/order-map.PNG') }}" alt="" class="img-fluid">
                                                </div>
                                                <div class="card-body rounded-2">
                                                    <h6 class="font-600 mb-0 text-capitalize">{{ $order->customer_name }}'s location</h6>
                                                    <p class="my-0 text-capitalize">{{ $order->customer_address }}, {{ $order->customer_city }}</p>
                                                </div>
                                            </div>
                                            <div class="box-shadow-sm bg-whitesmoke rounded-2 mt-1 p-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5 class="font-600 ml-1">Order Summary</h5>
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
                                                        <h6 class="font-600 my-0">{{ $order->ordered_items }}</h6>
                                                        <h6 class="text-uppercase font-weight-bold text-muted">gifts</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.Order Details -->
                                </div>
                                {{-- Order Details --}}
                            @endforeach
                        @else
                            <div class="null-set container d-grid py-5">
                                <div class="m-auto d-flex flex-column text-center w-md-50">
                                    <i class="material-icons fa-5x text-muted">cancel</i>
                                    <h6 class="font-600 lead text-muted mt-3 px-2">
                                        You've not cancelled any orders to anyone yet! If you do, they'll show up here.
                                    </h6>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Small Screen Order Tabs -->
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')