@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <video src="{{ asset('/storage/'.$video->link) }}" controls></video>
        </div>
    </div>
</div>
@endsection
