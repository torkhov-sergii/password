@extends('admin.layout')

@section('content')
    {{--<div class="container-fluid margin-bottom-100" style="margin-top: 100px;">--}}
        {{--<div class="row">--}}
            {{--<div class="col-sm-12 col-md-8 col-lg-4 col-sm-offset-0 col-md-offset-2 col-lg-offset-4">--}}
                {{--<div class="panel panel-default">--}}
                    {{--@yield('auth_content')--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(/i/admin/bg/bg-3.jpg);">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="/">
                            <img src="/i/admin/logo.png" class="img-fluid" style="width: 100px;">
                        </a>
                    </div>

                    @yield('auth_content')


                    {{--<div class="m-login__account">--}}
							{{--<span class="m-login__account-msg">--}}
								{{--Don't have an account yet ?--}}
							{{--</span>--}}
                        {{--&nbsp;&nbsp;--}}
                        {{--<a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">--}}
                            {{--Sign Up--}}
                        {{--</a>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@stop