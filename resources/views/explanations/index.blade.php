@extends('layout')

@section('content')

    <section class="p-articles">

        <div class="page-block" data-av-animation="fadeInUp">
            @include('block.search', ['type'=>'article'])
        </div>

        <div class="page-block page-block_shadow" data-av-animation="fadeInUp">

            <main>

                <div class="content">

                    <items-component type="news-mert"></items-component>

                </div>

                <filters-component type="news-mert" base-url="{{ url('/') }}"></filters-component>

            </main>

        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @widget('courses')
        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @include('block.help')
        </div>

    </section>

@stop