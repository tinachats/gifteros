@include('layouts.includes.header')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">Edit Blog Post</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item text-capitalize d-none d-md-inline">Articles</li>
                    <li class="breadcrumb-item active">Blog</a></li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5">
        @include('layouts.includes.alerts')
        <div class="col-12 col-md-7">
            <h6 class="font-600">Update your blog post content</h6>
            {!! Form::open(['action' => ['App\Http\Controllers\BlogPostController@update', $post->id], 'method' => 'POST', 'class' => 'needs-validation', 'novalidate' => true, 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                    {{ Form::label('title', 'Title', ['class' => 'text-sm font-600']) }}
                    {{ Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Blog post title', 'required' => true])}}
                </div>
                <div class="form-group">
                    {{ Form::label('title', 'Body', ['class' => 'text-sm font-600']) }}
                    {{ Form::textarea('body', $post->body, ['class' => 'form-control w-100 bg-transparent ckeditor', 'id' => 'editor', 'placeholder' => 'Body of new blog post', 'rows' => 7, 'required' => true])}}
                </div>
                <div class="form-group">
                    {{ Form::file('cover-image') }}
                </div>
                <div class="row justify-content-end mr-2">
                    {{ Form::hidden('_method', 'PUT') }}
                    {{ Form::submit('Save Changes', ['class' => 'btn btn-primary font-600']) }}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')
<!-- CKEditor -->
<script src="{{ asset('plugins/ckeditor5-build-classic-22.0.0/ckeditor.js') }}"></script>
<!--script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script-->
<script>
    // CKEditor
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>