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
                        <img src="../img/app/product-labels/hot.gif" alt="" height="22" width="56" class="img-fluid">
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
        $gift_rating = round(giftRating($gift_id), 1);

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

    // Related gifts
    function relatedGifts($gift_id, $category_id){
        $output = '';
        $relatives = DB::table('gifts')
                        ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->where('gifts.id', '!=', $gift_id)
                        ->where('gifts.category_id', '=', $category_id)
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

                $gift_label = giftLabel($gift_id);

                $output .= '
                    <!-- Related Gift -->
                    <div class="item w-100">
                        <a href="'.route('details.show', [$gift->slug, $gift->id]).'" class="stretched-link">
                            <div class="related-gift card bg-whitesmoke box-shadow-sm rounded-0 border-0 w-100">
                                <div class="gift-actions d-flex align-items-center justify-content-between w-100">
                                    '.$gift_label.'
                                </div>
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
?>