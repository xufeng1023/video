<?php

namespace App\Http\Controllers\Front;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function show(Image $image)
    {	
    	$image->load('post');
    	return view('image', compact('image'));
    }
}
