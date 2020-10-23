<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = BlogPost::orderBy('id', 'DESC')->get();
        return view('blog.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'body'        => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover-image')){
            // Get filename with extension
            $file = $request->file('cover-image')->getClientOriginalName();
            // Get extension
            $ext = $request->file('cover-image')->getClientOriginalExtension();
            // Filename to store
            $cover_image = uniqid(true) . '.' . $ext;
            // Upload cover image
            $path = $request->file('cover-image')->storeAs('public/blog', $cover_image);
        } else {
            $cover_image = 'default-cover-img.jpg';
        }

        // Create new blog post
        $post = new BlogPost();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = Auth::user()->id;
        $post->cover_image = $cover_image;
        $post->save();

        return redirect('blog')->with('success', 'Blog post successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = BlogPost::find($id);
        return view('blog.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::find($id);
        return view('blog.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required',
            'body'        => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover-image')){
            // Get filename with extension
            $file = $request->file('cover-image')->getClientOriginalName();
            // Get extension
            $ext = $request->file('cover-image')->getClientOriginalExtension();
            // Filename to store
            $cover_image = uniqid(true) . '.' . $ext;
            // Upload cover image
            $path = $request->file('cover-image')->storeAs('public/blog', $cover_image);
        }

        // Create new blog post
        $post = BlogPost::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover-image')){
            $post->cover_image = $cover_image;
        }
        $post->save();

        return redirect('/blog_posts')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::find($id);
        if($post->cover_image != 'default-cover-img.jpg'){
            // Delete image
            Storage::delete('/storage/blog_posts/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/blog_posts')->with('success', 'Blog post successfully deleted!');
    }
}
