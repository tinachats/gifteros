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
    @if($posts->count() > 0)
        <div class="d-grid grid-4 grid-p-1">
        @foreach($posts as $post)
            <!-- Blog Post -->
            <a href="/blog/{{ $post->id }}" class="stretched-link">
                <div class="card blog-post-card bg-whitesmoke border-0 box-shadow-sm">
                    <div class="post-stats bg-secondary shadow-sm d-grid">
                        <h6 class="m-auto text-center lh-100">
                            <span class="text-white font-600 my-0 py-0">15m</span>
                        </h6>
                    </div>
                    <div class="card-body m-0 p-0">
                        <div class="post-img-wrapper">
                            <img src="/storage/blog/{{ $post->cover_image }}" alt="" class="card-img-top h-100">
                            <div class="post-img-details w-100 px-3">
                                <h5 class="font-600 text-capitalize text-white my-0 py-0">
                                    {{ $post->title }}
                                </h5>
                                <p class="text-white text-sm my-0 py-0 text-capitalize">
                                    {{ date('d F Y', strtotime($post->created_at)) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="media">
                            <img src="/storage/users/{{ $post->user->profile_pic }}" alt="" height="30" width="30" class="rounded-circle align-self-center mr-2">
                            <div class="media-body">
                                <h6 class="text-primary text-capitalize font-600 my-0 py-0">{{ $post->user->name }}</h6>
                                <h6 class="text-sm text-faded text-capitalize my-0 py-0">On Christmas Gifts</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- /.Blog Post -->
        @endforeach
        </div>
    @else
        <div class="container-fluid my-3">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center">
                    <h5 class="font-600">No posts found.</h5>
                    <p class="text-sm">
                        Hmmm...Seems like there are not any blog posts or articles to show at the moment.
                    </p>
                    @if(Auth::user()->user_type === 'admin')
                        <a href="/blog_posts/create" class="btn btn-primary btn-sm px-3">Create Post</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')