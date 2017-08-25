<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

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
        $file = $this->file();
        $post = $this->create('Post');
        $this->login()->post('/admin/images', ['post_id' => $post->id, 'images' => [$file]]);
        $this->delete('/admin/posts/'.$post->id);
        $this->assertDatabaseMissing('posts', $post->toArray());
        $this->assertDatabaseMissing('images', ['slug' => 'upload/'.$file->hashName()]);
        $this->fileMissing($file->hashName());
    }

    function test_admin_can_update_a_post()
    {
        $post = $this->create('Post')->toArray();
        $post['title'] = 'New Title '.$post['title'];
        $this->login()->put('/admin/posts/'.$post['id'], $post);
        $this->assertDatabaseHas('posts', $post);
    }

    function test_admin_can_upload_images_to_a_post()
    {
        $post = $this->create('Post');
        $image = $this->file();
        $data = [
            'post_id' => $post->id,
            'images' => [$image]
        ];
        
        $this->login()->post('/admin/images', $data);
        $this->assertDatabaseHas('images', ['post_id' => $post->id, 'slug' => 'upload/'.$image->hashName()]);
        $this->fileExist($image->hashName());
    }

    function test_admin_can_delete_an_image_of_a_post()
    {
        $image = $this->file();

        $data = [
            'post_id' => $this->create('Post')->id,
            'images' => [$image]
        ];
        
        $response = $this->login()->post('/admin/images', $data);
        $insertedImage = $response->original['slugs'][0]; // 'slugs' is a json returned from that controller method
        $this->delete('/admin/images/'.$insertedImage['id']);
        $this->assertDatabaseMissing('images', $insertedImage);
        $this->fileMissing($image->hashName());
    }

    function test_admin_can_set_an_image_as_thumbnail()
    {
        $image = $this->create('Image');
        $this->login()->put('/admin/images/'.$image->id);
        $this->assertDatabaseHas('images', ['id' => $image->id, 'is_thumbnail' => 1]);
    }
}
