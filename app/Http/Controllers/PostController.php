<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|unique:posts'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => $this->generateSlug($request->title)
        ]);

        return redirect('/admin/posts/'.$post->slug.'/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {   
        $post->load('videos.thumbnail')->get();
        return view('admin.post', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|unique:posts'
        ]);
        
        $post->update([
            'title' => $request->title,
            'slug' => $this->generateSlug($request->title)
        ]);

        return redirect('/admin/posts/'.$post->slug.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->deleteImages()->deleteVideos()->delete();

        return redirect('/admin');
    }

    public function search(Request $request)
    {
        return Post::where('title', 'LIKE', "%{$request->q}%")->get()->toJson();
    }

    private function generateSlug($title)
    {
        return str_replace(' ', '-', strtolower($title));
    }
}
