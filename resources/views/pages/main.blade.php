@extends('layout')

@section('content')

    <section class="p-index">

        <div class="page-block page-block_shadow" data-av-animation="fadeInUp">
            <div class="block-start">
                <img src="/images/center-divider.png" class="start__image-divider">
                @widget('start-side', ['type' => 'customer'])
                @widget('start-side', ['type' => 'participant'])
            </div>
        </div>

        <div class="page-block page-block_shadow" data-av-animation="fadeInUp">
            @include('block.search', ['type'=>'default'])
        </div>

        <div class="page-block page-block_shadow block-infobox-news" data-av-animation="fadeInUp">
            <div class="container">
                <div class="block-infobox">
                    <div class="block-infobox__title">{{ trans('messages.about.title') }}</div>
                    <div class="block-infobox__text">{{ trans('messages.about.description') }}</div>
                    <div class="block-infobox__links">
                        {{--<a class="block-infobox__link" href="#">Про систему Прозорро</a>--}}
                        {{--<a class="block-infobox__link block-infobox__link_special" href="#">Роадмапа проекту</a>--}}
                        <a class="block-infobox__link block-infobox__link_special" href="http://edubox.prozorro.org/forum" target="_blank">{{ trans('messages.forum.title') }}</a>
                    </div>
                </div>

                @widget('News', ['type' => '9'])

                @widget('News', ['type' => '22'])
            </div>
        </div>

        <div class="page-block page-block_shadow block-start m-press">
            <div class="container">
                @widget('start-side', ['type' => 'press'])

                @include('block.subscribe')
            </div>
        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @widget('courses')
        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @include('block.help')
        </div>

    </section>

@stop