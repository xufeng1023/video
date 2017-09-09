<?php

namespace App\Http\Controllers\Front;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function stream(Video $video)
    {
    	if($video->is_free || (auth()->user() && !auth()->user()->expired())) {
            if(app()->environment() === 'testing') return;
            $video->play();
	    }

        return response([], 404);
    }

    public function next(Video $video)
    {
    	$slug = $video->nextVideoSlug();
    	return Video::with('thumbnail')->where('slug', $slug)->first();
    }
}
