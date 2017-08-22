@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <video-input id="{{ $post->id }}"></video-input>

        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <update-post-form data="{{ $post }}"></update-post-form>
                    <hr>
                    <div class="form-group">
                        <label>Images</label>
                        <input type="file" name="screenshots[]" accept="image/*" multiple>
                    </div>
                    @foreach($post->images->chunk(4) as $chunk)
                    <div class="row">
                        @foreach($chunk as $image)
                            <div class="col-sm-3">
                                <div class="thumbnail">
                                    <img src="" width="100%">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
