@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            @include('error')
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/admin/videos" method="POST" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                        <sync-title-slug title="{{ old('title') }}" slug="{{ old('slug') }}"></sync-title-slug>
                        <div class="form-group">
                            <label>Thumbnail</label>
                            <input type="file" name="thumbnail" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>Screenshots</label>
                            <input type="file" name="screenshots[]" accept="image/*" multiple>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
