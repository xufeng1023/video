@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">
        <h1 class="display-3">Fluid jumbotron22</h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Active</a>
            </li>
        </ul>
        <div class="col-md-12">
            @foreach($posts->chunk(4) as $chunks)
                <div class="row">
                    @foreach($chunks as $post)
                        <div class="col-sm-3">
                            <a href="/movie/{{ $post->slug }}">
                                <img src="{{ asset('/storage/'.$post->images->first()->slug) }}" width="100%">
                                {{ $post->title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
