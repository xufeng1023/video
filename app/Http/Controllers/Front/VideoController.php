<?php

namespace App\Http\Controllers\Front;

use App\Video;
use App\VideoStream;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function stream(Video $video)
    {
    	if(auth()->user()) {

	    	$file = storage_path('app/public/'.$video->link);
	    	
	    	(new VideoStream($file))->start();

	    }
    }
}
