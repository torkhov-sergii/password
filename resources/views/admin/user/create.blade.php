@extends('admin.layout')

@section('page_title', trans('admin.user.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-plus"></i> {{ trans('admin.user.title-create') }}
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route( 'admin.user.store'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => true)) !!}
    @include('errors.form_request')

    <div class="form-body">
        <div class="form-group">
            <label for="login" class="control-label col-md-2">{{ trans('admin.user.name') }}</label>
            <div class="col-md-3">
                {!! Form::text('name', '', array(
                    'class' => 'form-control',
                )) !!}
            </div>
        </div>

        <div class="form-group">
            <label for="login" class="control-label col-md-2">{{ trans('admin.user.login') }}</label>
            <div class="col-md-7">
                {!! Form::text('login', old('login'), array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">{{ trans('admin.user.email') }}</label>
            <div class="col-md-7">
                {!! Form::text('email', old('email'), array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Password</label>
            <div class="col-md-7">
                {!! Form::password('password', array(
                      'id' => 'input_password',
                      'class' => 'form-control',
                  )) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Confirm password</label>
            <div class="col-md-7">
                {!! Form::password('password_confirmation', array(
                      'class' => 'form-control',
                  )) !!}
            </div>
        </div>
    </div>

    <div class="m-form__actions">
        <button type="submit" class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air">{{ trans('admin.base.create') }}</button>
        <a class="btn btn-link pull-right" href="{{ route('admin.user.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
    </div>

    {!! Form::close() !!}
@endsection