<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    // Username
    function username(){
        $name = explode(' ', strtolower(Auth::user()->name));
        $first_name = $name[0];
        $last_name = $name[1];
        $username = $first_name . '.' .$last_name;
        return $username; 
    }

    // User greeting
    function greeting(){
        $hour = date('H');
        $greeting = '';
        if($hour < 12){
           $greeting = '<span class="greeting-text">Good morning!</span>'; 
        } else if($hour < 18){
            $greeting = '<span class="greeting-text">Good afternoon!</span>';
        } else {
            $greeting = '<span class="greeting-text">Good evening!</span>';
        }
        return $greeting;
    }

    // Greeting icon
    function greetingIcon(){
        $hour = date('H');
        $icon = '';
        if($hour < 12){
            $icon = '<img src="/storage/app/sunrise.svg" class="mt-1" width="40" height="40">';
        } else if($hour < 18){
            $icon = '<img src="/storage/app/noon.svg" class="mt-1" width="40" height="40">';
        } else {
            $icon = '<img src="/storage/app/dark-night.svg" class="mt-1" width="40" height="40">';
        }
        return $icon;
    }

    // Get all 31 calendar dates
    function birthday_dates(){
        $output = '
            <div class="icon-form-group birth-date">
                <i class="material-icons text-faded icon">today</i>
                <select type="text" name="birthday-date" class="custom-control form-control font-500 birthday-date" required>
        ';
        for($i = 1; $i < 32; $i++){
            $output .= '
                <option value="'.sprintf('%02d', $i).'">'.sprintf('%02d', $i).'</option>
            ';
        }
        $output .= '
                </select>
            </div>
        ';
        return $output;
    }

    // Get all months
    function birthday_months(){
        $output = '
            <select type="text" name="birth-month" class="custom-control form-control birth-month rounded-0 font-500" required>
                <option value="january">01 | January</option>
                <option value="february">02 | February</option>
                <option value="march">03 | March</option>
                <option value="april">04 | April</option>
                <option value="may">05 | May</option>
                <option value="june">06 | June</option>
                <option value="july">07 | July</option>
                <option value="august">08 | August</option>
                <option value="september">09 | September</option>
                <option value="october">10 | October</option>
                <option value="november">11 | November</option>
                <option value="december">12 | December</option>
            </select>
        ';
        return $output;
    }

    // Get birthday years
    function birthday_years(){
        $output = '
            <select type="text" name="birth-year" class="custom-control form-control birth-year font-500" required>
        ';
        $allowed_age = date('Y') - 16;
        for($i = 1900; $i < $allowed_age; $i++){
            $output .= '
                <option value="'.$i.'">'.$i.'</option>
            ';
        }
        $output .= '
            </select>
        ';
        return $output;
    }

    // Birthday dropdown
    function birthdayPicker(){
        $output = '
            <div class="birthday-dropdown d-flex align-items-center">
                '. birthday_dates() .'
                '. birthday_months() .'
                '. birthday_years() .'
            </div>
            <span class="invalid-feedback text-sm">Birthday required!</span>
        ';
        return $output;
    }

    // Count user's orders
    function countOrders(){
        $count = DB::table('orders')
                    ->where('user_id', Auth::user()->id)
                    ->count(); 
        return $count;
    }

    // Count number of times a recipient's cell appears in the recipients table
    function recipientOrders($user_id, $recipients_cell){
        $count = DB::table('recipients')
                   ->where([
                       'user_id'         => $user_id,
                       'recipients_cell' => $recipients_cell
                   ])
                   ->count();
        return $count;
    }

    // Recipient's full name
    function recipientsName($recipients_cell){
        $name = '';
        $result = DB::table('recipients')
                    ->select('recipients_name', 'recipients_surname')
                    ->where('recipients_cell', $recipients_cell)
                    ->get();
        foreach($result as $row){
            $name = $row->recipients_name . ' ' . $row->recipients_surname;
        }
        return $name;
    }

    // Recipient's address
    function recipientsAddress($recipients_cell){
        $address = DB::table('recipients')
                    ->select('recipients_address')
                    ->where('recipients_cell', $recipients_cell)
                    ->value('recipients_address');
        return $address;
    }

    // Recipient's city
    function recipientsCity($recipients_cell){
        $city = DB::table('recipients')
                    ->select('recipients_city')
                    ->where('recipients_cell', $recipients_cell)
                    ->value('recipients_city');
        return $city;
    }

    // Recipient's status
    function recipientsStatus($recipients_cell){
        $button = $name = $friend_id = '';
        $result = DB::table('recipients')
                    ->select('friend_id', 'recipients_name', 'recipients_surname')
                    ->where('recipients_cell', $recipients_cell)
                    ->get();
        foreach($result as $row){
            $name = $row->recipients_name . '.' . $row->recipients_surname;
            $friend_id = $row->friend_id;
        }

        if (!empty($friend_id)){
            $button = '
                <a href="/recipient/'. strtolower($name) .'" class="btn btn-outline-primary btn-block btn-sm font-600 rounded-0">View Profile</a>
            ';
        } else {
            $button = '
                <a href="/invite/'. $recipients_cell .'" class="btn btn-outline-primary btn-block btn-sm font-600 rounded-0">Invite</a>
            ';
        }
        return $button;
    }

    // Recipient's Profile Picture
    function recipientsPic($recipients_cell){
        $profile_pic = '';
        $result = DB::table('recipients')
                    ->join('users', 'mobile_phone', '=', 'recipients_cell')
                    ->where('recipients_cell', $recipients_cell)
                    ->distinct()
                    ->get();
        if(count($result) > 0){
            foreach($result as $row){
                $profile_pic = '/storage/users/' . $row->profile_pic;
            }
        } else {
            $profile_pic = '/storage/users/user.png'; 
        }
        return $profile_pic;
    }

    // Recipient's Cover Image
    function recipientsCoverImg($recipients_cell){
        $cover_img = '';
        $result = DB::table('recipients')
                    ->join('users', 'mobile_phone', '=', 'recipients_cell')
                    ->where('recipients_cell', $recipients_cell)
                    ->distinct()
                    ->get();
        if(count($result) > 0){
            foreach($result as $row){
                $cover_img = '/storage/cover-page/' . $row->cover_page;
            }
        } else {
            $cover_img = '/storage/cover-page/default-coverpage.png'; 
        }
        return $cover_img;
    }

    // Gift Label 
    function giftLabel($gift_id){
        $gift_label = '';
        $result = DB::table('gifts')
                    ->select('label')
                    ->where('id', $gift_id)
                    ->get();
        foreach($result as $row){
            if($row->label == 'organic' || $row->label == 'eco-design' || 
            $row->label == 'eco-friendly'){
                $gift_label = '
                    <div class="gift-label bg-green shadow-sm">
                        <span class="material-icons text-white m-auto" title="Eco-friendly">spa</span>
                    </div>
                ';
            } else if($row->label == 'hot-offer'){
                $gift_label = '
                    <div class="gift-label bg-transparent">
                        <img src="'.asset('img/app/product-labels/hot.gif').'" alt="" height="22" width="56" class="img-fluid">
                    </div>
                ';
            } else if($row->label == 'sale'){
                $gift_label = '
                    <div class="gift-label bg-danger shadow-sm">
                        <span class="text-white m-auto font-weight-bold">SALE</span>
                    </div>
                ';
            } else if($row->label == 'customizable'){
                $gift_label = '
                    <div class="badge badge-danger rounded-0 customize-ribbon d-flex align-items-center">
                        <i class="material-icons mr-1 d-0" id="is-customized'.$gift_id.'">check</i>
                        <span id="customized'.$gift_id.'" class="text-white">Customizable</span>
                    </div>
                ';
            } else {
                $gift_label = '
                    <div class="gift-label bg-purple shadow-sm">
                        <span class="text-white m-auto font-700">NEW!</span>
                    </div>
                ';
            }
        }
        return $gift_label;
    }

    // Fetch user rating for particular product
    function customerRating($rating_id, $gift_id, $user_id){
        $stars = $star = $color = '';
        $rating = DB::table('gift_ratings')
                    ->select('customer_rating')
                    ->where([
                        'rating_id' => $rating_id,
                        'gift_id'   => $gift_id,
                        'user_id'   => $user_id
                    ])
                    ->value('customer_rating');
        $user_rating = round($rating);
        // gift star rating
        $stars = '
            <ul class="list-inline star-rating my-0 py-0">
        ';
        for($i = 1; $i <= 5; $i++){
            if($i <= $user_rating){
                $star = '&starf;';
                $color = 'text-warning';
            } else {
                $star = '&star;';
                $color = 'text-muted';
            }
            $stars .= '
                <li class="list-inline-item '.$color.'">'.$star.'</li>
            ';
        }
        $stars .= '
            </ul>
        ';
        return $stars;
    }

    // Get gift ratings and reviews
    function giftRating($gift_id){
        $gift_rating = 0;
        $result = DB::table('gift_ratings')
                          ->join('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                          ->where('gift_id', $gift_id)
                          ->get();
        $count = $result->count();
        if($count > 0){
            $gift_rating = DB::table('gift_ratings')
                              ->where('gift_id', $gift_id)
                              ->groupBy('gift_id')
                              ->avg('customer_rating');
        } else {
            $gift_rating = 0;
        }  
        return $gift_rating;
    }

    // Get the total number of ratings of a gift
    function countRatings($gift_id){
        $count = DB::table('gift_ratings')
                   ->where('gift_id', $gift_id)
                   ->count();
        return $count;
    }

    // Get gift star rating
    function giftStarRating($gift_id){
        $stars = $star = $color = $reviews = $description = '';
        // gift Rating
        $gift_rating = round(giftRating($gift_id));

        $count_ratings = countRatings($gift_id);

        if($count_ratings == 1){
            $reviews = '
                <li class="list-inline-item text-faded star-rating text-sm ml-1">(1 rating)</li>
            ';
        } else {
            $reviews = '
                <li class="list-inline-item text-faded star-rating text-sm ml-1">('.$count_ratings.' ratings)</li>
            ';
        }
        // gift star rating
        $stars = '
            <ul class="list-inline star-rating" data-toggle="tooltip" data-placement="bottom" title="Av. rating of '.$gift_rating.' out of 5">
        ';
        for($i = 1; $i <= 5; $i++){
            if($i <= $gift_rating){
                $star = '&starf;';
                $color = 'text-warning';
            } else {
                $star = '&star;';
                $color = 'text-muted';
            }
            $stars .= '
                <li class="list-inline-item '.$color.'">'.$star.'</li>
            ';
        }
        $stars .= '
                '.$reviews.'
            </ul>
        ';
        return $stars;
    }

    // Progress bar rating
    function progressBarRating($gift_id){
        // Progress Bar Ratings
        $excl_pcnt = $good_pcnt = $av_pcnt = 0;
        $poor_pcnt = $bad_pcnt = 0;
        $count_ratings = countRatings($gift_id);
        $progressBars = '';

        if($count_ratings > 0){
            $five_star = fiveStarRating($gift_id);
            $excl_pcnt = round(($five_star / $count_ratings) * 100);

            $four_star = fourStarRating($gift_id);
            $good_pcnt = round(($four_star / $count_ratings) * 100);

            $three_star = threeStarRating($gift_id);
            $av_pcnt = round(($three_star / $count_ratings) * 100);

            $two_star = twoStarRating($gift_id);
            $poor_pcnt = round(($two_star / $count_ratings) * 100);

            $one_star = twoStarRating($gift_id);
            $bad_pcnt = round(($one_star / $count_ratings) * 100);
            
            // Product Item Progress Rating
            $progressBars .= '
                <div class="d-flex align-items-center">
                    <h6 class="my-0 mr-1 p-0 text-faded">5</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="'.$excl_pcnt.'" aria-valuemax="100" style="width:'.$excl_pcnt.'%;">
                            <span class="text-muted font-400">'.$excl_pcnt.'%</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">4</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="'.$good_pcnt.'" aria-valuemax="100" style="width:'.$good_pcnt.'%;">
                            <span class="text-muted font-400">'.$good_pcnt.'%</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">3</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="'.$av_pcnt.'" aria-valuemax="100" style="width:'.$av_pcnt.'%;">
                            <span class="text-muted font-400">'.$av_pcnt.'%</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">2</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="'.$poor_pcnt.'" aria-valuemax="100" style="width:'.$poor_pcnt.'%;">
                            <span class="text-muted font-400">'.$poor_pcnt.'%</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">1</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="'.$bad_pcnt.'" aria-valuemax="100" style="width:'.$bad_pcnt.'%;">
                            <span class="text-muted font-400">'.$bad_pcnt.'%</span>
                        </div>
                    </div>
                </div>
            ';
        } else {
            $progressBars .= '
                <div class="d-flex align-items-center">
                    <h6 class="my-0 mr-1 p-0 text-faded">5</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" style="width:0%;">
                            <span class="text-muted font-400"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">4</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" style="width:0%;">
                            <span class="text-muted font-400"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">3</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" style="width:0%;">
                            <span class="text-muted font-400"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">2</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" style="width:0%;">
                            <span class="text-muted font-400"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <h6 class="my-0 mr-1 p-0 text-faded">1</h6>
                    <div class="progress progess-sm rounded-pill">
                        <div class="progress-bar bg-gold" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" style="width:0%;">
                            <span class="text-muted font-400"></span>
                        </div>
                    </div>
                </div>
            ';
        }
        return $progressBars;
    }

    // Details page gift star rating
    function dpStarRating($gift_id){
        $stars = $star = $color = $reviews = $description = '';
        // gift Rating
        $gift_rating = giftRating($gift_id);

        $count_ratings = countRatings($gift_id);

        if($count_ratings == 1){
            $reviews = '
                <p class="text-sm my-0 text-faded">'.round($gift_rating).'/5 (1 review)</p>
            ';
        } else {
            $reviews = '
                <p class="text-sm my-0 text-faded">'.round($gift_rating).'/5 ('.$count_ratings.' reviews)</p>
            ';
        }
        // gift star rating
        $stars = '
            <ul class="list-inline align-items-center ml-2 my-0 py-0 star-rating">
        ';
        for($i = 1; $i <= 5; $i++){
            if($i <= round($gift_rating)){
                $star = '&starf;';
                $color = 'text-warning';
            } else {
                $star = '&star;';
                $color = 'text-muted';
            }
            $stars .= '
                <li class="list-inline-item '.$color.'">'.$star.'</li>
            ';
        }
        $stars .= '
                '.$reviews.'
            </ul>
        ';
        return $stars;
    }

    // Get an array of the ids of all gifts wishlisted
    function wishlistedGifts(){
        $gifts = DB::table('wishlist')->pluck('gift_id');
        return $gifts;
    }

    // Get an array of the ids of all ordered gifts
    function orderedGifts(){
        $gifts = DB::table('ordered_gifts')->pluck('gift_id');
        return $gifts;
    }

    // Total number of wishes of a gift
    function totalWishes($gift_id){
        $count = DB::table('wishlist')
                ->where('gift_id', $gift_id)
                ->count();
        return $count;
    }

    // Wishlist icon
    function wishlistIcon($gift_id, $user_id){
        $count = DB::table('wishlist')
                ->where(['gift_id' => $gift_id, 'user_id' => $user_id])
                ->count();
        $wishlist_icon = '';
        if($count > 0){
            $wishlist_icon = '
                <span role="button" class="material-icons overlay-icon text-warning wishlist-icon" data-id="'.$gift_id.'" data-user="'.$user_id.'" data-action="unwish" title="This gift is in your Wishlist">favorite</span>
            ';
        } else {
            $wishlist_icon = '
                <span role="button" class="material-icons overlay-icon wishlist-icon" data-id="'.$gift_id.'" data-user="'.$user_id.'" data-action="wish" title="Add to Wishlist">favorite_border</span>
            ';
        }
        return $wishlist_icon;
    }

    // Details page Wishlist button
    function wishlistBtn($gift_id, $user_id){
        $count = DB::table('wishlist')
                ->where(['gift_id' => $gift_id, 'user_id' => $user_id])
                ->count();
        $wishlist_btn = '';
        if($count > 0){
            $wishlist_btn = '
                <button class="btn text-primary btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center details-wishlist-btn mr-1" data-id="'.$gift_id.'" data-user="'.$user_id.'" data-action="unwish">
                    <i class="material-icons mr-1">check</i>
                    <span class="text-primary">Wishlisted</span>
                </button> 
            ';
        } else {
            $wishlist_btn = '
                <button class="btn text-primary btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center details-wishlist-btn mr-1" data-id="'.$gift_id.'" data-user="'.$user_id.'" data-action="wish">
                    <i class="material-icons mr-1">favorite_border</i>
                    <span class="text-primary">Wishlist</span>
                </button> 
            ';
        }
        return $wishlist_btn;
    }

    // Show gift's supporting (preview) images
    function previewImages($gift_image){
        $files = Storage::files('/storage/gifts');
        $output = '<div id="gallery">';
        if($files){
            foreach($files as $file){
                // Select all gift images based on the filename
                $img_props = explode('.', $file);
                $viewed_gift = explode('.', $gift_image); 
                $filename = $img_props[0];
                if('.' != $file && '..' != $file && $filename == $viewed_gift[0]){
                    $output .= '
                        <a class="active" href="#" data-image="/storage/gifts/'. $gift_image .'" data-zoom-image="/storage/gifts/'. $gift_image .'">
                            <img src="/storage/gifts/'. $gift_image .'" />
                        </a>
                    ';
                }
            }
        }
        $output .= '</div>';
        return $output;
    }

    // Count all gifts in the same category
    function categoriesGifts($category_id){
        $count = DB::table('gifts')
                   ->select('category_id')
                   ->where('category_id', $category_id)
                   ->count();
        return $count;
    }

    // Get the highest rated gift in the category
    function maxRatedInCategory($category_id){
        $max = DB::table('gift_ratings')
                 ->join('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                 ->join('categories', 'categories.id', '=', 'gifts.category_id')
                 ->select('customer_rating')
                 ->where('gifts.category_id', $category_id)
                 ->max('customer_rating');
        return $max;
    }

    // Get the lowest priced gift in the category
    function minPricedInCategory($category_id){
        $max = DB::table('gifts')
                 ->join('categories', 'categories.id', '=', 'gifts.category_id')
                 ->select('usd_price')
                 ->where('gifts.category_id', $category_id)
                 ->min('usd_price');
        return $max;
    }

    // Count category gifts sold
    function soldCategoryGifts($category_id){
        $count = DB::table('ordered_gifts')
                    ->join('gifts', 'gifts.id', '=', 'ordered_gifts.gift_id')
                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                    ->select('quantity')
                    ->where('categories.id', $category_id)
                    ->count();
        return $count;
    }

    // Get gift's category
    function categoryName($gift_id){
        $category_name = DB::table('gifts')
                           ->join('categories', 'categories.id', '=', 'gifts.category_id')
                           ->where('gifts.id', $gift_id)
                           ->value('category_name');
        return $category_name;
    }

    // Get gift's category
    function categoryId($gift_id){
        $category_id = DB::table('gifts')
                           ->where('id', $gift_id)
                           ->value('category_id');
        return $category_id;
    }

    // Related gifts
    function relatedGifts($gift_id, $category_id){
        $output = '';
        $relatives = DB::table('gifts')
                        ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->select('gifts.*', 'categories.*', 'sub_categories.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug')
                        ->where([
                            ['gifts.id', '!=', $gift_id],
                            ['gifts.category_id', '=', $category_id]
                        ])
                        ->orderBy('usd_price', 'asc')
                        ->get();
        if(count($relatives) > 0){
            $output .= '
                <h4 class="display-5 font-600 mt-2">You may also like</h4>
                <div class="owl-carousel owl-theme target-gifts">
            ';
            foreach($relatives as $gift){
                // Gift star rating
                $star_rating = giftStarRating($gift->gift_id);

                $output .= '
                    <!-- Related Gift -->
                    <div class="item w-100">
                        <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                            <a href="'. route('details.show', [$gift->gift_slug, $gift->gift_id]) .'">
                                <img src="/storage/gifts/'.$gift->gift_image.'" height="150" class="card-img-top w-100 rounded-0">
                            </a>
                            <div class="gift-content mx-1">
                                <a href="'. route('details.show', [$gift->gift_slug, $gift->gift_id]) .'">
                                    <h6 class="my-0 py-0 text-capitalize font-600 text-primary">'.mb_strimwidth($gift->gift_name, 0, 17, '...').'</h6>
                                </a>
                                <div class="d-inline-block lh-100">
                                    <h6 class="my-0 py-0 text-sm text-capitalize">'.$gift->category_name.'</h6>
                                    <div class="d-flex align-items-center justify-content-around">
                                        '.$star_rating.'
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <h6 class="usd-price text-grey text-sm font-600 mt-2">US$'.number_format($gift->usd_price, 2).'</h6>
                                    <h6 class="zar-price d-none text-grey text-sm font-600 mt-2">R'.number_format($gift->zar_price, 2).'</h6>
                                    <h6 class="zwl-price d-none text-grey text-sm font-600 mt-2">ZW$'.number_format($gift->zwl_price, 2).'</h6>
                                    <span role="button" class="material-icons fa-2x text-success">add_circle_outline</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.Related Gift -->
                ';
            }
            $output .= '
                </div>
            ';
        }
        return $output;
    }

    // Total of Gift Item sold
    function giftsSold($gift_id){
        $count = DB::table('ordered_gifts')
                   ->where('gift_id', $gift_id)
                   ->sum('quantity');
        return $count;
    }

    // Determine percentage of customers who bought category gifts 
    // below $25.00 price range
    function lowestPriceRange(){
        $total_customers = DB::table('orders')->count();
        $range_customers = DB::table('orders')
                              ->where('usd_total', '<', 25)
                              ->count();
        $percentage = round(($range_customers / $total_customers) * 100);
        return $percentage;
    }

    // Determine percentage of customers who bought category gifts 
    // within $25.00-$50.00 price range
    function lowerPriceRange(){
        $total_customers = DB::table('orders')->count();
        $range_customers = DB::table('orders')
                              ->whereBetween('usd_total', [25, 50])
                              ->count();
        $percentage = round(($range_customers / $total_customers) * 100);
        return $percentage;
    }

    // Determine percentage of customers who bought category gifts 
    // within $50.00-$75.00 price range
    function mediumPriceRange(){
        $total_customers = DB::table('orders')->count();
        $range_customers = DB::table('orders')
                              ->whereBetween('usd_total', [50, 75])
                              ->count();
        $percentage = round(($range_customers / $total_customers) * 100);
        return $percentage;
    }

    // Determine percentage of customers who bought category gifts 
    // within $75.00-$100.00 price range
    function highPriceRange(){
        $total_customers = DB::table('orders')->count();
        $range_customers = DB::table('orders')
                              ->whereBetween('usd_total', [75, 100])
                              ->count();
        $percentage = round(($range_customers / $total_customers) * 100);
        return $percentage;
    }

    // Determine percentage of customers who bought category gifts 
    //abbove the $100.00 price range
    function highestPriceRange(){
        $total_customers = DB::table('orders')->count();
        $range_customers = DB::table('orders')
                              ->where('usd_total', '>', 100)
                              ->count();
        $percentage = round(($range_customers / $total_customers) * 100);
        return $percentage;
    }

    // Determine if gift in question is in user's ordered gift list
    function verifiedPurchase($gift_id, $user_id){
        $purchase_label = '';
        $orders = DB::table('orders')
                   ->join('users', 'users.id', '=', 'orders.user_id')
                   ->join('ordered_gifts', 'ordered_gifts.order_id', '=', 'orders.id')
                   ->where([
                        'orders.user_id' => $user_id,
                        'gift_id' => $gift_id
                   ])
                   ->get();
        $count = $orders->count();
        if($count > 0){
            $purchase_label = '
                <div class="d-flex align-items-center font-500 text-capitalize text-sm text-faded">
                    <i class="material-icons text-success">verified_user</i> verified purchase
                </div>
            ';
        }
        return $purchase_label;
    }

    // Count of people who found review post helpful
    function reviewLikes($rating_id, $gift_id){
        $output = '';
        $count = DB::table('helpful')
                   ->where([
                       'rating_id' => $rating_id,
                       'gift_id' => $gift_id
                   ])
                   ->count();
        if($count == 1){
                $output = '
                    <span id="helpful-count">1</span> person found this helpful
                ';
            } else {
                $output = '
                    <span id="helpful-count">'.$count.'</span> people found this helpful
                ';
            }
        return $output;
    }

    // Count review post's comments
    function countReviewComments($rating_id){
        $count = DB::table('review_comments')
                   ->where('rating_id', $rating_id)
                   ->count();
        return $count;
    }

    // Helpful button
    function helpful_btn($rating_id, $gift_id, $user_id){
        $output = '';
        $count = DB::table('helpful')
                   ->where([
                        'rating_id' => $rating_id,
                        'gift_id' => $gift_id,
                        'user_id' => $user_id
                   ])
                   ->count();
        if($count > 0){
            $output = '
                <div class="d-flex d-cursor align-items-center text-sm text-faded review-action helpful-btn" data-post="'.$rating_id.'" data-id="'.$gift_id.'" data-action="unhelpful">
                    <i class="tiny material-icons text-success mr-1">thumb_up</i>
                    <span class="d-none d-md-inline">helpful</span>
                </div>
            ';
        } else {
            $output = '
                <div class="d-flex d-cursor align-items-center text-sm text-faded review-action helpful-btn" data-post="'.$rating_id.'" data-id="'.$gift_id.'" data-action="helpful">
                    <i class="tiny material-icons mr-1">thumb_up</i>
                    <span class="d-none d-md-inline">helpful</span>
                </div>
            ';
        }
        return $output;
    }

    // Unhelpful button
    function unhelpful_btn($rating_id, $gift_id, $user_id){
        $output = '';
        $count = DB::table('unhelpful')
                   ->where([
                        'rating_id' => $rating_id,
                        'gift_id' => $gift_id,
                        'user_id' => $user_id
                   ])
                   ->count();
        if($count > 0){
            $output = '
                <div class="d-flex d-cursor align-items-center text-sm text-faded review-action unhelpful-btn" data-post="'.$rating_id.'" data-id="'.$gift_id.'" data-action="like">
                    <i class="tiny material-icons text-danger mr-1">thumb_down</i>
                    <span class="d-none d-md-inline">unhelpful</span>
                </div>
            ';
        } else {
            $output = '
                <div class="d-flex d-cursor align-items-center text-sm text-faded review-action unhelpful-btn" data-post="'.$rating_id.'" data-id="'.$gift_id.'" data-action="unlike">
                    <i class="tiny material-icons mr-1">thumb_down</i>
                    <span class="d-none d-md-inline">unhelpful</span>
                </div>
            ';
        }
        return $output;
    }

    // Customer app reviews
    function appReviews(){
        $output = $color = $star = $stars = $city = '';
        $app_reviews = DB::table('app_ratings')
                     ->join('users', 'users.id', '=', 'app_ratings.user_id')
                     ->orderBy('app_ratings.created_at', 'desc')
                     ->distinct()
                     ->get();
        $count = $app_reviews->count();
        if($count > 0){
            foreach($app_reviews as $review){
                $rating = round($review->performance_rating/2);
                if($review->city !== ''){
                    $city = '
                        <p class="my-0 py-0 d-flex align-items-center">
                            <i class="material-icons mr-1 text-muted">location_on</i>
                            <span class="text-capitalize text-muted text-sm">'.$review->city.'</span>
                        </p>
                    ';
                }
                $city = $review->city;
                // Stars list
                $stars = '
                    <ul class="list-inline align-items-center star-rating mb-0 pb-0">
                ';
                for($i = 1; $i <= 5; $i++){
                    if($i <= $rating){
                        $star = '&starf;';
                        $color = 'text-warning';
                    } else {
                        $star = '&star;';
                        $color = 'text-muted';
                    }
                    if($i == 1){
                        $description = 'Very Poor Perfomance';
                    } else if($i == 2){
                        $description = 'Poor Perfomance';
                    } else if($i == 3){
                        $description = 'Fair Perfomance';
                    } else if($i == 4){
                        $description = 'Good Perfomance';
                    } else {
                        $description = 'Awesome Perfomance';
                    }
                    $stars .= '
                        <li class="list-inline-item star-rating '.$color.'" title="'.$description.'" data-index="'.$i.'" class="rating-summary">'.$star.'</li>
                    ';
                }
                $stars .= '</ul>';
                $output .= '
                    <!-- App Review -->
                    <div class="item w-100 my-1">
                        <div class="app-rating-card bg-whitesmoke border-0 rounded-0 box-shadow-sm p-2">
                            <div class="media">
                                <img src="/storage/users/'.$review->profile_pic.'" alt="'.$review->name.'" height="50" width="50" class="align-self-start rounded-circle mr-2">
                                <div class="media-body">
                                    <h6 class="text-primary py-0 my-0 text-capitalize">'.$review->name.'</h6>
                                    <div class="d-block lh-100">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            '.$stars.'
                                            <span class="text-faded text-sm">'.timestamp($review->created_at).'</span>
                                        </div>
                                        '.$city.'
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-justify">'.$review->comment.'</p>
                        </div>
                    </div>
                    <!-- /.App Review -->
                ';
            }
        }
        return $output;
    }

    // Get total number of products bought by customer
    function totalBought($user_id){
        $total_products = DB::table('orders')
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->select('ordered_items')
                    ->where('orders.user_id', $user_id)
                    ->sum('ordered_items');
        return $total_products;
    }

    // Get total amount spent on the site by the user 
    function totalSpent($user_id){
        $total_spent = DB::table('orders')
                   ->select('usd_total')
                   ->where('user_id', $user_id)
                   ->sum('usd_total');
        return number_format($total_spent, 2);
    }

    /*** Progress-bar star ratings ***/ 
    // Five Star Rating
    function fiveStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating')
                    ->where([
                        'gift_id' => $gift_id
                    ])
                    ->whereBetween('customer_rating', [4.5, 5])
                    ->count();
        return $count;
    }

    // Four Star Rating
    function fourStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating')
                    ->where([
                        'gift_id' => $gift_id
                    ])
                    ->whereBetween('customer_rating', [3.5, 4.4])
                    ->count();
        return $count;
    }

    // Three Star Rating
    function threeStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating')
                    ->where([
                        'gift_id' => $gift_id
                    ])
                    ->whereBetween('customer_rating', [2.5, 3.4])
                    ->count();
        return $count;
    }

    // Two Star Rating
    function twoStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating')
                    ->where([
                        'gift_id' => $gift_id
                    ])
                    ->whereBetween('customer_rating', [1.5, 2.4])
                    ->count();
        return $count;
    }

    // One Star Rating
    function oneStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating')
                    ->where([
                        'gift_id' => $gift_id
                    ])
                    ->whereBetween('customer_rating', [0, 1.4])
                    ->count();
        return $count;
    }

    /*** End of Progress Bar Functions ***/

     // Timeago Function
     function timestamp($time){
        $saved_time = strtotime($time);
        $date_diff = date('d') - date('d', $saved_time);

        if ($date_diff == 0) {
            return 'Today, ' . date('H:s', $saved_time);
        } else if ($date_diff == 1) {
            return 'Yesterday, ' .date('H:s', $saved_time);
        } else {
            return date('F d, Y', $saved_time);
        }
        return $time;
    }

    // Notification Timeago Function
    function timeago($time){
        //$time is data to be calculated to give the time spent
        $timeago = strtotime($time);
        $current_time = time();
        $time_difference = $current_time - $timeago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);
        $hours   = round($seconds / 3600);
        $days    = round($seconds / 86400);
        $weeks   = round($seconds / 604800);
        $months  = round($seconds / 2629800); //((365 + 365 + 365 + 366)/4/12) * 24 * 3600
        $years   = round($seconds / 31557600); //$months * 12

        if ($seconds < 60) {
            return 'Just now';
        } else if ($minutes < 60) {
            if ($minutes == 1) {
                return '1m ago';
            } else {
                return $minutes."m ago";
            }
        } else if ($hours < 24) {
            if ($hours == 1) {
                return '1h ago';
            } else {
                return $hours."h ago";
            }
        } else if ($days < 7) {
            if ($days == 1) {
                return '1d ago';
            } else {
                return $days."d ago";
            }
        } else if ($weeks < 4) {
            if ($weeks == 1) {
                return '1w ago';
            } else {
                return $weeks."w ago";
            }
        } else if ($months < 12) {
            if ($months == 1) {
                return '1mn ago';
            } else {
                return $months."mn ago";
            }
        } else if ($years == 1) {
            return '1y ago';
        } else {
            return $years."y ago";
        }
        return $time;
    } 
?>