@foreach($items as $item)
    <div class="articles__item animated fadeInLeft">

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
                <span class="subtitle__category">{{ trans('messages.news.title') }}</span>

                <span class="subtitle__date">
                    {{ $item->getDate('d.m.Y') }}
                </span>
            </div>

            <div class="body__annotation">
                {{ Helpers::catString($item->text, 700, '...') }}
            </div>
        </div>

    </div>
@endforeach