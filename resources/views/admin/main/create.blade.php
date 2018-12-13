@extends('admin.layout')

@section('page_title', trans('admin.main.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-plus"></i> {{ trans('admin.main.title-create') }}
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.main.store'), 'method' => 'post', 'role' => 'form', 'class' => 'form-vertical', 'files' => true)) !!}
        {!! Form::hidden('parent_id', $parent_id) !!}
        {!! Form::hidden('type_id', $type_id) !!}

        <div class="form-group">
            <label for="name" class="control-label">{{ trans('admin.base.name') }}</label>
            {!! Form::text('name', '', array('class' => 'form-control')) !!}
        </div>

        <div class="m-form__actions">
            <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.create') }}</button>
            <a class="btn btn-link pull-right" href="{{ route('admin.main.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('admin.base.back') }}</a>
        </div>

    {!! Form::close() !!}
@endsection