<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login($user = null)
    {
        $user = $user ?: $this->admin();
    	$this->be($user);
    	return $this;
    }

    protected function create($model, $attr = [])
    {
    	return factory("App\\$model")->create($attr);
    }

    protected function make($model, $attr = [])
    {
    	return factory("App\\$model")->make($attr);
    }

    protected function raw($model, $attr = [])
    {
    	return factory("App\\$model")->raw($attr);
    }

    protected function file($name = 'image.jpg')
    {
        Storage::fake('public');
        return UploadedFile::fake()->image($name);
    }

    protected function fileExist($slug, $folder = 'upload')
    {
        return Storage::disk('public')->assertExists($folder.'/'.$slug);
    }

    protected function fileMissing($slug, $folder = 'upload')
    {
        return Storage::disk('public')->assertMissing($folder.'/'.$slug);
    }

    protected function admin()
    {
    	return $this->create('User', ['is_admin' => 1]);
    }
}
