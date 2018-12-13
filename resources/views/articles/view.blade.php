@extends('layout')

@section('content')

    <section class="p-article">

        <div class="page-block" data-av-animation="fadeInUp">
            <subscribe-header></subscribe-header>
        </div>

        <div class="page-block page-block_shadow" data-av-animation="fadeInUp">

            <main>
                <div class="content">

                    <items-component type="articles" v-bind:initial-show="false"></items-component>

                    <article-component inline-template>
                        <div class="block-article">

                            <div class="article__image">
                                @if($item->user)
                                    <img class="img-fluid" src="{{ $item->user->previewCache(['w'=>300, 'h'=>300, 'scale'=>'max', 'type'=>'', 'default'=>'no_image2']) }}">
                                @endif
                            </div>

                            <div class="article__body">
                                <div class="body__head">
                                    <div class="head__info">
                                        <h1 class="info__title">
                                            {{ $item->name }}
                                        </h1>
                                        <div class="info__subtitle">
                                            @if($item->user)
                                                <span v-on:click="selected_author = {{ $item->user }}" class="subtitle__author">{{ $item->user->full_name }}</span>
                                                <span class="subtitle__date">{{ $item->getDate('d.m.Y') }}</span>
                                            @else
                                                {{ trans('messages.author-not-found') }}
                                            @endif
                                        </div>

                                        @if($item->tags)
                                            <div class="info__tags">
                                                @foreach($item->tags as $tag)
                                                    <span class="tags__item" v-on:click="selected_tag = {'id': {{ $tag->id }}, 'name': '{{ addslashes($tag->name) }}'}">{{ $tag->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <a href="javaScript:window.print();" class="info__print">{!! trans('messages.button.print') !!}</a>
                                    </div>
                                </div>

                                @if($item->string1)
                                    <div class="body__caption">
                                        {!! $item->string1 !!}
                                    </div>
                                @endif

                                <div class="body__text">

                                    {!! Helpers::youtubeLinkToVideo($item->text) !!}

                                </div>

                                @include('block.body_pdf')

                                @include('block.body_files')

                                @widget('more_articles', ['item' => $item])

                            </div>

                        </div>
                    </article-component>

                </div>

                <filters-component type="articles" base-url="{{ URL::current() }}"></filters-component>

            </main>

        </div>

        <div class="page-block page-block_shadow block-start m-customer">
            <div class="container">
                @widget('start-side', ['type' => 'customer_big'])

                @include('block.subscribe')
            </div>
        </div>

        <div class="page-block page-block_flex page-block_shadow">
            @include('block.help')
        </div>

    </section>

@stop