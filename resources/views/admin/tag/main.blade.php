@extends('admin.layout')

@section('page_title', trans('admin.tag.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon fa fa-tags"></i> {{ trans('admin.tag.title-list') }}
    </div>
@stop

@section('content')
    <div class="row">
        <table class="table_sort table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ trans('admin.base.name') }}</th>
                <th>Slug</th>
                <th>{{ trans('admin.tag.used-count') }}</th>
                <th class="text-right">{{ trans('admin.base.option') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td class="bold">{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>{{ $tag->post->count() }}</td>
                    <td class="text-right">
                        {{--<a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ route('admin.category.show', $category->id) }}">View</a>--}}
                        <a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs " href="{{ route('admin.tag.edit', $tag->id) }}"><i class="fa fa-pencil"></i> {{ trans('admin.base.edit') }}</a>&nbsp;

                        <form action="{{ route('admin.tag.destroy', $tag->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop