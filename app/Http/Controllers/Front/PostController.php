<?php

namespace App\Http\Controllers\Front;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
    	$posts = Post::with(['images' => function($query) {
    		$query->where('is_thumbnail', 1);
    	}])->latest()->paginate(20);

    	return view('front', compact('posts'));
    }
}
