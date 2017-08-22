<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
	use DatabaseMigrations;

    function test_post_title_must_be_unique()
    {
    	$post = $this->create('Post');
    	$this->login()->post('/admin/posts', ['title' => $post->title])
    		->assertSessionHasErrors('title');
    }
}
