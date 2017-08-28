<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['post_id', 'slug', 'link'];

    public function thumbnail()
    {
    	return $this->hasOne(Image::class);
    }

    public function deleteThumbnail()
    {
    	if($this->thumbnail) {
    		$this->thumbnail->deleteFiles()->delete();
    	}
    	
    	return $this;
    }

    public function deleteFiles()
    {
    	if(Storage::disk('public')->exists($this->link)) {
            Storage::disk('public')->delete($this->link);
        }

        return $this;
    }
}
