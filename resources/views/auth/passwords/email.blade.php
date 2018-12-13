@extends('auth/layout')

@section('auth_content')
    <div class="m-login__forget-password">
        <div class="m-login__head">
            <h3 class="m-login__title">
                Forgotten Password ?
            </h3>
            <div class="m-login__desc">
                Enter your email to reset your password:
            </div>
        </div>
        {!! Form::open(array('url' => route('password.email'), 'method' => 'post', 'role' => 'form', 'class' => 'form_validate m-login__form m-form', 'files' => false)) !!}

            @include('errors.form_request')

            <div class="form-group m-form__group">
                {!! Form::text('email', old('email'), array(
                  'id' => 'm_email',
                  'placeholder' => 'Your Email',
                  'class' => 'form-control m-input',
                  'data-rule-required' => 'true', 'data-msg-required' => 'Enter email',
                  'data-rule-email' => 'true', 'data-msg-required' => 'Enter valid email',
                  //'autocomplete' => 'off'
                )) !!}
            </div>
            <div class="m-login__form-action">
                <button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr">
                    Restore password
                </button>
                &nbsp;&nbsp;
                <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">
                    Cancel
                </button>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
