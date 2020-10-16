@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="blog-page">
    <!-- Showcase Owl Carousel Slider -->
    <div class="showcase-carousel owl-carousel owl-theme">
        <!-- Blog Post Item -->
        <div class="blog-post item">
            <div class="blog-post-overlay d-grid">
                <div class="content m-auto">
                    <h4 class="font-600">
                        What to Write in a Birthday Card: Messages and Wishes
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn border-light text-white d-flex align-items-center mb-1">
                            Read more
                            <i class="material-icons ml-1 text-white">chevron_right</i>
                        </button>
                    </div>
                </div>
            </div>
            <img src="{{ asset('img/backgrounds/birthdayhero.jpg') }}" alt="" class="w-100 blog-image">
        </div>
        <!-- /.Blog Post Item -->

        <!-- Blog Post Item -->
        <div class="blog-post item">
            <div class="blog-post-overlay d-grid">
                <div class="content m-auto">
                    <h4 class="font-600">
                        10 Wedding RSVP Etiquette Tips & Ideas
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn border-light text-white d-flex align-items-center mb-1">
                            Read more
                            <i class="material-icons ml-1 text-white">chevron_right</i>
                        </button>
                    </div>
                </div>
            </div>
            <img src="{{ asset('img/backgrounds/hero-2.jpg') }}" alt="" class="w-100 blog-image">
        </div>
        <!-- /.Blog Post Item -->

        <!-- Blog Post Item -->
        <div class="blog-post item">
            <div class="blog-post-overlay d-grid">
                <div class="content m-auto">
                    <h4 class="font-600">
                        30 Easy Homemade Birthday Card Ideas
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn border-light text-white d-flex align-items-center mb-1">
                            Read more
                            <i class="material-icons ml-1 text-white">chevron_right</i>
                        </button>
                    </div>
                </div>
            </div>
            <img src="{{ asset('img/backgrounds/Homemade-Birthday-Hero.jpg') }}" alt="" class="w-100 blog-image">
        </div>
        <!-- /.Blog Post Item -->

        <!-- Blog Post Item -->
        <div class="blog-post item">
            <div class="blog-post-overlay d-grid">
                <div class="content m-auto">
                    <h4 class="font-600">
                        50 Baby Shower Invitation Wording Ideas
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn border-light text-white d-flex align-items-center mb-1">
                            Read more
                            <i class="material-icons ml-1 text-white">chevron_right</i>
                        </button>
                    </div>
                </div>
            </div>
            <img src="{{ asset('img/backgrounds/Baby-Hero.jpg') }}" alt="" class="w-100 blog-image">
        </div>
        <!-- /.Blog Post Item -->

        <!-- Blog Post Item -->
        <div class="blog-post item">
            <div class="blog-post-overlay d-grid">
                <div class="content m-auto">
                    <h4 class="font-600">
                        Bloody Mary Bar Tips and Recipes
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn border-light text-white d-flex align-items-center mb-1">
                            Read more
                            <i class="material-icons ml-1 text-white">chevron_right</i>
                        </button>
                    </div>
                </div>
            </div>
            <img src="{{ asset('img/backgrounds/bloody-mary-bar-drinks-hero.jpg') }}" alt="" class="w-100 blog-image">
        </div>
        <!-- /.Blog Post Item -->

         <!-- Blog Post Item -->
         <div class="blog-post item">
            <div class="blog-post-overlay d-grid">
                <div class="content m-auto">
                    <h4 class="font-600">
                        How to Make a Homemade Bellini Bar
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn border-light text-white d-flex align-items-center mb-1">
                            Read more
                            <i class="material-icons ml-1 text-white">chevron_right</i>
                        </button>
                    </div>
                </div>
            </div>
            <img src="{{ asset('img/backgrounds/bellini-hero-03.jpg') }}" alt="" class="w-100 blog-image">
        </div>
        <!-- /.Blog Post Item -->
    </div>
    <!-- /.Showcase Owl Carousel Slider -->

    <div class="d-grid grid-4 grid-p-1">
        <!-- Blog Post -->
        <div class="card blog-post-card bg-whitesmoke border-0 box-shadow-sm">
            <a href="/post" class="stretched-link"></a>
            <div class="post-stats bg-brick-red shadow-sm d-grid">
                <h6 class="m-auto d-block text-center lh-100">
                    <span class="text-white font-600 my-0 py-0">15m</span>
                </h6>
            </div>
            <div class="card-body">
                <h5 class="font-600 text-capitalize my-0 py-0">
                    It's all about sharing love to your loved ones
                </h5>
                <p class="text-faded text-sm my-0 py-0 text-capitalize">
                    <?= date('d F Y'); ?>
                </p>
                <p class="post-content text-justify my-2">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti iste facere.
                </p>
            </div>
            <div class="card-footer bg-whitesmoke">
                <div class="media">
                    <img src="{{ asset('img/users/user.png') }}" alt="" height="30" width="30" class="rounded-circle align-self-center mr-2">
                    <div class="media-body">
                        <h6 class="text-primary text-capitalize font-600 my-0 py-0">John Doe</h6>
                        <h6 class="text-sm text-faded text-capitalize my-0 py-0">On Christmas Gifts</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Blog Post -->

        <!-- Blog Post -->
        <div class="card blog-post-card bg-whitesmoke border-0 box-shadow-sm">
            <a href="/post" class="stretched-link"></a>
            <div class="post-stats bg-secondary shadow-sm d-grid">
                <h6 class="m-auto text-center lh-100">
                    <span class="text-white font-600 my-0 py-0">15m</span>
                </h6>
            </div>
            <div class="card-body m-0 p-0">
                <div class="post-img-wrapper">
                    <img src="{{ asset('img/backgrounds/fallback-image.jpg') }}" alt="" class="card-img-top h-100">
                    <div class="post-img-details w-100 px-3">
                        <h5 class="font-600 text-capitalize text-justify text-white my-0 py-0">
                            It's all about sharing love to your loved ones
                        </h5>
                        <p class="text-white text-sm my-0 py-0 text-capitalize">
                            <?= date('d F Y'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-whitesmoke">
                <div class="media">
                    <img src="{{ asset('img/users/15f59e48380fd4.jpg') }}" alt="" height="30" width="30" class="rounded-circle align-self-center mr-2">
                    <div class="media-body">
                        <h6 class="text-primary text-capitalize font-600 my-0 py-0">John Doe</h6>
                        <h6 class="text-sm text-faded text-capitalize my-0 py-0">On Christmas Gifts</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Blog Post -->

        <!-- Blog Post -->
        <div class="card blog-post-card bg-whitesmoke border-0 box-shadow-sm">
            <a href="/post" class="stretched-link"></a>
            <div class="post-stats bg-brick-red shadow-sm d-grid">
                <h6 class="m-auto d-block text-center lh-100">
                    <span class="text-white font-600 my-0 py-0">15m</span>
                </h6>
            </div>
            <div class="card-body">
                <h5 class="font-600 text-capitalize my-0 py-0">
                    It's all about sharing love to your loved ones
                </h5>
                <p class="text-faded text-sm my-0 py-0 text-capitalize">
                    <?= date('d F Y'); ?>
                </p>
                <p class="post-content text-justify my-2">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti iste facere.
                </p>
            </div>
            <div class="card-footer bg-whitesmoke">
                <div class="media">
                    <img src="{{ asset('img/users/user.png') }}" alt="" height="30" width="30" class="rounded-circle align-self-center mr-2">
                    <div class="media-body">
                        <h6 class="text-primary text-capitalize font-600 my-0 py-0">John Doe</h6>
                        <h6 class="text-sm text-faded text-capitalize my-0 py-0">On Christmas Gifts</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Blog Post -->

        <!-- Blog Post -->
        <div class="card blog-post-card bg-whitesmoke border-0 box-shadow-sm">
            <a href="/post" class="stretched-link"></a>
            <div class="post-stats bg-secondary shadow-sm d-grid">
                <h6 class="m-auto text-center lh-100">
                    <span class="text-white font-600 my-0 py-0">15m</span>
                </h6>
            </div>
            <div class="card-body m-0 p-0">
                <div class="post-img-wrapper">
                    <img src="{{ asset('img/backgrounds/fallback-image.jpg') }}" alt="" class="card-img-top h-100">
                    <div class="post-img-details w-100 px-3">
                        <h5 class="font-600 text-capitalize text-justify text-white my-0 py-0">
                            It's all about sharing love to your loved ones
                        </h5>
                        <p class="text-white text-sm my-0 py-0 text-capitalize">
                            <?= date('d F Y'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-whitesmoke">
                <div class="media">
                    <img src="{{ asset('img/users/15f59e48380fd4.jpg') }}" alt="" height="30" width="30" class="rounded-circle align-self-center mr-2">
                    <div class="media-body">
                        <h6 class="text-primary text-capitalize font-600 my-0 py-0">John Doe</h6>
                        <h6 class="text-sm text-faded text-capitalize my-0 py-0">On Christmas Gifts</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Blog Post -->
    </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')