@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            @if($post->videos->where('is_free', 1)->first())
                <div>
                    <video src="{{ asset('/storage/'.$post->videos->where('is_free', 1)->first()->link) }}" controls></video>
                </div>
            @endif
            <div>{{ $post->title }}</div>
            <div class="row">
                @foreach($post->videos as $video)
                    @if($video->thumbnail)
                        <div class="col-xs-2 col-sm-4">
                            <img src="{{ asset('/storage/'.$video->thumbnail->slug) }}" width="100%">
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="row">
                @foreach($post->images as $image)
                    <div class="col-xs-2 col-sm-4">
                        <img src="{{ asset('/storage/'.$image->slug) }}" width="100%">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
