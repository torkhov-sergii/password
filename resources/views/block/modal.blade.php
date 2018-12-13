<div class="modal m-subscription">
    <div class="modal__dialog">
        <div class="dialog__container">
            <div class="modal__close">✖</div>

            <div class="form-content">
                <div class="form-content-first">
                    <div class="modal__title">{{ trans('messages.subscribe.title') }}</div>
                    <div class="modal__description">{{ trans('messages.subscribe.caption') }}</div>

                    {!! Form::open(['method' => 'POST', 'role' => 'form', 'class' => 'form-help form_ajax', 'data-url' => '/api/subscribe', 'data-renew' => 1]) !!}

                    <input type="hidden" name="email" class="input_email">

                    <div class="modal__options">
                        <div class="option__item">
                            <label class="item__description">
                                <input name="customer" type="checkbox" checked value="1">
                                <div class="blue">{{ trans('messages.subscribe.zamovniki') }}</div>
                                <div>{{ trans('messages.subscribe.zamovniki-text') }}</div>
                            </label>
                        </div>
                        <div class="option__item">
                            <label class="item__description">
                                <input name="users" type="checkbox" checked value="1">
                                <div class="green">{{ trans('messages.subscribe.uchasniki') }}</div>
                                <div>{{ trans('messages.subscribe.uchasniki-text') }}</div>
                            </label>
                        </div>
                        <div class="option__item">
                            <label class="item__description">
                                <input name="press" type="checkbox" checked value="1">
                                <div class="orange">{{ trans('messages.subscribe.jurnalist') }}</div>
                                <div>{{ trans('messages.subscribe.jurnalist-text') }}</div>
                            </label>
                        </div>
                    </div>

                    <button class="form-subscribe__submit button button_green solid" type='submit'>{{ trans('messages.button.subscribe') }}</button>

                    {!! Form::close() !!}
                </div>

                <div class="form-content-last">
                    <div class="message">
                        Дякуємо за підписку на розсилку від Прозорро
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-window_image-zoom">
    <div class="modal__dialog">
        <div class="dialog__container">
            <div class="modal__close">✖</div>
            <div class="modal-window__image-zoom">
                <img class="modal-window_image" src="">
            </div>
        </div>
    </div>
</div>