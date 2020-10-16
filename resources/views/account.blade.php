@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">{{ Auth::user()->name }}</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item d-none d-md-inline">
                        <a href="index.php" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                        </a>
                    </li>
                    <li class="breadcrumb-item text-capitalize d-none d-md-inline">{{ Auth::user()->user_type }}</a></li>
                    <li class="breadcrumb-item active">Account</a></li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5">
        <div class="row main-section">
            <!-- User Details -->
            <div class="col-12 col-md-4 col-lg-5 col-xl-3">
                <!-- User Profile Card -->
                <div class="main-card" id="user-details">
                    <!-- user account details will be show here -->
                    <div class="card delivery-pad box-shadow-sm rounded-0">
                        <div class="box-shadow-lg img-frame">
                            <div class="placeholder-avatar"></div>
                        </div>
                        <div class="placeholder-cover-page"></div>
                        <div class="card-body py-0 text-center">
                            <div class="content-placeholder username-placeholder"></div>
                            <div class="content-placeholder business-placeholder"></div>
                            <div class="content-placeholder address-placeholder"></div>
                            <div class="content-placeholder motto-placeholder"></div>
                        </div>
                    </div>
                    <div class="card box-shadow-sm rounded-0">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-around">
                                <div class="d-block text-center mt-1">
                                    <div class="content-placeholder stats-placeholder"></div>
                                    <div class="content-placeholder label-placeholder"></div>
                                </div>
                                <div class="border-right"></div>
                                <div class="d-block text-center mt-1">
                                    <div class="content-placeholder stats-placeholder"></div>
                                    <div class="content-placeholder label-placeholder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.User Profile Card -->
                <div class="container">
                    <div class="row justify-content-center mt-1" id="recipient-btn">
                        <!-- Recipient btn will be shown here -->
                    </div>
                </div>
                <!-- Business Map Location -->
                <div id="map" class="customer-geolocation"></div>
                <!-- /.Business Map Location -->
            </div>
            <!-- /.User Details -->

            <!-- Account Settings -->
            <div class="col-12 col-md-8 col-lg-7 col-xl-8 pl-md-0">
                <nav class="rounded-0 bg-whitesmoke box-shadow-sm agents-info">
                    <div class="nav nav-tabs px-0 w-100" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link rounded-0 active" id="nav-activity-tab" data-toggle="tab" href="#nav-activity" role="tab" aria-controls="nav-home" aria-selected="true">
                            <div class="d-flex align-items-center font-500">
                                <i class="material-icons">forum</i>
                                <span class="text-capitalize ml-1 d-none d-md-inline">My Reviews</span>
                            </div>
                        </a>
                        @if(Auth::user()->user_type == 'admin')
                        <a class="nav-item nav-link rounded-0" id="nav-posts-tab" data-toggle="tab" href="#nav-posts" role="tab" aria-controls="nav-home" aria-selected="false">
                            <div class="d-flex align-items-center font-500">
                                <i class="material-icons">comment</i>
                                <span class="text-capitalize ml-1 d-none d-md-inline">Blog Posts</span>
                            </div>
                        </a>
                        @endif
                        <a class="nav-item nav-link rounded-0" id="nav-settings-tab" data-toggle="tab" href="#nav-settings" role="tab" aria-controls="nav-home" aria-selected="false">
                            <div class="d-flex align-items-center font-500">
                                <i class="material-icons">person_outline</i>
                                <span class="text-capitalize ml-1 d-none d-md-inline">My Account</span>
                            </div>
                        </a>
                        <a class="nav-item nav-link rounded-0" id="nav-recipients-tab" data-toggle="tab" href="#nav-recipients" role="tab" aria-controls="nav-home" aria-selected="false">
                            <div class="d-flex align-items-center font-500">
                                <i class="material-icons">people</i>
                                <span class="text-capitalize ml-1 d-none d-md-inline">My Recipients</span>
                            </div>
                        </a>
                    </div>
                </nav>
                <div class="tab-content bg-whitesmoke box-shadow-sm rounded-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-activity" role="tabpanel" aria-labelledby="nav-activity-tab">
                        <div class="content p-3">
                            <div class="d-flex justify-content-between align-items-center title py-1">
                                <h6 class="font-600 text-uppercase">My Activity</h6>
                            </div>
                            <!-- My Activity -->
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-xl-7 product-reviews" id="user-activity">
                                        <!-- All my review posts and comments will show up here -->
                                    </div>
                                </div>
                            </div>
                            <!-- My Activity -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-posts" role="tabpanel" aria-labelledby="nav-posts-tab">
                        <div class="content p-3">
                            <div class="d-flex justify-content-between align-items-center title py-1">
                                <h6 class="font-600 text-uppercase">
                                    <span class="mr-1">{{ count($posts)}}</span> Blog Posts  
                                </h6>
                            </div>
                            <!-- Blog Posts -->
                            <div class="container">
                                <div class="row">
                                    <div class="col-12" id="blog-posts">
                                        @if(count($posts) > 0)
                                            <!-- All my blog posts and comments will show up here -->
                                            @foreach($posts as $post)
                                                <div class="blog-post item">
                                                    <div class="blog-post-overlay d-grid">
                                                        <div class="content m-auto">
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-block">
                                                                    <h4 class="font-600">
                                                                        {{ $post->title}}
                                                                    </h4>
                                                                    <h6 class="my-0 py-0 text-white">
                                                                        Updated on {{ date('d F, Y', strtotime($post->updated_at)) }} at {{ date('H:ia', strtotime($post->updated_at)) }}
                                                                    </h6>
                                                                </div>
                                                                <a class="ml-3" href="/blog_posts/{{ $post->id }}/edit">
                                                                    <span role="button" class="material-icons fa-2x text-white">edit</span>
                                                                </a>
                                                                {!! Form::open(['action' => ['App\Http\Controllers\BlogPostController@destroy', $post->id], 'method' => 'POST', 'class' => 'ml-auto']) !!}
                                                                {{ Form::hidden('_method', 'DELETE') }}
                                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                                                                {!!Form::close()!!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <img src="/storage/blog_posts/{{ $post->cover_image }}" alt="" class="w-100 blog-image">
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="media">
                                                        <img src="/storage/users/{{ $post->user->profile_pic }}" alt="{{ $post->user->name }}" height="35" width="35" class="rounded-circle align-self-center mr-2">
                                                        <div class="media-body mt-2">
                                                            <h6 class="font-600 text-primary my-0 py-0 text-capitalize">{{ $post->user->name }}</h6>
                                                            <ul class="list-inline lh-100">
                                                                <li class="list-inline-item text-warning">&starf;</li>
                                                                <li class="list-inline-item text-warning star-rating">&starf;</li>
                                                                <li class="list-inline-item text-warning star-rating">&starf;</li>
                                                                <li class="list-inline-item text-warning star-rating">&starf;</li>
                                                                <li class="list-inline-item text-faded star-rating">&star;</li>
                                                                <li class="list-inline-item text-faded star-rating text-sm font-600">(125)</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="d-block text-center border-left px-2">
                                                        <h5 class="font-600 my-0 py-0 lead">15m</h5>
                                                        <h6 class="text-sm my-0 py-0">Read</h6>
                                                    </div>
                                                </div>
                                                <p class="text-justify blog-post-content">{!!$post->body!!}</p>
                                                <div class="d-flex align-items-center justify-content-around border-top border-bottom py-2 w-100">
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons mr-1">favorite_border</i>
                                                        <span>Love</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons mr-1">bookmark</i>
                                                        <span>Bookmark</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons mr-1">forum</i>
                                                        <span>Comment</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons mr-1">share</i>
                                                        <span>Share</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row justify-content-center my-5">
                                                <div class="col-10 col-md-12 text-center no-content">
                                                    <h5 class="font-600">There are no posts to show at the moment.</h5>
                                                    <p class="text-sm">
                                                        Write content about any occasion that you feel people should be educated on. Let people know what you know and see the world through your eyes.
                                                    </p>
                                                    <a href="/blog_posts/create" class="btn btn-primary btn-sm px-3">Create Post</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Blog Posts -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                        <div class="account-settings p-3">
                            <!-- Profile Settings -->
                            <div class="d-flex justify-content-between align-items-center title py-1">
                                <h6 class="font-600 text-uppercase">Account Settings</h6>
                            </div>
                            <div class="row">
                                <div class="col-12 col-xl-7">
                                    <!-- Personal Details -->
                                    <div class="box-shadow-sm rounded-0 p-2 mt-2">
                                        <h6 class="font-600 mt-1">Personal Details</h6>
                                        <form method="post" class="needs-validation" id="user-info" novalidate>
                                            <div class="form-group mb-1">
                                                <label for="full-name" class="mb-0 text-sm font-600 text-faded">Full name</label>
                                                <input type="text" name="full-name" id="full-name" class="form-control font-500 text-capitalize" value="{{ Auth::user()->name }}" required>
                                                <span class="invalid-feedback text-sm">Full name required!</span>
                                            </div>
                                            <div class="form-group mb-1">
                                                <label for="email" class="mb-0 text-sm font-600 text-faded">Email</label>
                                                <input type="email" name="email" id="email" class="form-control font-500" value="{{ Auth::user()->email }}" onblur="emailValidation(this)" required>
                                                <span class="invalid-feedback text-sm">Email is invalid!</span>
                                            </div>
                                            <div class="form-group subscription-fg">
                                                <label class="text-sm font-600 mb-0 text-faded" for="mobile-number">Mobile No.</label>
                                                <div class="row no-gutters align-items-center w-100">
                                                    <div class="phone-code col-4 col-md-3">
                                                        <img src="dist/img/country-flag/flag-of-Zimbabwe.png" alt="" height="15" width="25" class="country-flag">
                                                        <input type="text" name="country-code" id="country-code" class="form-control subscription-input text-primary country-code" disabled>
                                                    </div>
                                                    <div class="phone-number col-8 col-md-9">
                                                        <input type="text" class="form-control mobile-number" id="mobile-number" name="mobile-number" placeholder="Mobile Number" data-inputmask='"mask": "999999999"' required data-mask>
                                                    </div>
                                                </div>
                                                <span class="invalid-feedback">9 digit mobile no. required</span>
                                            </div>
                                            <div class="form-group mb-1">
                                                <label for="address" class="mb-0 text-sm font-600 text-faded">Address</label>
                                                <input type="text" name="address" id="address" class="form-control text-capitalize font-500" required>
                                                <span class="invalid-feedback text-sm">Address required!</span>
                                            </div>
                                            <div class="form-group mb-1">
                                                <label for="city" class="mb-0 text-sm font-600 text-faded">City</label>
                                                <input type="text" name="city" id="city" class="form-control text-capitalize font-500" required>
                                                <span class="invalid-feedback text-sm">Address required!</span>
                                            </div>
                                            <div class="form-group mb-1">
                                                <label for="birthday" class="mb-0 text-sm font-600 text-faded">Birthday</label>
                                                {{-- Birthday Picker here --}}
                                                <span class="invalid-feedback text-sm">Birthday required!</span>
                                            </div>
                                            <div class="form-group mt-2">
                                                <button type="submit" class="btn btn-primary btn-block font-600">Update Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.Personal Details -->

                                    <!-- /.Account Password -->
                                    <div class="box-shadow-sm rounded-0 p-2 mt-2">
                                        <h6 class="font-600 mt-1">Account Security</h6>
                                        <form method="post" id="change-password" class="needs-validation" novalidate>
                                            <div class="form-group mb-0">
                                                <label for="password" class="mb-0 text-muted text-sm font-600">Current Password</label>
                                                <input type="password" class="form-control font-500" name="password" id="password" placeholder="Current Password" onblur="checkPassword(this)" required>
                                                <span class="invalid-feedback" id="password-error">Password required!</span>
                                            </div>
                                            <div class="new-credentials">
                                                <div class="form-group mb-0">
                                                    <label for="new-password" class="mb-0 text-muted text-sm font-600">New Password</label>
                                                    <input type="password" class="form-control font-500" name="new-password" id="new-password" placeholder="Enter New Password" required>
                                                    <span class="invalid-feedback" id="new-password-error">New Password required!</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm-password" class="mb-0 text-muted text-sm font-600">Confirm Password</label>
                                                    <input type="password" class="form-control font-500" name="confirm-password" id="confirm-password" placeholder="Confirm New Password" required>
                                                    <span class="invalid-feedback" id="confirm-error">Password confirmation required!</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-block font-600 my-2" id="change-password-btn">
                                                Change Password
                                            </button>
                                        </form>
                                    </div>
                                    <!-- /.Account Password -->
                                </div>
                                <div class="col-12 col-xl-5">
                                    <div class="box-shadow-sm rounded-0 p-2">
                                        <form method="post" id="profile-picture" class="needs-validation" novalidate>
                                            <div class="row justify-content-around w-100">
                                                <div class="col-12 mt-1">
                                                    <div class="form-group mb-0">
                                                        <label for="profile-pic" class="mb-0 text-faded font-600">Profile Picture</label>
                                                        <div class="text-center">
                                                            <label class="mb-0 d-cursor" for="profile-pic">
                                                                <input class="d-none" type="file" name="profile-pic" id="profile-pic" onchange="displayImg(this)" accept="image/*">
                                                                <img src="/storage/users/{{ Auth::user()->profile_pic }}" id="profile-image" height="100" width="100" alt="" class="align-self-center prof-pic mr-2 bg-inverse p-1 rounded-circle"  onclick="triggerClick()">
                                                                <span class="fa fa-camera circled-icon"></span>
                                                            </label>
                                                        </div>
                                                        <div class="block mb-0">
                                                            <p class="text-sm text-faded text-justify">We recommend an image of at least 512x512 for your profile picture and shold be a jpg, jpeg, gif or png.</p>
                                                            <p class="text-sm text-faded text-justify mb-0 pb-0">Click the image thumbnail on top to change the display picture.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="box-shadow-sm rounded-0 mt-1 p-2">
                                        <h6 class="font-600 mt-1">Preference Settings</h6>
                                        <form method="post" id="settings" class="needs-validation" novalidate>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="form-check toggle-switch">
                                                    <input type="checkbox" class="form-check-input switch-btn theme-switch" id="dark-mode" onchange="themeMode(this);">
                                                    <label class="form-check-label" for="dark-mode">Dark mode</label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="form-check toggle-switch">
                                                    <input type="checkbox" class="form-check-input switch-btn" id="newsletter" onchange="subscribe(this);">
                                                    <label class="form-check-label" for="newsletter">Newsletter</label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="form-check toggle-switch">
                                                    <input type="checkbox" class="form-check-input switch-btn usd-currency" id="usd-currency" onchange="usdCurrency(this);" checked>
                                                    <label class="form-check-label" for="usd">USD</label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="form-check toggle-switch">
                                                    <input type="checkbox" class="form-check-input switch-btn zar-currency" id="zar-currency" onchange="zarCurrency(this);">
                                                    <label class="form-check-label" for="zar-currency">ZAR</label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="form-check toggle-switch">
                                                    <input type="checkbox" class="form-check-input switch-btn zwl-currency" id="zwl-currency" onchange="zwlCurrency(this);">
                                                    <label class="form-check-label" for="zwl-currency">ZWL</label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-recipients" role="tabpanel" aria-labelledby="nav-recipients-tab">
                        <div class="content p-3">
                            <div class="d-flex justify-content-between align-items-center title py-1">
                                <h6 class="font-600 text-uppercase">your recipient list</h6>
                            </div>
                            <!-- My Recipients -->
                            <div id="order-recipients">
                                <!-- All recipients will show up here -->
                            </div>
                            <!-- My Recipients -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')
