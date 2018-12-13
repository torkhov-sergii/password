@extends('admin.main.layout')

@section('page_title', trans('admin.main.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-folder-open"></i> {{ $category->name }}
    </div>

    <div class="m-portlet__head-tools">
        @if($category->type->isSort || (Auth::user()->hasRole('superadmin')))
            <span style="display: inline-block; margin-right: 10px;">
                <a href="{{ route('main.sort', [$category->id, 'up']) }}" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air"><i class="fa fa-arrow-up"></i></a>
                <a href="{{ route('main.sort', [$category->id, 'down']) }}" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air"><i class="fa fa-arrow-down"></i></a>
            </span>
        @endif

        @if($category->type->isSub)
            <a href="{{ route('admin.main.create', [$category->id,$category->type->id]) }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air"><i class="la la-plus"></i> {{ trans('admin.main.add-sub') }} ({{ $category->type->name }})</a>
        @endif

        @if($category && $category->type)
            @foreach($category->type->children()->get() as $type)
                @if($type['isAdd'])
                    <a class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" href="{{ route('admin.main.create', [$category['id'], $type['id']]) }}"><i class="la la-plus"></i> {{ trans('admin.main.add-new') }} ({{ $type['name'] }})</a>&nbsp;
                @endif
            @endforeach
        @endif

        @if($category->type->isEdit)
            <a href="{{ route('admin.main.edit', [$category->id, 'selected_category'=>$category->id]) }}" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air"><i class="fa fa-pencil"></i> {{ trans('admin.base.edit') }}</a>
        @endif
    </div>
@stop

@section('main_content')
    <table class="main_server_side table table-striped table-hover table-bordered" data-category="{{ $category->id }}" data-url="{{ route('admin.main.server-side') }}">
        <thead>
        <tr>
            <th>ID</th>
            <th>{{ trans('admin.base.title') }}</th>
            <th>{{ trans('admin.base.created') }}</th>
            <th>{{ trans('admin.base.user') }}</th>
            <th>{{ trans('admin.base.status') }}</th>
            <th class="text-right text-nowrap">{{ trans('admin.base.option') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop
