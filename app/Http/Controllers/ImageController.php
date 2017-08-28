<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        foreach($request->images as $key => $image) {
            $slugs[$key]['slug'] = $image->store('upload', 'public');
            $pic = Image::create([
                'post_id' => $this->postId($request),
                'slug' => $slugs[$key]['slug'] 
            ]);
            $slugs[$key]['id'] = $pic->id;
            $slugs[$key]['is_thumbnail'] = $pic->is_thumbnail;
        }

        if(!empty($slugs)) {
            return ['slugs' => $slugs, 'message' => 'Uploaded '.count($slugs).' images!'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $image->removeAllThumbnails()->newThumbnail();

        return ['message' => 'Thumbnail changed!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->deleteFiles()->delete();
        
        return ['message' => 'Image Deleted!'];
    }
}
