<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use Auth;

class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::orderBy('created_at', 'desc')->paginate(4);

        return view('posts.index',compact('posts'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = new Post();
        $post->created_by = Auth::user()->name;
        $post->title = $request['title'];
        $post->body = $request['body'];

        $post->save();

        return redirect()->route('posts.index')
                        ->with('success','Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post = Post::find($post_id);
        //dd($post);

        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::find($post_id);

        $post->update($request->all());

        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully');    
    }

    /****** Vue Functions ******/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexVue()
    {

        $posts = Post::orderBy('created_at', 'desc')->get();

        return response()->json([
            'posts'    => $posts,
        ], 200);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeVue(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = new Post();
        $post->created_by = isset(Auth::user()->name) ? Auth::user()->name : '';
        $post->title = $request['title'];
        $post->body = $request['body'];

        $post->save();

        return response()->json([
            'post'    => $post,
            'message' => 'Success'
        ], 200);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroyVue($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();

        return response()->json([
                    'message' => 'Success'
                ], 200);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function updateVue(Request $request, $post_id)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::find($post_id);

        $post->update($request->all());

        return response()->json([
            'post'    => $post,
            'message' => 'Success'
        ], 200);
    }
}
