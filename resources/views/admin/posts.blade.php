@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
            <div class="col-sm-12">
            <div class="well">
                @include('error')
                <form action="/admin/posts" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <post-title-input title="{{ old('title') }}"></post-title-input>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success">add</button>
                        </span>
                    </div>
                </form>
            </div>
            <search-post-bar></search-post-bar>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>Title</th><th>Views</th><th></th></tr>
                    </thead>
                    <tbody>                  
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <a href="/admin/posts/{{ $post->slug }}/edit">{{ $post->title }}
                                    </a>
                                </td>
                                <td>{{ $post->views }}</td>
                                <td>@include('admin.deletePostBtn')</td>
                            </tr>
                        @endforeach
                    </tbody>  
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
