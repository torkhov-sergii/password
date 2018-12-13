@extends('admin.layout')

@section('page_title', 'Type')

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="la la-code"></i>
        Type / List
    </div>

    <div class="m-portlet__head-tools">
        <a href="{{ route('admin.type.create') }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air">
            <i class="la la-plus"></i>
            {{ trans('admin.base.create') }}
        </a>
    </div>
@stop

@section('content')
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>{{ trans('admin.base.name') }}</th>
            <th class="text-center">Add</th>
            <th class="text-center">{{ trans('admin.base.edit') }}</th>
            <th class="text-center">Del</th>
            <th class="text-center">Seo</th>
            <th class="text-center">Sort</th>
            <th class="text-center">Show</th>
            <th class="text-right">{{ trans('admin.base.option') }}</th>
        </tr>
        </thead>

        <tbody>
            @each('admin.type.block.each_types', $types, 'type')
        </tbody>
    </table>
@stop
