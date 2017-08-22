@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <form action="/admin/posts" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <post-title-input></post-title-input>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success">add</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>Title</th><th>Views</th><th></th></tr>
                    </thead>
                    <tbody>                  
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->views }}</td>
                                <td>
                                    <a href="admin/posts/{{ $post->id }}/edit" type="button" class="btn btn-xs btn-default">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <form action="admin/posts/{{ $post->id }}" method="POST" class="pull-right">
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
