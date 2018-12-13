@extends('admin/layout')

@section('page_title', trans('admin.backup.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="la la-cloud-download"></i> {{ trans('admin.backup.title') }}
    </div>
@stop

@section('content')
    @if(isset($message))
        {!! $message !!}
    @endif

    <a href="{{ route('admin.files.create') }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" style="margin-right: 20px;"> <i class="la la-plus"></i>
        {{ trans('admin.backup.create-files-backup') }}
    </a>

    <a href="{{ route('admin.bd.create') }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air"> <i class="la la-plus"></i>
        {{ trans('admin.backup.create-bd-backup') }}
    </a>
@stop