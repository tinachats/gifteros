@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="blog-page">
    <div class="row">
        <div class="col-12 col-md-8">
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
                            <a class="ml-3" href="/blog/{{ $post->id }}/edit">
                                <span role="button" class="material-icons fa-2x text-white">edit</span>
                            </a>
                            {!! Form::open(['action' => ['App\Http\Controllers\BlogPostController@destroy', $post->id], 'method' => 'POST', 'class' => 'ml-auto']) !!}
                               {{ Form::hidden('_method', 'DELETE') }}
                               {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                            {!!Form::close()!!}
                        </div>
                    </div>
                </div>
                <img src="/storage/blog/{{ $post->cover_image }}" alt="" class="w-100 blog-image">
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
        </div>
        <div class="col-12 col-md-4">
            <h5 class="font-600">Recent articles</h5>
        </div>
    </div>
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')