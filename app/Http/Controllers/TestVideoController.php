<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\VideoStream;
class TestVideoController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
    	return view('testvideo');
    }

    public function send()
    {
    	$file = storage_path('app/public/video/test.mp4');

        $stream = new VideoStream($file);
		$stream->start();
    }
}
