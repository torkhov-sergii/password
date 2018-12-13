<div class="start__side m-customer-big">
    <div class="side__info">
        <div class="info__title">
            {{ trans('messages.slide.customer') }}
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

    <img src="/images/articles/customer-big.png" class="side__image">
    <img src="/images/speech-bubble-left.png" class="side__bubble">
</div>