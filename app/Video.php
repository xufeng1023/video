<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = [];

    function images()
    {
    	return $this->hasMany('App\Image');
    }
}
