<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{ \App::getLocale() }}" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="{{ \App::getLocale() }}" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="{{ \App::getLocale() }}"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('vendor.seo.seo_meta')

    @if (count(config('app.locales'))>1)
        <input type="hidden" name="active-language" id="active-language" value="{{ \App::getLocale() }}"/>
    @endif

    {{--<style>--}}
        {{--{{ file_exists(base_path().'/public/css/critical.css') ? include(base_path().'/public/css/critical.css') : '' }} --}}{{--inline include critical css for google page speed--}}
    {{--</style>--}}

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/vendor.css') }}">

    {!! Settings::get('global_settings_analytics') !!}
</head>

<body>
    @include('header')

    @include('content')

    @include('footer')

    @include('block.modal')

    <script src="/js/lang.js"></script>
    <script defer src="{{ mix('/js/app.js') }}"></script>
</body>
</html>