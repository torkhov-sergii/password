
@if($type == '9')
    <div class="block-news">
        <div class="block-news__title">{{ trans('messages.main.news') }}</div>
        <div class="block-news__news-wrapper">
            @foreach($items as $item)
                <a href="{{ route('news.view', $item->slug) }}" class="block-news-item">
                    <div class="block-news-item__image" style="background-image: url('{{ $item->previewCache(['w'=>640, 'h'=>480, 'scale'=>'min', 'type'=>'', 'default'=>'no_image2']) }}')"></div>
                    <div class="block-news-item__data">
                        <div class="block-news-item__date">{{ $item->getDate() }}</div>
                        <div class="block-news-item__preview">{{ $item->name }}</div>
                    </div>
                </a>
            @endforeach
        </div>
        <a class="block-news__link" href="{{ route('news') }}">{{ trans('messages.main.news-archive') }}</a>
    </div>
@endif

@if($type == '22')
    <div class="block-news block-news_laws">
        <div class="block-news__title">
            <img src="/images/MERT-logo.png" class="img-fluid">
        </div>
        <div class="block-news__news-wrapper">
            @foreach($items as $item)
                <a href="{{ route('news-mert.view', $item->slug) }}" class="block-news-item">
                    <div class="block-news-item__data">
                        <div class="block-news-item__date">{{ $item->getDate() }}</div>
                        <div class="block-news-item__preview">{{ $item->name }}</div>
                    </div>
                </a>
            @endforeach
        </div>
        <a class="block-news__link" href="{{ route('news-mert') }}">{{ trans('messages.main.news-mert-archive') }}</a>
    </div>
@endif