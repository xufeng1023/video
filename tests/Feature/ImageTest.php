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
    	$image1 = $this->create('Image', ['is_thumbnail' => 1]);
    	$image2 = $this->create('Image', ['post_id' => $image1->post->id]);
    	$this->login()->put('/admin/images/'.$image2->id);
    	$this->assertDatabaseHas('images', ['id' => $image1->id, 'is_thumbnail' => 0]);
    	$this->assertDatabaseHas('images', ['id' => $image2->id, 'is_thumbnail' => 1]);
    }

    function test_a_video_can_only_have_one_thumbnail()
    {
    	$video = $this->create('Video');
    	$path = '/admin/videos/thumbnail/'.$video->id;
    	$file1 = $this->file();
    	$file2 = $this->file();
    	$this->login()->post($path, ['image' => $file1]);
    	$this->post($path, ['image' => $file2]);
    	$this->assertDatabaseHas('images', ['video_id' => $video->id, 'slug' => 'upload/'.$file2->hashName()]);
    	$this->fileExist($file2->hashName());
    	$this->fileMissing($file1->hashName());
    }
}
