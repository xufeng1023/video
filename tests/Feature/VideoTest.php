<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseMigrations;

    public function test_video_will_autoplay_after_one_another()
    {
    	$video1 = $this->create('Video', ['slug' => 'slug-1']);
    	$video2 = $this->create('Video', [
    		'post_id' => $video1->post->id,
    		'slug' => 'slug-2'
		]);
    	$this->deleteUselessFile($video1->link);
    	$this->deleteUselessFile($video2->link);
    	$this->get('/video/next/'.$video1->slug)
    		->assertSee($video2->slug);
    }
}
