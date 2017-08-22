<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();
    }

    function test_guests_can_not_access_admin_directory()
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    function test_users_can_not_access_admin_directory()
    {
        $this->login($this->create('User'))
            ->get('/admin')
            ->assertStatus(302);
    }

    function test_only_admin_can_access_admin_directory()
    {
        $this->login()
            ->get('/admin')
            ->assertStatus(200);
    }

    function test_admin_can_add_a_post()
    {
        $data = $this->raw('Post');
        $this->login()->post('/admin/posts', $data);
        $this->assertDatabaseHas('posts', $data);
    }

    function test_admin_can_delete_a_post()
    {
        $post = $this->create('Post');
        $this->login()->delete('/admin/posts/'.$post->id);
        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    function test_admin_can_update_a_post()
    {
        $post = $this->create('Post')->toArray();
        $post['title'] = 'New Title '.$post['title'];
        $this->login()->put('/admin/posts/'.$post['id'], $post);
        $this->assertDatabaseHas('posts', $post);
    }

    // function test_video_slug_must_be_unique()
    // {
    //     $slug = 'hello';
    //     $video1 = $this->raw('Video', ['slug' => $slug]);
    //     $video2 = $this->raw('Video', ['slug' => $slug]);
    //     $this->login()->post('/admin/videos', $video1);
    //     $response = $this->login()->post('/admin/videos', $video2);
    //     $response->assertSessionHasErrors('slug');
    // }
    // function test_admin_can_upload_a_video()
    // {
    //     \Storage::fake('public');

    //     $video = $this->raw('Video');
    //     $video['thumbnail'] = UploadedFile::fake()->image('thumbnail.jpg');
    //     $video['screenshots'][] = UploadedFile::fake()->image('shot1.jpg');

    //     $this->login()->post('/admin/videos', $video);

    //     $this->assertDatabaseHas('images', ['slug' => 'upload/'.$video['screenshots'][0]->hashName()]);
    //     \Storage::disk('public')->assertExists('upload/'.$video['thumbnail']->hashName());
    // }
    // function test_admin_can_edit_a_video()
    // {
    //     $slug = 'new slug';
    //     $this->login()->put('/admin/videos/'.$this->video->id, ['slug' => $slug]);
    //     $this->assertDatabaseHas('videos', ['id' => $this->video->id, 'slug' => $slug]);
    // }
    // function test_admin_can_view_a_video()
    // {
    //     $this->login()->get('/admin/videos/'.$this->video->id)
    //         ->assertSee($this->video->title);
    // }
    // function test_admin_can_delete_a_video()
    // {
    //     $this->login()
    //         ->delete('/admin/videos/'.$this->video->id);
    //     $this->assertDatabaseMissing('videos', ['id' => $this->video->id]);
    // }
}
