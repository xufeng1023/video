<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $video = Video::create([
            'post_id' => $request->postId,
            'slug' => $request->slug,
            'link' => $request->video->store('video', 'public')
        ]);

        return ['videoId' => $video->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('admin.video', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {   
        $file = storage_path('app/public/'.$video->link);

        $handle = fopen($file, 'a');

        file_put_contents($file, file_get_contents($request->video), FILE_APPEND | LOCK_EX);

        fclose($handle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->deleteThumbnail()->deleteFiles()->delete();
    }

    public function thumbnail(Request $request, Video $video)
    {
        if($thumbnail = $video->thumbnail) $thumbnail->deleteFiles()->delete();

        $video = $video->thumbnail()->create([
            'slug' => $request->image->store('upload', 'public')
        ]);

        return ['src' => $video->slug];
    }
}
