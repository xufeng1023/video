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
                    <form action="/admin/videos/{{ $post->id }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ $post->title }}">
                        </div>
                        <div class="form-group">
                            <label>Views: <span class="badge">{{ $post->views }}</span></label>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Thumbnail</label>
                                    <input type="file" name="thumbnail" accept="image/*">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="thumbnail">
                                        <img src="" width="100%">
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Screenshots</label>
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
                        <hr>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
