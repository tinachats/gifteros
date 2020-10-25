<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

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
                        'id' => $rating_id,
                        'gift_id' => $gift_id,
                        'user_id' => $user_id
                    ])
                    ->value('customer_rating');
        $user_rating = round($rating);
        // gift star rating
        $stars = '
            <ul class="list-inline star-rating">
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
        $gift_rating = DB::table('gift_ratings')
                   ->where('gift_id', $gift_id)
                   ->groupBy('gift_id')
                   ->avg('customer_rating');
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
                <p class="text-sm my-0 text-faded">1/5 (1 review)</p>
            ';
        } else {
            $reviews = '
                <p class="text-sm my-0 text-faded">'.number_format($gift_rating, 1).'/5 ('.$count_ratings.' reviews)</p>
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
                <span role="button" class="material-icons overlay-icon wishlist-icon" data-id="'.$gift_id.'" data-user="'.$user_id.'" data-action="unwish" title="Add to Wishlist">favorite_border</span>
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
        $files = scandir('/storage/gifts/');
        $output = '<div id="gallery">';
        if($files){
            foreach($files as $file){
                // Select all gift images based on the filename
                $img_props = explode('.', $file);
                $viewed_gift = explode('.', $gift_image); 
                $filename = $img_props[0];
                if('.' != $file && '..' != $file && $filename == $viewed_gift[0]){
                    $output .= '
                        <a class="active" href="#" data-image="/storage/gifts/'.$file.'" data-zoom-image="/storage/gifts/'.$file.'">
                            <img src="/storage/gifts/'.$file.'" />
                        </a>
                    ';
                }
            }
        }
        $output .= '</div>';
        return $output;
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
                        ->where([
                            ['gifts.id', '!=', $gift_id],
                            ['gifts.category_id', '=', $category_id]
                        ])
                        ->orderBy('usd_price', 'asc')
                        ->get();
        if(count($relatives) > 0){
            $output .= '
                <h4 class="display-5 font-600 mt-2">Related Gifts</h4>
                <div class="owl-carousel owl-theme target-gifts">
            ';
            foreach($relatives as $gift){
                // Gift star rating
                $star_rating = giftStarRating($gift_id);

                $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);

                $output .= '
                    <!-- Related Gift -->
                    <div class="item w-100">
                        <a href="'.route('details.show', [$gift->slug, $gift->id]).'" class="stretched-link">
                            <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                <img src="/storage/gifts/'.$gift->gift_image.'" height="150" class="card-img-top w-100 rounded-0">
                                <div class="gift-content mx-1">
                                    <h6 class="my-0 py-0 text-capitalize font-600 text-primary">'.mb_strimwidth($gift->gift_name, 0, 17, '...').'</h6>
                                    <div class="d-inline-block lh-100">
                                        <h6 class="my-0 py-0 text-sm text-capitalize">'.$gift->category_name.'</h6>
                                        <div class="d-flex align-items-center justify-content-around">
                                            '.$star_rating.'
                                        </div>
                                    </div>
                                    <div class="usd-price">
                                        <div class="d-flex align-items-center">
                                            <h6 class="text-brick-red font-600">US$'.number_format($gift->usd_price, 2).'</h6>
                                            <h6 class="text-muted strikethrough font-600 ml-3">US$'.$usd_before.'</h6>
                                        </div>
                                    </div>
                                    <div class="zar-price d-none">
                                        <div class="d-flex align-items-center">
                                            <h6 class="text-brick-red font-600">R'.number_format($gift->zar_price, 2).'</h6>
                                            <h6 class="text-muted strikethrough font-600 ml-3">R'.$zar_before.'</h6>
                                        </div>
                                    </div>
                                    <div class="zwl-price d-none">
                                        <div class="d-flex align-items-center">
                                            <h6 class="text-brick-red font-600">ZW$'.number_format($gift->zwl_price, 2).'</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
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
        $count = DB::table('review_helpful')
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
        $count = DB::table('gift_comments')
                   ->where('rating_id', $rating_id)
                   ->count();
        return $count;
    }

    // Helpful button
    function helpful_btn($rating_id, $gift_id, $user_id){
        $output = '';
        $count = DB::table('review_helpful')
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
        $count = DB::table('review_unhelpful')
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
                    ->join('ordered_gifts', 'ordered_gifts.order_id', '=', 'orders.id')
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->where('orders.user_id', $user_id)
                    ->sum('quantity');
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