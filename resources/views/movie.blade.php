@extends('layouts.app')

@section('style')
    <link href="http://vjs.zencdn.net/6.2.7/video-js.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            @if($post->videos->where('is_free', 1)->first())
                <video-frame init="{{ asset('/storage/'.$post->videos->where('is_free', 1)->first()->link) }}"></video-frame>
            @endif
            <h1>{{ $post->title }}</h1>
            <p>Videos</p>
            <div class="row">
                @foreach($post->videos as $video)
                    @if($video->thumbnail)
                        <div class="col-xs-2 col-sm-4">
                            <video-one :video="{{ $video }}"></video-one>
                        </div>
                    @endif
                @endforeach
            </div>
            <p>Images</p>
            <div class="row">
                @foreach($post->images as $image)
                    <div class="col-xs-2 col-sm-4">
                        <a href="/{{ $image->slug }}" target="_blank">
                            <img src="{{ asset('/storage/'.$image->slug) }}" width="100%">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="http://vjs.zencdn.net/6.2.7/video.js"></script>
    <script src="//cdn.sc.gl/videojs-hotkeys/latest/videojs.hotkeys.min.js"></script>
@endsection
