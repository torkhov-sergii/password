<div class="article__more">
    <div class="block-articles">
        <div class="articles__title">
            {{ trans('messages.news.title-also') }}:
        </div>

        <div class="articles__list">
        @foreach($items as $item)
            <div class="articles__item">
                <div class="item__image">
                    <a href="{{ route('news.view', $item->slug) }}">
                        <img class="image__main" src="{{ $item->previewCache(['w'=>640, 'h'=>480, 'scale'=>'min', 'type'=>'', 'default'=>'no_image2']) }}">
                    </a>
                </div>

                <div class="item__body">
                    <a href="{{ route('news.view', $item->slug) }}" class="body__title">
                        {{ $item->name }}
                    </a>
                    <div class="info__subtitle">
                        {{--<span class="subtitle__category">Замовнику</span>--}}
                        <span class="subtitle__date">{{ $item->getDate('d.m.Y') }}</span>
                    </div>
                    <div class="body__annotation">
                        {{ $item->string1 }}
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <a href="{{ route('news') }}" class="articles__more-button button button_blue" type='button'>{{ trans('messages.news.more') }}</a>
</div>