<?php
    use Illuminate\Support\Facades\DB;

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

    /*** Progress-bar star ratings ***/ 
    // Five Star Rating
    function fiveStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating', DB::raw('count(*) as customer_rating and round(customer_rating) = 5'))
                    ->groupBy('customer_rating')
                    ->where('gift_id', $gift_id)
                    ->count();
        return $count;
    }

    // Four Star Rating
    function fourStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating', DB::raw('count(*) as customer_rating and round(customer_rating) = 4'))
                    ->groupBy('customer_rating')
                    ->where('gift_id', $gift_id)
                    ->count();
        return $count;
    }

    // Three Star Rating
    function threeStarRating($gift_id){
        $count = DB::table('gift_ratings')
                ->select('customer_rating', DB::raw('count(*) as customer_rating and round(customer_rating) = 3'))
                ->groupBy('customer_rating')
                ->where('gift_id', $gift_id)
                ->count();
        return $count;
    }

    // Two Star Rating
    function twoStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating', DB::raw('count(*) as customer_rating and round(customer_rating) = 2'))
                    ->groupBy('customer_rating')
                    ->where('gift_id', $gift_id)
                    ->count();
        return $count;
    }

    // One Star Rating
    function oneStarRating($gift_id){
        $count = DB::table('gift_ratings')
                    ->select('customer_rating', DB::raw('count(*) as customer_rating and round(customer_rating) = 1'))
                    ->groupBy('customer_rating')
                    ->where('gift_id', $gift_id)
                    ->count();
        return $count;
    }

    /*** End of Progress Bar Functions ***/
?>