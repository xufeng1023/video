<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'views', 'plan', 'expired_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
        return $this->slug.'-'.($this->videos()->count() + 1);
    }

    public function getPreview()
    {
        return $this->videos()->orderBy('is_free', 'desc')->first();
    }
}
