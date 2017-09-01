@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">
        <h1 class="display-3">Fluid jumbotron</h1>
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
                        <div class="col">
                            {{ $post->title }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
