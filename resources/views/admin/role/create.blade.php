@extends('admin.layout')

@section('page_title', trans('admin.role.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-plus"></i> {{ trans('admin.role.title-create') }}
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.role.store'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}

    <div class="form-body">
        <div class="form-group">
            <label for="name" class="control-label col-md-2">{{ trans('admin.role.role-name') }}</label>
            <div class="col-md-7">
                {!! Form::text('name', '', array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="m-form__actions">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.create') }}</button>
            <a class="btn btn-link pull-right" href="{{ route('admin.role.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
        </div>
    </div>

    {!! Form::close() !!}
@endsection