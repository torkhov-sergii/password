@extends('layout')

@section('content')
    {{--@include('breadcrumbs', [--}}
        {{--'title'=>'404 Error',--}}
        {{--'breadcrumbs'=>[['/','Home'],[false,'404 Error']]--}}
    {{--])--}}

    <!--=== Content Part ===-->
    {{--<div class="container content">--}}
        {{--<!--Error Block-->--}}
            {{--<div style="padding: 200px 20px; text-align: center">--}}
                {{--<div style="font-size: 50px;">{{ trans('messages.404.title') }}</div>--}}
                {{--<div style="font-size: 30px;">{{ trans('messages.404.subtitle') }}</div>--}}
            {{--</div>--}}
            {{--<span>That’s an error!</span>--}}
            {{--<p>The requested URL was not found on this server. That’s all we know.</p>--}}
            {{--<a class="btn-u btn-bordered" href="/">Back Home</a>--}}
        {{--<!--End Error Block-->--}}
    {{--</div>--}}
    <!--=== End Content Part ===-->

    <div class="p__p404">
        <div class="p404-w">
            <div class="p404__title">
                {{ trans('messages.404.title') }}
            </div>
            <div class="p404__subtitle">
                {{ trans('messages.404.subtitle') }}
            </div>
            <div class="p404__description">
                {!! trans('messages.404.description') !!}
            </div>
        </div>
    </div>
@stop