@extends('layout')

@section('content')

    <div class="page-block page-block_shadow" data-av-animation="fadeInUp">

        <div class="container">

            <section class="p-course">

                <div class="course__item">

                    <h1 class="item__title">{{ $item->name }}</h1>

                    <div class="item__wrapper">
                        <div class="item__body">
                            <div class="body__image">
                                <img src="{{ $item->previewCache(['w'=>160, 'h'=>120, 'scale'=>'min', 'type'=>'', 'default'=>'no_image2']) }}">
                            </div>
                            <div class="body__text">
                                {!! $item->text !!}
                            </div>
                        </div>

                        <div class="item__info">
                            <div class="info__details">
                                @if($item->select1)
                                    <p><strong>{{ trans('messages.courses.for_whom') }}: </strong>{{ Helpers::courses_for_whom_options($item->select1) }}</p>
                                @endif
                                <p><strong>{{ trans('messages.courses.length') }}: </strong>{{ $item->string2 }}</p>
                                <p><strong>{{ trans('messages.courses.step') }}: </strong>{{ $item->string3 }}%</p>
                                @if($item->select2)
                                    <p><strong>{{ trans('messages.courses.result') }}: </strong>{{ Helpers::courses_result_options($item->select2) }}</p>
                                @endif
                            </div>

                            <a href="http://edubox.prozorro.org/" target="_blank" class="info__submit button button_green solid" type='button'>{{ trans('messages.button.register') }}</a>
                        </div>
                    </div>

                </div>

            </section>

        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @widget('courses', ['type'=>'course_item'])
        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @include('block.help')
        </div>

    </div>


@stop