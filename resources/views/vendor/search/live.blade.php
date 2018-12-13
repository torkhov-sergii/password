{{--@extends('layout')--}}

{{--@section('content')--}}
    {{--@include('breadcrumbs', [--}}
        {{--'title'=> trans('messages.search_results') . ': <b>'. $slug.'</b>',--}}
        {{--'breadcrumbs'=>[['/', trans('messages.home')],[false, trans('messages.search_results')]]--}}
    {{--])--}}

    {{--<div class="p-search @if(!$search_string) m-empty @endif">--}}

        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col offset-md-1 col-md-8">--}}

                    {{--<h2>{{ trans('messages.search_again') }}</h2>--}}

                    {{--@if(isset($search_string))--}}
                        {{--@include('vendor.search.form_search', ['slug'=>$search_string, 'count'=>$count])--}}
                    {{--@else--}}
                        {{--@include('vendor.search.form_search', ['slug'=>'Enter your text', 'count'=>$count])--}}
                    {{--@endif--}}

                    {{--<div class="search__result">--}}
                        {{--@if($count > 0)--}}
                            {{--<span class="results-number">{{ trans('messages.about_results', ['count' => $count]) }}</span>--}}
                        {{--@endif--}}

                        @forelse($items as $item)
                            <a href="{{ $item->url }}" class="item">
                                <div class="item__title">
                                     {!! $item->name !!}
                                </div>
                                <div class="item__subtitle">
                                    <span class="subtitle__category">{{ $item->category }}</span>

                                    <span class="subtitle__date">
                                        {{ $item->getDate('d.m.Y') }}
                                    </span>
                                </div>
                                <div class="item__description">
                                    {!! $item->text !!}
                                </div>
                            </a>

                            {{--<ul class="list-inline down-ul">--}}
                                {{--<li>--}}
                                    {{--{{ Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}--}}
                                    {{--@if($item->user['name'])- By {{ $item->user['name'] }} {{ $item->user['surname'] }}@endif--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        @empty
                            <div class="result__empty">
                                За вашим запитом нічого не знайдено
                            </div>
                        @endforelse
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}

{{--@stop--}}



