@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('error')
                    <update-post-form data="{{ $post }}"></update-post-form>
                    <hr>
                    <image-input post="{{ $post->id }}" image="{{ $post->images }}"></image-input>
                    <hr>
                    <video-input post="{{ $post->id }}" slug="{{ $post->videoSlug() }}"></video-input>
                    @foreach($post->videos->chunk(4) as $chunk)
                        <div class="row">
                            @foreach($chunk as $video)
                                <div class="col-xs-3">
                                    <video-one :video="{{ $video }}"></video-one>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <hr>
                    @include('admin.deletePostBtn')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
