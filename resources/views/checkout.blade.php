@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="checkout-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">Billing Info</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item">
                        <a href="/" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                            <span class="d-none d-md-inline text-primary">Store</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5">
        <div class="row">
            <!-- Product List -->
            <div class="col-12 col-md-6 col-lg-5 order-md-2 mb-2">
                <div class="basket-info">
                    <div class="d-flex align-items-center mb-1">
                        <h5 class="lead font-500 my-0 py-0">Gift Items:</h5>
                        <div class="ml-auto gift-items-count mr-2">
                            <span class="font-600 badge badge-pill badge-success text-white ml-2 cart-count">0</span>
                            <i class="material-icons fa-2x text-blue">redeem</i>
                        </div>
                    </div>
                </div>
                <ul class="list-group checkout-list rounded-0 box-shadow-sm">
                    <!-- Cart details will be shown here -->
                    <div class="shopping-bag">
                        @for ($i = 0; $i < 4; $i++)
                            <!-- Cart Item Placeholder-->
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
                                        <i class="content-placeholder cart-trash-button"></i>
                                    </div>
                                </div>
                            </li>
                            <!-- /.Cart Item Placeholder -->
                        @endfor
                    </div>
                    
                    <!-- Cart Subtotal -->
                    <li class="list-group-item rounded-0 lh-100 font-600 text-sm" id="cart-action-btns">
                        <div class="usd-price">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Subtotal Amount:</span>
                                <span class="usd-total">US$25.98</span>
                            </h6>
                        </div>
                        <div class="zar-price d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Subtotal Amount:</span>
                                <span class="zar-total">R428.67</span>
                            </h6>
                        </div>
                        <div class="zwl-price d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Subtotal Amount:</span>
                                <span class="zwl-total">ZW$2598</span>
                            </h6>
                        </div>
                    </li>
                    <!-- /.Cart Subtotal -->

                    <!-- Additional Charges -->
                    <div class="list-group rounded-0 additional-charges">
                        <li class="list-group-item rounded-0 lh-100 text-sm bg-transparent w-100">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Delivery Charges:</span>
                                <span id="usd-delivery" class="usd-price">US$0.00</span>
                                <span id="zar-delivery" class="zar-price">R0.00</span>
                                <span class="zwl-price" id="zwl-delivery">ZW$0.00</span>
                            </h6>
                        </li>
                        <li class="list-group-item rounded-0 lh-100 text-sm bg-transparent w-100 coupon d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Gift Voucher:</span>
                                <span class="usd-price" id="usd-coupon">US$0.00</span>
                                <span class="zar-price" id="zar-coupon">R0.00</span>
                                <span class="zwl-price" id="zwl-coupon">ZW$0.00</span>
                            </h6>
                        </li>
                        <li class="list-group-item rounded-0 lh-100 font-600 text-sm bg-transparent w-100">
                            <h6 class="font-700 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Total Amount:</span>
                                <span class="usd-price usd-total"></span>
                                <span class="zar-price zar-total"></span>
                                <span class="zwl-price zwl-total"></span>
                            </h6>
                        </li>
                    </div>
                    <!-- /.Additional Charges -->
                </ul>

                <!-- Gift Voucher -->
                <form method="post" class="card rounded-0 needs-validation bg-transparent p-2" id="coupon-form" novalidate>
                    <div class="input-group coupon-input">
                        <input type="text" class="form-control" name="voucher" id="voucher" placeholder="Gift voucher" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                    <span id="voucher-error" class="invalid-feedback text-sm font-600">Gift voucher required!</span>
                    <span id="voucher-success" class="valid-feedback text-sm font-600">Discount initiated.</span>
                </form>
                <!-- /.Gift Voucher -->
            </div>
            <!-- /.Product List -->

            <!-- Checkout Form -->
            <div class="col-12 col-md-6 col-lg-5 order-md-1">
                <div class="form-box bg-whitesmoke box-shadow-sm p-2">
                    <h6 class="font-600 text-faded text-uppercase">recipient's contact details</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <p>Fill in your delivery information.</p>
                        <button class="btn btn-light btn-sm" data-toggle="modal" href="#recipient-list">
                            <i class="fa fa-plus mr-1"></i>
                            Recipients List
                        </button>
                    </div>
                    <form action="stripe.php" class="needs-validation" method="post" id="checkout-form" novalidate>
                        <div class="form-group my-0 pt-0">
                            <label for="fullname" class="mb-0 text-sm text-faded font-500">Full name</label>
                            <i class="material-icons text-faded">person</i>
                            <input type="text" name="fullname" id="fullname" class="form-control font-500 text-faded text-capitalize" placeholder="Customer's full name" required>
                            <small class="text-danger form-error font-400 mt-0 pt-0">Full name required!</small>
                        </div>
                        <div class="form-group my-0 pt-0">
                            <label for="email" class="mb-0 text-sm text-faded font-500">Customer email (Optional)</label>
                            <i class="material-icons text-faded">email</i>
                            <input type="email" name="email" id="email" class="form-control font-500 text-faded" placeholder="email@example.com" onblur="emailValidation(this)">
                            <small class="text-danger form-error font-400 mt-0 pt-0">Email required!</small>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group my-0 pt-0">
                                    <label for="mobile-number" class="mb-0 text-sm text-faded font-500">Mobile Phone</label>
                                    <div class="mobile-input">
                                        <img src="dist/img/country-flag/flag-of-Zimbabwe.png" alt="" height="15" width="25" class="zim-flag">
                                        <input type="text" name="mobile-number" id="mobile-number" class="form-control font-500 text-faded" placeholder="2637********" data-inputmask='"mask": "263999999999"' required data-mask>
                                        <small class="text-danger form-error font-400 mt-0 pt-0">Mobile phone required!</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group my-0 pt-0">
                                    <label for="delivery-date" class="mb-0 text-sm text-faded font-500">Delivery Date</label>
                                    <input type="text" name="delivery-date" id="delivery-date" class="form-control datepicker font-500 text-faded"required>
                                    <small class="text-danger form-error font-400 mt-0 pt-0">Delivery date required!</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-0 pt-0">
                            <label for="customer-address" class="mb-0 text-sm text-faded font-500">Customer address</label>
                            <i class="material-icons text-faded">home</i>
                            <input type="text" name="customer-address" id="customer-address" class="form-control font-500 text-faded text-capitalize" placeholder="eg. 175 bradley rd., waterfalls" required>
                            <small class="text-danger form-error font-400 mt-0 pt-0">Email required!</small>
                        </div>
                        <label for="customer-suburb" class="mb-0 text-sm text-faded font-500">Customer suburb</label>
                        <div class="form-group icon-form-group my-0 pt-0">
                            <i class="material-icons select-icon icon text-faded">person_pin_circle</i>
                            <select name="customer-suburb" id="customer-suburb" class="custom-control form-control font-500 text-faded text-capitalize" onchange="deliveryCharge()" required>
                                <option value="0" selected>Select Suburb</option>
                                @foreach ($suburbs as $row)
                                    <option value="{{ $row->suburb_name }}" data-usd="{{ number_format($row->usd_price, 2) }}" data-zar="{{ number_format($row->zar_price, 2) }}" data-zwl="{{ number_format($row->zwl_price, 2) }}">
                                        {{ $row->suburb_name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger form-error font-400 mt-0 pt-0">Customer city required!</small>
                        </div>
                        <!-- Payment Options -->
                        <p class="text-sm text-faded mt-1 mb-0 pb-0 font-500 d-none">Payment Option</p>
                        <div class="form-check form-check-inline d-none">
                            <input class="form-check-input" type="radio" name="payment-option" id="debit-card" value="debit-card" onclick="paymentOption(this)" checked>
                            <label class="form-check-label" for="debit-card">Debit / Credit Card</label>
                        </div>
                        <div class="form-check form-check-inline d-none">
                            <input class="form-check-input" type="radio" name="payment-option" id="ecocash" value="ecocash" onclick="paymentOption(this)">
                            <label class="form-check-label" for="ecocash">Ecocash</label>
                        </div>
                        <div class="form-check form-check-inline d-none">
                            <input class="form-check-input" type="radio" name="payment-option" id="zimswitch" value="zimswitch" onclick="paymentOption(this)">
                            <label class="form-check-label" for="zimswitch">ZimSwitch</label>
                        </div>
                        <!-- /.Payment Options -->

                        <!-- Payment Gateways -->
                        <!-- Credit/Debit Card form -->
                        <div class="form-group my-0 pt-0 debit-card">
                            <label for="credit-card" class="mb-0 text-sm text-faded font-500">Credit card</label>
                            <div id="card-element" class="form-control validate borderless-input">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div class="text-danger" id="card-errors" role="alert"></div>
                        </div>
                        <!-- /.Credit/Debit Card form -->
                        <!-- Ecocash -->
                        <div class="form-group my-0 pt-0 d-none ecocash">
                            <label for="ecocash-number" class="mb-0 text-sm text-faded font-500">Ecocash Number</label>
                            <div class="mobile-input">
                                <img src="dist/img/country-flag/flag-of-Zimbabwe.png" alt="" height="15" width="25" class="zim-flag">
                                <input type="text" name="ecocash-number" id="ecocash-number" class="form-control font-500 text-faded" placeholder="2637********" data-inputmask='"mask": "263799999999"' required data-mask>
                                <small class="text-danger form-error font-400 mt-0 pt-0">Ecocash number required!</small>
                            </div>
                        </div>
                        <!-- /. Ecocash -->
                        <!-- ZimSwitch -->
                        <div class="form-group my-0 pt-0 d-none zimswitch">
                            <label for="account-number" class="mb-0 text-sm text-faded font-500">Account Number</label>
                            <div class="mobile-input">
                                <img src="dist/img/country-flag/flag-of-Zimbabwe.png" alt="" height="15" width="25" class="zim-flag">
                                <input type="text" name="account-number" id="account-number" class="form-control font-500 text-faded" placeholder="Account number" data-inputmask='"mask": "9999999999999999"' required data-mask>
                                <small class="text-danger form-error font-400 mt-0 pt-0">Account number required!</small>
                            </div>
                        </div>
                        <!-- /.Payment Gateways -->

                        <!-- Hidden inputs -->
                        <input type="hidden" name="action" id="action" value="customer-order">
                        <input type="hidden" name="usd-total" id="usd-total-cart">
                        <input type="hidden" name="zar-total" id="zar-total-cart">
                        <input type="hidden" name="zwl-total" id="zwl-total-cart">
                        <input type="hidden" name="count-cart" id="count-cart">
                        <input type="hidden" name="currency" id="currency">
                        <!-- /.Hidden inputs -->

                        <button type="submit" class="btn btn-primary btn-block font-600 my-2 px-3" id="checkout-btn">
                            Proceed to pay 
                            <span class="text-white usd-price usd-total">US$25.98</span>
                            <span class="text-white zar-price zar-total d-none">R428.67</span>
                            <span class="text-white zwl-price zwl-total d-none">ZW$2598</span>
                        </button>
                    </form>
                </div>
            </div>
            <!-- /.Checkout Form -->
        </div>
    </div>
    <!-- Page Content -->
</div>
@include('layouts.includes.footer')