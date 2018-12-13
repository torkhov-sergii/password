@extends('auth/layout')

@section('auth_content')
    <div class="m-login__signup">
        <div class="m-login__head">
            <h3 class="m-login__title">
                Sign Up
            </h3>
            <div class="m-login__desc">
                Enter your details to create your account:
            </div>
        </div>
        {!! Form::open(array('url' => route('register.post'), 'method' => 'post', 'role' => 'form', 'class' => 'form_validate m-login__form m-form', 'files' => false)) !!}

            @include('errors.form_request')

            <div class="form-group m-form__group">
                {!! Form::text('name', old('name'), array(
                    'class' => 'form-control m-input',
                    'data-rule-required' => 'true', 'data-msg-required' => 'Your name',
                    'placeholder' => 'Name'
                )) !!}
            </div>

            <div class="form-group m-form__group">
                {!! Form::text('email', old('email'), array(
                    'class' => 'form-control m-input',
                    'data-rule-required' => 'true', 'data-msg-required' => 'Enter email',
                    'data-rule-email' => 'true', 'data-msg-email' => 'Enter valid email',
                    'placeholder' => 'E-Mail'
                )) !!}
            </div>

            <div class="form-group m-form__group">
                {!! Form::password('password', array(
                    'id' => 'input_password',
                    'class' => 'form-control m-input',
                    'data-rule-required' => 'true', 'data-msg-required' => 'Enter password',
                    'data-rule-min' => '6', 'data-msg-min' => 'Minimum password length 6 characters',
                    'placeholder' => 'Password'
                )) !!}
            </div>

            <div class="form-group m-form__group">
                {!! Form::password('password_confirmation', array(
                    'class' => 'form-control m-input',
                    'data-rule-required' => 'true', 'data-msg-required' => 'Confirm password',
                    'data-rule-equalto' => '#input_password', 'data-msg-equalto' => 'Passwords do not match',
                    'placeholder' => 'Confirm password'
                )) !!}
            </div>

            {{--<div class="row form-group m-form__group m-login__form-sub">--}}
                {{--<div class="col m--align-left">--}}
                    {{--<label class="m-checkbox m-checkbox--focus">--}}
                        {{--<input type="checkbox" name="agree">--}}
                        {{--I Agree the--}}
                        {{--<a href="#" class="m-link m-link--focus">--}}
                            {{--terms and conditions--}}
                        {{--</a>--}}
                        {{--.--}}
                        {{--<span></span>--}}
                    {{--</label>--}}
                    {{--<span class="m-form__help"></span>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="m-login__form-action">
                <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
                    Sign Up
                </button>
                &nbsp;&nbsp;
                <button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">
                    Cancel
                </button>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
