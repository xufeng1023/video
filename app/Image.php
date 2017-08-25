<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['post_id', 'slug'];

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function deleteFiles()
    {
    	if(Storage::disk('public')->exists($this->slug)) {
            Storage::disk('public')->delete($this->slug);
        }

        return $this;
    }

    public function newThumbnail()
    {
    	$this->is_thumbnail = 1;
        $this->save();
    }

    public function removeAllThumbnails()
    {
    	$this->post->images->each(function($item) {
            $item->is_thumbnail = 0;
            $item->save();
        });

        return $this;
    }
}
