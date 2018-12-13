@extends('admin.layout')

@section('page_title', trans('admin.comments.title'))

@section('content')
    <div class="p-comments">
        @yield('comment_content')
    </div>
@stop