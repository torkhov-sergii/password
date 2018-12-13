@extends('auth.layout')

@section('auth_content')
    <div class="m-login__signin">
        <div class="m-login__head">
            <h3 class="m-login__title">
                Sign In To Admin
            </h3>
        </div>
        {!! Form::open(array('url' => url(Helpers::buildLangPrefix('url').'login'), 'method' => 'post', 'class' => 'form_validate m-login__form m-form', 'files' => false)) !!}

            @include('errors.form_request')

            @include('flash::message')

            <div class="form-group m-form__group text-center">
                {!! Form::text('email', old('email'), array(
                     'placeholder' => 'Login or Email',
                     'class' => 'form-control m-input',
                     'data-rule-required' => 'true', 'data-msg-required' => 'Enter Login or Email',
                  )) !!}
            </div>

            <div class="form-group m-form__group text-center">
                {!! Form::password('password', array(
                      'placeholder' => 'Password',
                      'class' => 'form-control m-input m-login__form-input--last',
                      'data-rule-required' => 'true', 'data-msg-required2' => '',
                   )) !!}
            </div>

            <div class="row m-login__form-sub">
                <div class="col m--align-left m-login__form-left">
                    <label class="m-checkbox  m-checkbox--focus">
                        <input type="checkbox" name="remember">
                        Remember me
                        <span></span>
                    </label>
                </div>
                <div class="col m--align-right m-login__form-right">
                    <a href="{{ route('password.reset') }}" id="m_login_forget_password" class="m-link">
                        Forget Password ?
                    </a>
                </div>
            </div>

            <div class="m-login__form-action">
                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                    Sign In
                </button>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
