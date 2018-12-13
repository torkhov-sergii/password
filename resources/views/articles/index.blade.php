@extends('layout')

@section('content')

    <section class="js-items p-articles" data-type="16">

        <slider-articles-component></slider-articles-component>

        <div class="page-block" data-av-animation="fadeInUp">
            @include('block.search', ['type'=>'article'])
        </div>

        <div class="page-block page-block_shadow" data-av-animation="fadeInUp">

            <main>

                <div class="content">

                    <items-component type="articles"></items-component>

                </div>

                <filters-component type="articles" base-url="{{ url('/') }}"></filters-component>

            </main>

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