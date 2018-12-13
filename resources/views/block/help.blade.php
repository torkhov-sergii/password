<div class="block-help">
    <div class="help__text">
        {!! trans('messages.help.ne_zmogli') !!}
        {{--<div>{{ trans('messages.help.phone') }}</div>--}}
        {{--{{ trans('messages.help.or') }}--}}
        <img src="/images/help-girl.png">
    </div>

    <div class="form-content">
        <div class="form-content-first">
            {!! Form::open(['method' => 'POST', 'role' => 'form', 'class' => 'form-help form_ajax', 'data-url' => '/api/feedback', 'data-renew' => 1]) !!}

            <div class="form-group">
                {!! Form::text('email', '', [
                    'class' => 'form-control',
                    'placeholder' => trans('messages.help.phone'),
                    'data-rule-required' => 'true', 'data-msg-required' => trans('messages.help.required-phone'),
                    'data-rule-email' => 'true', 'data-msg-email' => trans('messages.help.required-valid-email'),
                ]) !!}
            </div>

            <div class="form-group">
                {!! Form::textarea('text', '', [
                    'class' => 'form-control',
                    'placeholder' => trans('messages.help.question'),
                    'data-rule-required' => 'true',
                    'data-msg-required' => trans('messages.help.required-question'),
                ]) !!}
            </div>

            <input type="submit" class="button button_grey" value="{{ trans('messages.button.send') }}">

            {!! Form::close() !!}
        </div>

        <div class="form-content-last">
            <div class="message">
                {!! trans('messages.help.thank') !!}
            </div>
        </div>
    </div>
</div>