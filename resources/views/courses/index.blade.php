@extends('layout')

@section('content')

    <section class="p-courses">

        <div class="page-block page-block_shadow" data-av-animation="fadeInUp">

            <main>

                <div class="content">

                    <div class="block-courses">
                        <div class="courses__title">{{ trans('messages.courses.title') }}</div>

                        <items-component type="courses"></items-component>
                    </div>

                </div>

                <filters-component type="courses" base-url="{{ url('/') }}"></filters-component>

            </main>

        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @include('block.help')
        </div>

    </section>

@stop