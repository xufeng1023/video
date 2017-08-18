<?php

namespace Tests;

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

    protected function admin()
    {
    	return $this->create('User', ['is_admin' => 1]);
    }
}
