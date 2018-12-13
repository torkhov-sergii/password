@extends('admin.layout')

@section('page_title', trans('admin.user.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        {{ trans('admin.user.title-list') }}
    </div>

    <div class="m-portlet__head-tools">
        <a href="{{ route('admin.user.create') }}" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air">
            <i class="la la-plus"></i>
            {{ trans('admin.user.create') }}
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <table class="table_sort table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ trans('admin.user.login') }}</th>
                <th>{{ trans('admin.base.name') }}</th>
                <th>{{ trans('admin.user.email') }}</th>
                <th>{{ trans('admin.user.role') }}</th>
                <th class="text-right">{{ trans('admin.base.option') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td class="bold">
                        {{$user->login}}
                    </td>
                    <td>
                        {{$user->surname}} {{$user->name}}
                    </td>
                    <td class="bold">
                        {{$user->email}}
                    </td>
                    <td>
                        {{ $user->getRole('name') }}
                    </td>

                    <td class="text-right">
                        @role('superadmin')
                            @if(Auth::user()->id != $user->id)
                                <a class="btn btn-warning m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ route('user.login_as', $user->id) }}"><i class="fa fa-sign-in"></i> {{ trans('admin.user.login-as') }}</a>
                            @endif
                        @endrole

                        <a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-pencil"></i> {{ trans('admin.user.view') }}</a>&nbsp;
                        {{--<a class="btn btn-warning btn-xs " href="{{ route('admin.user.edit', $user->id) }}">{{ trans('admin.base.edit') }}</a>--}}

                        @if($user->id != 2)
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" type="submit"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop