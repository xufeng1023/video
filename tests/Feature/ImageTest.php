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
}
