<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    private $file;

    function setUp()
    {
        parent::setUp();
        $this->file = $this->file();
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
        $slugWillBe = str_replace(' ', '-', strtolower($data['title']));
        $this->login()->post('/admin/posts', $data);
        $this->assertDatabaseHas('posts', ['slug' => $slugWillBe, 'title' => $data['title']]);
    }

    function test_admin_can_delete_a_post()
    {
        $file = $this->file();
        $file2 = $this->file();
        $post = $this->create('Post');
        $this->login()->post('/admin/images', ['postId' => $post->id, 'images' => [$file]]);
        $this->post('/admin/videos', ['postId' => $post->id, 'video' => $file2, 'slug' => $post->title]);
        $this->delete('/admin/posts/'.$post->slug);
        $this->assertDatabaseMissing('posts', $post->toArray());
        $this->assertDatabaseMissing('images', ['slug' => 'upload/'.$file->hashName()]);
        $this->assertDatabaseMissing('videos', ['slug' => 'video/'.$file2->hashName()]);
        $this->fileMissing($file->hashName());
        $this->fileMissing($file2->hashName(), 'video');
    }

    function test_admin_can_update_a_post()
    {
        $post = $this->create('Post')->toArray();
        $post['title'] = 'New Title '.$post['title'];
        $this->login()->put('/admin/posts/'.$post['slug'], $post);
        $this->assertDatabaseHas('posts', ['slug' => 'new-title-'.$post['slug']]);
    }

    function test_admin_can_upload_images_to_a_post()
    {
        $post = $this->create('Post');

        $data = [
            'postId' => $post->id,
            'images' => [$this->file]
        ];
        
        $this->login()->post('/admin/images', $data);
        $this->assertDatabaseHas('images', ['post_id' => $post->id, 'slug' => 'upload/'.$this->file->hashName()]);
        $this->fileExist($this->file->hashName());
    }

    function test_admin_can_delete_an_image_of_a_post()
    {
        $data = [
            'postId' => $this->create('Post')->id,
            'images' => [$this->file]
        ];
        
        $response = $this->login()->post('/admin/images', $data);
        $image = \App\Image::first();
        $this->delete('/admin/images/'.$this->file->hashName());
        $this->assertDatabaseMissing('images', $image->toArray());
        $this->fileMissing($this->file->hashName());
    }

    function test_admin_can_set_an_image_as_thumbnail()
    {
        $image = $this->create('Image', ['slug' => 'upload/1.jpg']);
        $this->login()->put('/admin/images/1.jpg');
        $this->assertDatabaseHas('images', ['id' => $image->id, 'is_thumbnail' => 1]);
    }

    function test_admin_can_upload_a_video()
    {
        $post = $this->create('Post');
        
        $this->login()->post('/admin/videos', [
            'postId' => $post->id,
            'slug' => $post->title,
            'video' => $this->file
        ]);

        $this->assertDatabaseHas('videos', ['post_id' => $post->id, 'link' => 'video/'.$this->file->hashName()]);
        $this->fileExist($this->file->hashName(), 'video');
    }

    function test_admin_can_set_a_thumbnail_for_a_video()
    {
        $video = $this->create('Video');
        $file = $this->file();
        $this->login()->post('/admin/videos/thumbnail/'.$video->slug, ['image' => $file]);
        $this->assertDatabaseHas('images', ['video_id' => $video->id, 'slug' => 'upload/'.$file->hashName()]);
        $this->fileExist($file->hashName());
    }

    function test_admin_can_delete_a_video()
    {
        $this->test_admin_can_upload_a_video();
        $video = \App\Video::first();
        $this->delete('/admin/videos/'.$video->slug);
        $this->assertDatabaseMissing('videos', $video->toArray());
        $this->fileMissing($this->file->hashName(), 'video');
    }

    function test_admin_can_view_a_video()
    {
        $this->test_admin_can_upload_a_video();
        $video = \App\Video::first();
        $this->get('/admin/videos/'.$video->slug)->assertSee($video->link);
    }

    function test_admin_can_view_an_image()
    {
        $this->test_admin_can_upload_images_to_a_post();
        $image = \App\Image::first();
        $this->get('/admin/images/'.$this->file->hashName())->assertSee($image->slug);
    }

    function test_admin_can_search_posts()
    {
        $post1 = $this->create('Post', ['title' => 'A Test Post']);
        $post2 = $this->create('Post', ['title' => 'A second Post']);
        $this->login()->get('/admin/posts/search?q=est p')
            ->assertJson([$post1->toArray()])
            ->assertDontSee($post2->title);
    }
}
