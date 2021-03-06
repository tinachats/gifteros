@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content" id="checkout-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-5">
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
    </div>
    <!-- /.content-header -->

    <!-- Checkout Details -->
    <div class="row justify-content-center">
        <!-- Recipient List -->
        <div class="col-12 col-xl-4 order-md-1">
            <!-- Send gift to a recipient -->
            <div class="list-group box-shadow-sm rounded-2">
                <li class="list-group-header list-group-item text-left rounded-top-2">
                    <h6 class="font-600">Choose Recipient</h6>
                </li>
                <!-- Recipient -->
                <li class="list-group-item d-flex align-items-center">
                    <!-- Custom Type -->
                    <div class="custom-type-radio custom-color shadow-sm" id="checkbox-id{{ Auth::user()->mobile_phone }}" data-cell="{{ Auth::user()->mobile_phone }}" data-name="{{ Auth::user()->name }}" data-address="{{ Auth::user()->address ?? '' }}" data-email="{{ Auth::user()->email }}">
                        <div class="color-inset">
                            <i class="material-icons color-selected-icon">done</i>
                        </div>
                    </div>
                    <!-- /.Custom Type -->

                    <!-- Recipient's Details -->
                    <div class="media ml-2 custom-type-label" data-id="{{ Auth::user()->mobile_phone }}" data-name="{{ Auth::user()->name }}" data-address="{{ Auth::user()->address ?? '' }}" data-email="{{ Auth::user()->email }}">
                        <img src="/storage/users/{{ Auth::user()->profile_pic }}" alt="" height="40" width="40" class="rounded-circle align-self-start mr-2">
                        <div class="media-body">
                            <h6 class="font-600 mb-0 text-capitalize">Me</h6>
                            <p class="text-sm my-0 text-capitalize">{{ Auth::user()->address ?? 'No delivery address found.' }}</p>
                        </div>
                    </div>
                    <!-- /.Recipient's Details -->
                </li>
                <!-- /.Recipient -->
                @if (count(recipients(Auth::user()->id)) > 0)
                    @foreach (recipients(Auth::user()->id) as $recipient)
                        <!-- Recipient -->
                        <li class="list-group-item d-flex align-items-center">
                            <!-- Custom Type -->
                            <div class="custom-type-radio custom-color shadow-sm" id="checkbox-id{{ $recipient->recipients_cell }}" data-cell="{{ $recipient->recipients_cell }}" data-name="{{ recipientsName($recipient->recipients_cell) }}" data-address="{{ recipientsAddress($recipient->recipients_cell) }}" data-email="{{ recipientsAddress($recipient->recipients_cell) ?? '' }}">
                                <div class="color-inset">
                                    <i class="material-icons color-selected-icon">done</i>
                                </div>
                            </div>
                            <!-- /.Custom Type -->

                            <!-- Recipient's Details -->
                            <div class="media ml-2 custom-type-label" data-id="{{ $recipient->recipients_cell }}" data-name="{{ recipientsName($recipient->recipients_cell) }}" data-address="{{ recipientsAddress($recipient->recipients_cell) }}" data-email="{{ recipientsAddress($recipient->recipients_cell) ?? '' }}">
                                <img src="{{ recipientsPic($recipient->recipients_cell) }}" alt="" height="40" width="40" class="rounded-circle align-self-start mr-2">
                                <div class="media-body">
                                    <h6 class="font-600 mb-0 text-capitalize">{{ recipientsName($recipient->recipients_cell) }}</h6>
                                    <p class="text-sm my-0 text-capitalize">{{ recipientsAddress($recipient->recipients_cell) }}</p>
                                </div>
                            </div>
                            <input type="hidden" name="recipient-name" id="recipient-name" value="{{ recipientsName($recipient->recipients_cell) }}">
                            @isset($recipient->recipients_email)
                                <input type="hidden" name="recipient-email" id="recipient-email" value="{{ $recipient->recipients_email }}">
                            @endisset
                            <input type="hidden" name="recipient-cell" id="recipient-cell" value="{{ $recipient->recipients_cell }}">
                            <input type="hidden" name="recipient-address" id="recipient-address" value="{{ recipientsAddress($recipient->recipients_cell) }}">
                            <!-- /.Recipient's Details -->
                        </li>
                        <!-- /.Recipient -->
                    @endforeach
                    @if (count(recipients(Auth::user()->id)) > 4)
                        <li class="list-group-header list-group-item rounded-bottom-2">
                            <a href="#" class="font-600 text-sm d-flex align-items-center justify-content-center">
                                View All Recipient <i class="material-icons ml-1">expand_more</i>
                            </a>
                        </li>
                    @endif
                @else
                    <li class="list-group-header list-group-item rounded-bottom-2">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <i class="material-icons fa-5x text-faded">people</i>
                                <h6 class="font-600 mt-2 mb-0">No recipients found!</h6>
                                <p class="text-sm">Proceed to fill in your delivery details.</p>
                            </div>
                        </div>
                    </li>
                @endif
            </div>
            <!-- /.Send gift to a recipient -->
        </div>
        <!-- /.Recipient List -->

        <!-- Cart Items -->
        <div class="col-12 col-xl-4 order-md-3">
            <ul class="list-group box-shadow-sm rounded-2 my-2">
                <li class="list-group-item p-2 cart-menu-item d-flex justify-content-between align-items-center rounded-top-2">
                    <h6 class="font-600 my-0">
                        <span class="cart-count mr-1">0</span> giftbox items
                    </h6>
                </li>
                <div class="rounded-2" id="cart-items">
                    <!-- Shopping Cart details will be shown here -->
                    <div class="row justify-content-center my-5">
                        <div class="d-block text-center">
                            <img src="{{ asset('img/app/spinner.svg') }}" height="80" width="80" alt="" class="">
                            <h6 class="font-600 mt-2">Loading your giftbox...</h6>
                        </div>
                    </div>
                </div>
                <!-- Cart Subtotal -->
                <li class="list-group-item w-100 lh-100 font-600 text-sm rounded-bottom-2" id="cart-action-btns">
                    <!-- Cart Subtotal -->
                    <div class="usd-price">
                        <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                            <span class="text-capitalize">Subtotal Amount:</span>
                            <span class="usd-subtotal">US$0.00</span>
                        </h6>
                    </div>
                    <div class="zar-price d-none">
                        <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                            <span class="text-capitalize">Subtotal Amount:</span>
                            <span class="zar-subtotal">R0.00</span>
                        </h6>
                    </div>
                    <div class="zwl-price d-none">
                        <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                            <span class="text-capitalize">Subtotal Amount:</span>
                            <span class="zwl-subtotal">ZW$0.00</span>
                        </h6>
                    </div>
                    <!-- /.Cart Subtotal -->

                    @if (session()->has('shipping_costs'))
                        <!-- Delivery charges -->
                        <div class="usd-price">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Delivery Costs:</span>
                                <span class="usd-delivery-cost">US${{ session()->get('shipping_costs')['usd_delivery_cost'] ?? 0 }}</span>
                            </h6>
                        </div>
                        <div class="zar-price d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Delivery Costs:</span>
                                <span class="zar-delivery-cost">R{{ session()->get('shipping_costs')['zar_delivery_cost'] ?? 0 }}</span>
                            </h6>
                        </div>
                        <div class="zwl-price d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Delivery Costs:</span>
                                <span class="zwl-delivery-cost">ZW${{ session()->get('shipping_costs')['zwl_delivery_cost'] ?? 0 }}</span>
                            </h6>
                        </div>
                        <!-- /.Delivery Charges -->
                    @endif

                    @if (session()->has('coupon'))
                        <!-- Taxes & Discounts -->
                        <div class="usd-price">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Discount:</span>
                                <span class="usd-discount">US${{ session()->get('coupon')['usd_value'] }}</span>
                            </h6>
                        </div>
                        <div class="zar-price d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Discount:</span>
                                <span class="zar-discount">R{{ session()->get('coupon')['zar_value'] }}</span>
                            </h6>
                        </div>
                        <div class="zwl-price d-none">
                            <h6 class="font-500 d-flex justify-content-between align-items-center my-0 py-0">
                                <span class="text-capitalize">Discount:</span>
                                <span class="zwl-discount">ZW${{ session()->get('coupon')['zwl_value'] }}</span>
                            </h6>
                        </div>
                        <!-- /.Taxes & Discounts -->
                        <hr class="my-1">
                    @endif

                    <!-- Cart Total -->
                    <div class="usd-price">
                        <h6 class="font-600 d-flex justify-content-between align-items-center my-0 py-0">
                            <span class="text-capitalize">Cart Total:</span>
                            <span class="usd-total">US$0.00</span>
                        </h6>
                    </div>
                    <div class="zar-price d-none">
                        <h6 class="font-600 d-flex justify-content-between align-items-center my-0 py-0">
                            <span class="text-capitalize">Cart Total:</span>
                            <span class="zar-total">R0.00</span>
                        </h6>
                    </div>
                    <div class="zwl-price d-none">
                        <h6 class="font-600 d-flex justify-content-between align-items-center my-0 py-0">
                            <span class="text-capitalize">Cart Total:</span>
                            <span class="zwl-total">ZW$0.00</span>
                        </h6>
                    </div>
                    <!-- /.Cart Total -->
                </li>
                <!-- /.Cart Subtotal -->
            </ul>
            @if (userCoupons(Auth::user()->id) > 0)
                <!-- Gift coupon -->
                <form method="post" class="needs-validation bg-whitesmoke box-shadow-sm bordered rounded-2 p-3" id="coupon-form" novalidate>
                    <label for="coupon" class="mb-0 text-sm text-faded font-500">Do you have a coupon or gift card?</label>
                    <div class="input-group coupon-input">
                        <input type="text" class="form-control" name="coupon" id="coupon" placeholder="Coupon code" value="{{ session()->get('coupon')['code'] ?? '' }}" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Redeem</button>
                        </div>
                    </div>
                    <span id="coupon-error" class="invalid-feedback text-sm font-600" id="coupon-feedback">Gift coupon required!</span>
                </form>
                <!-- /.Gift coupon -->
            @endif
        </div>
        <!-- /.Cart Items -->

        <!-- Checkout form -->
        <div class="col-12 col-xl-4 order-md-2">
            <div class="bg-whitesmoke box-shadow-sm bordered rounded-2 px-2 pt-3 pb-2">
                <h6 class="font-600">Fill in your delivery information.</h6>
                <form method="post" class="needs-validation" id="checkout-form" novalidate>
                    
                    <!-- Payment method -->
                    <label for="payment-option" class="mb-0 text-sm text-faded font-500">Add payment method</label>
                    <div class="form-group icon-form-group mb-1">
                        <i class="material-icons select-icon icon text-faded">credit_card</i>
                        <select name="payment-option" id="payment-option" class="custom-control form-control font-500 text-faded text-capitalize box-shadow-sm" onchange="deliveryCharge()" required>
                            <option value="credit-card" selected>Credit/Debit Cart</option>
                            <option value="credit-card">Paypal</option>
                            <option value="credit-card">Ecocash/One Money</option>
                        </select>
                        <small class="text-danger form-error font-400 mt-0 pt-0">Customer city required!</small>
                    </div>
                    <!-- /.Payment method -->

                    <img src="{{ asset('img/app/payments.png') }}" alt="" class="img-fluid">

                    <!-- Recipient's Fullname -->
                    <div class="form-group mb-1">
                        <div class="form-group my-0 pt-0">
                            <label for="fullname" class="mb-0 text-sm text-faded font-500">Recipient's Full name</label>
                            <i class="material-icons text-faded">person</i>
                            <input type="text" name="fullname" id="fullname" class="form-control font-500 text-faded text-capitalize box-shadow-sm" placeholder="Full name" required>
                            <small class="text-danger form-error font-400 mt-0 pt-0">Full name required!</small>
                        </div>
                    </div>
                    <!-- /.Recipient's Fullname -->

                    <!-- Recipient's Email -->
                    <div class="form-group mb-1">
                        <label for="email" class="mb-0 text-sm text-faded font-500">Customer email (Optional)</label>
                        <i class="material-icons text-faded">email</i>
                        <input type="email" name="customer-email" id="customer-email" class="form-control font-500 text-faded box-shadow-sm" placeholder="email@example.com">
                        <small class="text-danger form-error font-400 mt-0 pt-0">Email required!</small>
                    </div>
                    <!-- /.Recipient's Email -->

                    <!-- /.Form Row -->
                    <div class="form-row mb-1">
                        <div class="col-12 col-lg-6">
                            <div class="form-group my-0 pt-0">
                                <label for="mobile-number" class="mb-0 text-sm text-faded font-500">Mobile Phone</label>
                                <div class="mobile-input">
                                    <img src="{{ asset('img/country-flag/flag-of-Zimbabwe.png') }}" alt="" height="15" width="25" class="zim-flag">
                                    <input type="text" name="mobile-number" id="mobile-number" class="form-control font-500 text-faded box-shadow-sm" placeholder="2637********" data-inputmask='"mask": "263999999999"' required data-mask>
                                    <small class="text-danger form-error font-400 mt-0 pt-0">Mobile phone required!</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group my-0 pt-0">
                                <label for="delivery-date" class="mb-0 text-sm text-faded font-500">Delivery Date</label>
                                <input type="text" name="delivery-date" id="delivery-date" class="form-control datepicker font-500 text-faded box-shadow-sm"required>
                                <small class="text-danger form-error font-400 mt-0 pt-0">Delivery date required!</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.Form Row -->

                    <!-- Occasion -->
                    <label for="occasion" class="mb-0 text-sm text-faded font-500">Occasion</label>
                    <div class="form-group icon-form-group mb-1">
                        <i class="material-icons select-icon icon text-faded">event</i>
                        <select name="occasion" id="occasion" class="custom-control form-control font-500 text-faded text-capitalize box-shadow-sm" required>
                            <option value="null" selected>Select Occasion</option>
                            @foreach ($occasions as $occasion)
                                <option value="{{ $occasion->occasion }}">
                                    {{ $occasion->occasion }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger form-error font-400 mt-0 pt-0">Customer city required!</small>
                    </div>
                    <!-- /.Occasion -->

                    <!-- Billing Address -->
                    <div class="form-group mb-1">
                        <label for="customer-address" class="mb-0 text-sm text-faded font-500">Customer address</label>
                        <i class="material-icons text-faded">home</i>
                        <input type="text" name="customer-address" id="customer-address" class="form-control font-500 text-faded text-capitalize box-shadow-sm" placeholder="eg. 175 bradley rd., waterfalls" required>
                        <small class="text-danger form-error font-400 mt-0 pt-0">Email required!</small>
                    </div>
                    <!-- /.Billing Address -->

                    <!-- Recipient's Suburb -->
                    <label for="customer-suburb" class="mb-0 text-sm text-faded font-500">Recipient's Suburb</label>
                    <div class="form-group icon-form-group mb-1">
                        <i class="material-icons select-icon icon text-faded">person_pin_circle</i>
                        <select name="customer-suburb" id="customer-suburb" class="custom-control form-control font-500 text-faded text-capitalize box-shadow-sm" required>
                            <option value="0" selected>Select Suburb</option>
                            @foreach ($suburbs as $row)
                                <option value="{{ number_format($row->usd_price, 2) }}" data-suburb="{{ $row->suburb_name }}">
                                    {{ $row->suburb_name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger form-error font-400 mt-0 pt-0">Customer city required!</small>
                    </div>
                    <!-- /.Recipient's Suburb -->

                    <!-- Credit/Debit Card form -->
                    <div class="form-group mb-1 debit-card">
                        <label for="credit-card" class="mb-0 text-sm text-faded font-500">Credit card</label>
                        <div id="card-element" class="form-control validate borderless-input">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div class="text-danger" id="card-errors" role="alert"></div>
                    </div>
                    <!-- /.Credit/Debit Card form -->

                    <!-- Ecocash/OneMoney -->
                    <div class="form-group mb-1 d-none ecocash">
                        <label for="ecocash-number" class="mb-0 text-sm text-faded font-500">Ecocash Number</label>
                        <div class="mobile-input">
                            <img src="{{ asset('img/country-flag/flag-of-Zimbabwe.png') }}" alt="" height="15" width="25" class="zim-flag">
                            <input type="text" name="ecocash-number" id="ecocash-number" class="form-control font-500 text-faded box-shadow-sm" placeholder="2637********" data-inputmask='"mask": "263799999999"' required data-mask>
                            <small class="text-danger form-error font-400 mt-0 pt-0">Ecocash number required!</small>
                        </div>
                    </div>
                    <!-- /.Ecocash/OneMoney -->

                    <!-- ZimSwitch -->
                    <div class="form-group mb-1 d-none zimswitch">
                        <label for="account-number" class="mb-0 text-sm text-faded font-500">Account Number</label>
                        <div class="mobile-input">
                            <img src="{{ asset('img/country-flag/flag-of-Zimbabwe.png') }}" alt="" height="15" width="25" class="zim-flag">
                            <input type="text" name="account-number" id="account-number" class="form-control font-500 text-faded box-shadow-sm" placeholder="Account number" data-inputmask='"mask": "9999999999999999"' required data-mask>
                            <small class="text-danger form-error font-400 mt-0 pt-0">Account number required!</small>
                        </div>
                    </div>
                    <!-- /.ZimSwitch -->

                    <!-- Hidden inputs -->
                    <input type="hidden" name="action" id="action" value="customer-order">
                    <input type="hidden" name="currency" id="currency">
                    <input type="hidden" name="suburb" id="suburb">
                    <!-- /.Hidden inputs -->

                    <!-- Submission button -->
                    <button type="submit" class="btn btn-primary btn-block font-600 my-2 px-3" id="checkout-btn">
                        Proceed to pay 
                        <span class="text-white usd-price usd-total">US$25.98</span>
                        <span class="text-white zar-price zar-total d-none">R428.67</span>
                        <span class="text-white zwl-price zwl-total d-none">ZW$2598</span>
                    </button>
                    <!-- /.Submission button -->
                </form>
            </div>
        </div>
        <!-- /.Checkout form -->
    </div>
    <!-- /.Checkout Details -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')