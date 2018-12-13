@extends('admin.layout')

@section('page_title', trans('admin.role.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-eye-open"></i> {{ trans('admin.role.title-list') }}
    </div>

    <div class="m-portlet__head-tools">
        <a href="{{ route('admin.role.create') }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air">
            <i class="la la-plus"></i>
            {{ trans('admin.role.create-role') }}
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <table class="table_sort table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ trans('admin.base.name') }}</th>
                <th>{{ trans('admin.base.description') }}</th>
                <th class="text-right">{{ trans('admin.base.option') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td class="bold">{{$role->name}}</td>
                    <td>{{$role->description}}</td>
                    <td class="text-right">
                        {{--<a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ route('admin.category.show', $category->id) }}">View</a>--}}
                        <a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs " href="{{ route('admin.role.edit', $role->id) }}"><i class="fa fa-pencil"></i> {{ trans('admin.base.edit') }}</a>&nbsp;

                        @if($role->id != 1 && $role->id != 2)
                            <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop