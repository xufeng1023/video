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
        $videos = Video::latest()->get();
        return view('admin.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addVideo');
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
            'slug' => 'required|unique:videos',
            'thumbnail' => 'required|image',
            'screenshots' => 'required',
        ]);

        $video = Video::firstOrCreate([
            'title' => $request->title,
            'slug' => $request->slug,
            'thumbnail' => $request->thumbnail->store('upload', 'public'),
            'link' => 'video/'.Str::random(40).'.mp4'
        ]);

        if($request->hasFile('screenshots')) {
            foreach($request->screenshots as $shot) {
                $video->images()->create([
                    'slug' => $shot->store('upload', 'public')
                ]);
            }
        }

        return redirect('/admin');
    }

    /**
     * Store a video to an existing row.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadVideo(Video $video, Request $request)
    {   
        Storage::append('public/'.$video->link, file_get_contents($request->video), '');
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
        $video->slug = $request->slug;

        if($request->hasFile('thumbnail')) {
            $video->thumbnail = $request->thumbnail->store('upload', 'public');
        }

        $video->save();

        if($request->hasFile('screenshots')) {
            foreach($request->screenshots as $shot) {
                $video->images()->create([
                    'slug' => $shot->store('upload', 'public')
                ]);
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        Storage::delete('public/'.$video->link);
        Storage::delete('public/'.$video->thumbnail);
        foreach($video->images as $image) {
            Storage::delete('public/'.$image->slug);
        }
        $video->delete();
        return redirect('/admin');
    }
}
