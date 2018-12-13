
@if(env('SITE_SEO') == 'normal')
    {{--класика - в MainController должен быть 'seo'=>true для page--}}
    @if(isset($GLOBALS['meta']['title']))
        <title>{{ $GLOBALS['meta']['title'] }}</title>
        <meta name="description" content="{{ $GLOBALS['meta']['description'] or '' }}" />

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="{{ $GLOBALS['meta']['title'] }}">
        <meta itemprop="description" content="{{ $GLOBALS['meta']['description'] or '' }}">
        <meta itemprop="image" content="{{ $GLOBALS['meta']['image'] or '' }}">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="{{ $GLOBALS['meta']['twitter_site'] or '' }}">
        <meta name="twitter:title" content="{{ $GLOBALS['meta']['title'] or '' }}">
        <meta name="twitter:description" content="{{ $GLOBALS['meta']['description'] or '' }}">
        <meta name="twitter:creator" content="{{ $GLOBALS['meta']['twitter_creator'] or '' }}">
        <meta name="twitter:image:src" content="{{ $GLOBALS['meta']['image'] or '' }}">

        <!-- Open Graph data -->
        <meta property="og:title" content="{{ $GLOBALS['meta']['title'] or '' }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:image" content="{{ $GLOBALS['meta']['image'] or '' }}" />
        <meta property="og:description" content="{{ $GLOBALS['meta']['description'] or '' }}" />
        @if($GLOBALS['meta']['og_site_name'])
            <meta property="og:site_name" content="{{ $GLOBALS['meta']['og_site_name'] or '' }}" />
        @endif
        @if($GLOBALS['meta']['fb_admins'])
            <meta property="fb:admins" content="{{ $GLOBALS['meta']['fb_admins'] or '' }}" />
        @endif
        <meta property="article:published_time" content="{{ $GLOBALS['meta']['published_time'] or '' }}" />
        <meta property="article:section" content="{{ $GLOBALS['meta']['article_section'] or '' }}" />
        @if(isset($GLOBALS['meta']['tags']))
            @foreach($GLOBALS['meta']['tags'] as $tag)
                <meta property="article:tag" content="{{ $tag }}" />
            @endforeach
        @endif
    @else
        {{--если 'seo'=>false--}}
        <title>{{ Settings::get('global_title_'.App::getLocale()) }}</title>
        <meta name="description" content="{{ Settings::get('global_description_'.App::getLocale()) }}" />
    @endif
@elseif(isset($GLOBALS['meta']['seo_meta_tags']))
    {{--для Робина--}}
    {!! $GLOBALS['meta']['seo_meta_tags'] or '' !!}
@endif

<!-- automatically generated meta tags -->
@if(isset($GLOBALS['meta']['alternate']))
    <meta property="article:modified_time" content="{{ $GLOBALS['meta']['modified_time'] or '' }}" />
@endif

@if(isset($GLOBALS['meta']['alternate']))
    @foreach($GLOBALS['meta']['alternate'] as $lang=>$alternate)
        <link rel="alternate" href="{{ $alternate['url'] }}" hreflang="{{ $alternate['hreflang'] }}" />
    @endforeach
@endif
