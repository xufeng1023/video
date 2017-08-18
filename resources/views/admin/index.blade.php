@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>Title</th><th>Slug</th><th>Link</th><th>Views</th><th></th></tr>
                    </thead>
                    <tbody>                  
                        @foreach($videos as $video)
                            <tr>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->slug }}</td>
                                <td>{{ $video->link }}</td>
                                <td>{{ $video->views }}</td>
                                <td>
                                    <a href="admin/videos/{{ $video->id }}" type="button" class="btn btn-xs btn-default">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <form action="admin/videos/{{ $video->id }}" method="POST" class="pull-right">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>  
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
