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
        $this->expectException('Illuminate\Auth\AuthenticationException');
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
        $video = $this->create('Video');
        $postImage = $this->create('Image', ['post_id' => $video->post->id]);
        $videoThumbnail = $this->create('Image', ['video_id' => $video->id]);
        $this->login()->delete('/admin/posts/'.$video->post->slug);
        $this->assertDatabaseMissing('posts', $video->post->toArray());
        $this->assertDatabaseMissing('images', ['slug' => $postImage->slug]);
        $this->assertDatabaseMissing('images', ['slug' => $videoThumbnail->slug]);
        $this->assertDatabaseMissing('videos', ['slug' => $video->slug]);
        $this->fileMissing($postImage->slug);
        $this->fileMissing($videoThumbnail->slug);
        $this->fileMissing($video->link);
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

        $file = $this->file();

        $this->login()->post('/admin/images', [
            'postId' => $post->id,
            'images' => [$file]
        ]);

        $this->assertDatabaseHas('images', ['post_id' => $post->id, 'slug' => 'upload/'.$file->hashName()]);
        $this->fileExist($file->hashName());
    }

    function test_admin_can_delete_an_image_of_a_post()
    {
        $image = $this->create('Image', ['post_id' => $this->create('Post')->id]);
        $this->login()->delete('/admin/images/'.explode('/', $image->slug)[1]);
        $this->assertDatabaseMissing('images', $image->toArray());
        $this->fileMissing($image->slug);
    }

    function test_admin_can_choose_an_image_as_thumbnail()
    {
        $post = $this->create('Post');

        $image = $this->create('Image', [
            'post_id' => $post->id
        ]);
        $this->deleteUselessFile($image->slug);

        $this->login()->put('/admin/images/'.explode('/', $image->slug)[1]);
        $this->assertDatabaseHas('images', ['id' => $image->id, 'is_thumbnail' => 1]);
    }

    function test_admin_can_upload_a_video()
    {
        $post = $this->create('Post');

        $file = $this->file();
        
        $this->login()->post('/admin/videos', [
            'postId' => $post->id,
            'slug' => $post->title,
            'video' => $file
        ]);

        $this->assertDatabaseHas('videos', ['post_id' => $post->id, 'link' => 'video/'.$file->hashName()]);
        $this->fileExist($file->hashName(), 'video');
    }

    function test_admin_can_set_a_thumbnail_for_a_video()
    {
        $video = $this->create('Video');
        $this->deleteUselessFile($video->link);
        $file = $this->file();
        $this->login()->post('/admin/videos/thumbnail/'.$video->slug, ['image' => $file]);
        $this->assertDatabaseHas('images', ['video_id' => $video->id, 'slug' => 'upload/'.$file->hashName()]);
        $this->fileExist($file->hashName());
    }

    function test_admin_can_delete_a_video()
    {
        $video = $this->create('Video');
        $thumbnail = $this->create('Image', ['video_id' => $video->id]);
        $this->login()->delete('/admin/videos/'.$video->slug);
        $this->assertDatabaseMissing('videos', $video->toArray());
        $this->fileMissing($video->link);
        $this->fileMissing($thumbnail->slug);
    }

    function test_admin_can_view_a_video()
    {
        $video = $this->create('Video');
        $this->login()->get('/admin/videos/'.$video->slug)->assertSee($video->link);
        $this->deleteUselessFile($video->link);
    }

    function test_admin_can_view_an_image()
    {
        $image = $this->create('Image', ['post_id' => $this->create('Post')->id]);
        
        $this->login()->get('/admin/images/'.explode('/', $image->slug)[1])->assertSee($image->slug);

        $this->deleteUselessFile($image->slug);
    }

    function test_admin_can_search_posts()
    {
        $post1 = $this->create('Post', ['title' => 'A Test Post']);
        $post2 = $this->create('Post', ['title' => 'A second Post']);
        $this->login()->get('/admin/posts/search?q=est p')
            ->assertJson([$post1->toArray()])
            ->assertDontSee($post2->title);
    }

    function test_admin_can_set_a_video_preview_for_a_post()
    {
        $post = $this->create('Post');
        $video1 = $this->create('Video', ['post_id' => $post->id]);
        $video2 = $this->create('Video', ['is_free' => 1, 'post_id' => $post->id]);
        $this->login()->put('/admin/videos/'.$video1->slug.'/preview');
        $this->assertDatabaseHas('Videos', ['id' => $video1->id, 'is_free' => 1]);
        $this->assertDatabaseMissing('Videos', ['id' => $video2->id, 'is_free' => 1]);
        $this->deleteUselessFile($video1->link);
        $this->deleteUselessFile($video2->link);
    }
}
