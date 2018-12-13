@extends('layout')

@section('content')

    <div class="page-block page-block_shadow" data-av-animation="fadeInUp">

        <div class="container">

            <section class="p-faq">

                <h2 class="faq__title">{{ trans('messages.faq.title') }}</h2>

                <search-component></search-component>

                <div class="faq__wrapper">
                    @foreach($categories as $category)
                        <div class="faq__category">
                            <div class="category__title"><span>{{ $category->name }}</span></div>

                            {{--<faq-component :items="{{ $items }}"></faq-component>--}}

                            <faq-component :items="{{ $category->getRelateByType(28) }}"></faq-component>

                        </div>
                    @endforeach
                </div>

            </section>

        </div>

    </div>

    <div class="page-block page-block_flex page-block_shadow">
        @include('block.help')
    </div>

@stop