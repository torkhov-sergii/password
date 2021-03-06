<div class="start__side m-press">
    <div class="side__info">
        <div class="info__title">
            {!! trans('messages.slide.press') !!}
        </div>

        {{--{!! $content !!}--}}

        @foreach($data as $key => $item)
            @if($key == 'list')
                <div class="info__links">
                    @foreach($item as $item2)
                        @if($item2['title'])
                            <a href="{{ $item2['url'] }}">{{ $item2['title'] }}</a>
                        @endif
                    @endforeach
                </div>
            @else
                <a href="{{ $item['url'] }}" class="info__question">{{ $item['title'] }}</a>
            @endif
        @endforeach

        <a href="/articles" class="links__more">{{ trans('messages.articles.more-small') }}</a>
    </div>

    <img src="/images/press.png" class="side__image">
    <img src="/images/speech-bubble-left-orange.png" class="side__bubble">
</div>
