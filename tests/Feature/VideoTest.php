<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guests_can_see_video_prviews()
    {
        $video = $this->create('Video', ['is_free' => 1]);
        $this->deleteUselessFile($video->link);
        $this->get('/video/'.$video->slug)->assertStatus(200);
    }

    public function test_guests_can_not_see_paid_videos()
    {
        $video = $this->create('Video');
        $this->deleteUselessFile($video->link);
        $this->get('/video/'.$video->slug)->assertStatus(404);
    }

    public function test_expired_members_can_not_see_paid_videos()
    {
        $video = $this->create('Video');
        $this->deleteUselessFile($video->link);
        $this->login($this->create('User', ['plan' => 1]))->get('/video/'.$video->slug)->assertStatus(404);
    }

    public function test_valid_members_can_see_paid_videos()
    {
        $video = $this->create('Video');
        $user = $this->create('User', ['plan' => 1, 'expired_at' => Carbon::now()->addDay()]);
        $this->deleteUselessFile($video->link);
        $this->login($user)->get('/video/'.$video->slug)->assertStatus(200);
    }

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
