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

    private $video;

    function setUp()
    {
        parent::setUp();
        $this->video = $this->create('Video');
    }

    function test_guests_can_not_access_admin_directory()
    {
        $this->get('/admin')->assertStatus(302);
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
            ->assertStatus(200)->assertSee($this->video->title);
    }
    function test_video_slug_must_be_unique()
    {
        $video = $this->raw('Video');
        $video['slug'] =  $this->video->slug;
        $response = $this->login()->post('/admin/videos', $video);
        $response->assertSessionHasErrors('slug');
    }
    function test_admin_can_upload_a_video()
    {
        \Storage::fake('public');

        $video = $this->raw('Video');
        $video['thumbnail'] = UploadedFile::fake()->image('thumbnail.jpg');
        $video['screenshots'][] = UploadedFile::fake()->image('shot1.jpg');

        $this->login()->post('/admin/videos', $video);

        $this->assertDatabaseHas('images', ['slug' => 'upload/'.$video['screenshots'][0]->hashName()]);
        \Storage::disk('public')->assertExists('upload/'.$video['thumbnail']->hashName());
    }
    function test_admin_can_edit_a_video()
    {
        $slug = 'new slug';
        $this->login()->put('/admin/videos/'.$this->video->id, ['slug' => $slug]);
        $this->assertDatabaseHas('videos', ['id' => $this->video->id, 'slug' => $slug]);
    }
    function test_admin_can_view_a_video()
    {
        $this->login()->get('/admin/videos/'.$this->video->id)
            ->assertSee($this->video->title);
    }
    function test_admin_can_delete_a_video()
    {
        $this->login()
            ->delete('/admin/videos/'.$this->video->id);
        $this->assertDatabaseMissing('videos', ['id' => $this->video->id]);
    }
}
