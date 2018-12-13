<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/i/admin/favicon.png" />
	<title>Equilibrium CMS</title>

    <link rel="stylesheet" href="{{ mix('/css/admin/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/app.css') }}">

	<meta name="csrf-token" content="{{ csrf_token() }}">

    @if (count(config('app.locales'))>1)
        <input type="hidden" name="active-language" id="active-language" value="{{ \App::getLocale() }}"/>
    @endif

	@if(env('GOOGLE_API_KEY'))
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&language=en&key={{ env('GOOGLE_API_KEY') }}"></script>
	@endif

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body class="@if (Auth::guest()) page-guest @endif m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<div class="m-grid m-grid--hor m-grid--root m-page">
		@if (Auth::user())
			@include('admin.header')

			@include('admin.content')

			@include('admin.footer')
		@else
			@yield('content')
		@endif
	</div>

	<!-- begin::Scroll Top -->
	<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
		<i class="la la-arrow-up"></i>
	</div>

    <script defer src="{{ mix('/js/admin/app.js') }}"></script>
</body>
</html>
