@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <update-post-form data="{{ $post }}"></update-post-form>
                    <hr>
                    <post-image-input 
                        src="{{ asset('storage/') }}" 
                        id="{{ $post->id }}"
                        image="{{ $post->images }}"
                    ></post-image-input>
                    <hr>
                    <video-input id="{{ $post->id }}"></video-input>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
