<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'views'];

    public function images()
    {
    	return $this->hasMany(Image::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function deleteImages()
    {
    	$this->images->each(function($item) {
            $item->deleteFiles()->delete();
        });

        return $this;
    }

    public function deleteVideos()
    {
        $this->videos->each(function($item) {
            $item->deleteThumbnail()->deleteFiles()->delete();
        });

        return $this;
    }

    public function videoSlug()
    {
        return $this->title.' '.($this->videos()->count() + 1);
    }
}
