<div class="article__interesting">
    <div class="interesting__title">
        <span>Цiкаве на ту саму тему</span>
    </div>

    <div class="interesting__wrapper">
        @foreach($interesting_items as $item)
            <div class="interesting__item">

                <div class="item__image">
                    <a href="{{ route('articles.view', $item->slug) }}">
                        <img class="image__main" src="{{ $item->previewCache(['w'=>640, 'h'=>480, 'scale'=>'min', 'type'=>'', 'default'=>'no_image_green']) }}">
                    </a>
                </div>

                <a href="{{ route('articles.view', $item->slug) }}" class="item__title">
                    {{ $item->name }}
                </a>

                <div class="item__date">
                    {{ $item->getDate('d.m.Y') }}
                </div>

            </div>
        @endforeach
    </div>
</div>
