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
        $this->expectException('Illuminate\Validation\ValidationException');
    	$post = $this->create('Post');
    	$this->login()->post('/admin/posts', ['title' => $post->title])
    		->assertSessionHasErrors('title');
    }
}
