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
        $path = $request->video->store('video', 'public');
        $video = Video::create([
            'post_id' => $request->postId,
            'slug' => $request->slug,
            'link' => $path,
            'thumbnail' => ''
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
        //ini_set('memory_limit', '200M');
        //Storage::append('public/'.$video->link, file_get_contents($request->video), '');
        echo (int) $_SERVER['CONTENT_LENGTH']."\n";
        echo memory_get_usage(true)."\n";
        echo memory_get_usage(false)."\n";
        echo memory_get_peak_usage(true)."\n";
        echo memory_get_peak_usage(false)."\n";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {

    }
}
