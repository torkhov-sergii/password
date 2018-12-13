<div id="block-subscribe" class="block-subscribe">
    <div class="block-subscribe__wrapper">
        <div class="block-subscribe__title">{{ trans('messages.block-subscribe.title') }}</div>
        <div class="block-subscribe__text">
            {{ trans('messages.block-subscribe.caption') }}
        </div>
        <form id="email-subscribe" class="form-subscribe" action="" method="get">

            {!! Form::text('email', '', array(
                'placeholder' => trans('messages.block-subscribe.email'),
                'class' => 'form-subscribe__input',
                'data-rule-required' => 'true', 'data-msg-required' => trans('messages.block-subscribe.required-email'),
                'data-rule-email' => 'true', 'data-msg-email' => trans('messages.block-subscribe.valid-email'),
            )) !!}

            <button class="form-subscribe__submit button button_orange" type='submit'>{{ trans('messages.button.subscribe') }}</button>
        </form>
    </div>
</div>