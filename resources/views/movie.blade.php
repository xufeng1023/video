@extends('layouts.app')

@section('style')
    <link href="http://vjs.zencdn.net/6.2.7/video-js.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            @if($preview)
                <video-frame :preview="{{ $preview }}"></video-frame>
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
                        <image-one :image="{{ $image }}"></image-one>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<image-modal inline-template>
    <div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <img :src="src | FILE" width="100%" v-if="src">
        </div>
    </div>
</image-modal>
@endsection

@section('script')
    <script src="http://vjs.zencdn.net/6.2.7/video.js"></script>
    <script src="//cdn.sc.gl/videojs-hotkeys/latest/videojs.hotkeys.min.js"></script>
@endsection
