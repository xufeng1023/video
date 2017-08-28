<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function postId($request)
    {
    	if(app()->environment() === 'testing') {
    		return $request->postId;
    	}
    	
        $referer = $request->headers->get('referer');
        preg_match('/\/(\d+)\//', $referer, $match);
        return $match[1];
    }
}
