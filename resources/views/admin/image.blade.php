@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <img src="{{ asset('/storage/'.$image->slug) }}" alt="{{ $image->post->title }}">
        </div>
    </div>
</div>
@endsection
