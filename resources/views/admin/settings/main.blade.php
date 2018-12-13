@extends('admin.layout')

@section('page_title', trans('admin.settings.title'))

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="la la-gear"></i> {{ trans('admin.settings.title') }}
    </div>
@stop

@section('content')
    {!! Form::open(array('url' => route('admin.settings.update', 0), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal form-bordered', 'files' => false)) !!}
    <input type="hidden" name="_method" value="PUT">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>{{ trans('admin.settings.global') }}</h4>
        </div>

        <div class="panel-body">
            <div class="form-group">
                <label for="name" class="control-label">{{ trans('admin.settings.email') }}</label>
                {!! Form::text('global_settings_email', Settings::get('global_settings_email'), array('class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <label for="name" class="control-label">{{ trans('admin.settings.code') }}</label>
                {!! Form::textarea('global_settings_analytics', Settings::get('global_settings_analytics'), array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>{{ trans('admin.settings.social') }}</h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="control-label">VK (VKontakte link to the page)</label>
                        {!! Form::text('global_settings_vk_url', Settings::get('global_settings_vk_url'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Facebook (link to the Facebook page)</label>
                        {!! Form::text('global_settings_facebook_url', Settings::get('global_settings_facebook_url'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Twitter (link to the Twitter page)</label>
                        {!! Form::text('global_settings_twitter_url', Settings::get('global_settings_twitter_url'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Google+ (link to the Google+ page)</label>
                        {!! Form::text('global_settings_google_plus', Settings::get('global_settings_google_plus'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Linkedin (link to the Linkedin page)</label>
                        {!! Form::text('global_settings_linkedin', Settings::get('global_settings_linkedin'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Pinterest (link to the Pinterest page)</label>
                        {!! Form::text('global_settings_pinterest', Settings::get('global_settings_pinterest'), array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m-form__actions">
        <button class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air" type="submit" >{{ trans('admin.base.save') }}</button>
        <a class="btn btn-link pull-right" href="{{ route('admin.index') }}"><i class="fa fa-arrow-left"></i>  {{ trans('admin.base.back') }}</a>
    </div>
    {!! Form::close() !!}
@stop