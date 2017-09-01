<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImageTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_post_can_only_have_one_thumbnail()
    {   
        $post = $this->create('Post');
        
    	$image1 = $this->create('Image', [
            'post_id' => $post->id,
            'is_thumbnail' => 1
        ]);
        $this->deleteUselessFile($image1->slug);

    	$image2 = $this->create('Image', [
            'post_id' => $post->id,
        ]);
        $this->deleteUselessFile($image2->slug);

    	$this->login()->put('/admin/images/'.explode('/', $image2->slug)[1]);
    	$this->assertDatabaseHas('images', ['id' => $image1->id, 'is_thumbnail' => 0]);
    	$this->assertDatabaseHas('images', ['id' => $image2->id, 'is_thumbnail' => 1]);
    }

    function test_a_video_can_only_have_one_thumbnail()
    {
    	$video = $this->create('Video');
        $this->deleteUselessFile($video->link);
    	$path = '/admin/videos/thumbnail/'.$video->slug;
    	$file1 = $this->file();
    	$file2 = $this->file();
    	$this->login()->post($path, ['image' => $file1]);
    	$this->post($path, ['image' => $file2]);
    	$this->assertDatabaseHas('images', ['video_id' => $video->id, 'slug' => 'upload/'.$file2->hashName()]);
    	$this->fileExist($file2->hashName());
    	$this->fileMissing($file1->hashName());
    }

    function test_delete()
    {
        $post = $this->create('Post');

        $image = $this->create('Image', [
            'post_id' => $post->id
        ]);
        //$this->deleteUselessFile($image->slug);
    }
}
