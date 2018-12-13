@extends('admin.layout')

@section('page_title', trans('admin.user.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="fa fa-pencil"></i> {{ trans('admin.user.title-edit') }}
    </div>
@stop

@section('content')
    @include('admin.user.block.profile')
@stop