@extends('admin/layout')

@section('page_title', trans('admin.dashboard.title'))

@section('content_empty')
    <div class="p-welcome m-portlet">
        <div class="m-portlet__body">
            <div class="welcome__logo">
                <img src="/i/admin/logo.png" class="img-fluid" style="width: 100px;">
            </div>

            <div class="welcome__welcome">{{ trans('admin.dashboard.welcome') }}</div>
            <div class="welcome__title">{{ env('APP_NAME') }}</div>
            <div class="welcome__url">{{ env('APP_URL') }}</div>
        </div>
    </div>
@stop