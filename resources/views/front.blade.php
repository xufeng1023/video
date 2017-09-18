@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <pay :user="{{ auth()->user() }}"></pay>
    @else
        <a href="/login">login</a>
    @endif
@endsection
