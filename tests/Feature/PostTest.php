<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
	use DatabaseMigrations;

    function test_guest_can_see_posts_at_front_page()
    {
        $post = $this->create('Post');
        $this->get('/')->assertSee($post->title);
    }

    function test_post_title_must_be_unique()
    {
    	$post = $this->create('Post');
    	$this->login()->post('/admin/posts', ['title' => $post->title])
    		->assertSessionHasErrors('title');
    }

    function test_on_post_edit_page_post_will_eager_load_its_videos()
    {
    	$post = $this->create('Post');
    	$video = $this->create('Video', ['post_id' => $post->id]);
    	$this->login()->get('/admin/posts/'.$post->slug.'/edit')
    		->assertSee($post->videos()->first()->slug);
    }
}
