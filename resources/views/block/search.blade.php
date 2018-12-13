
<div class="block-search @if($type == 'article') m-article @endif @if($type == 'faq') m-faq @endif">
    <div class="search__title">{{ trans('messages.search.title') }}</div>

    <div class="search__wrapper">
        <div class="search__input-container">
            <input id="search__input" placeholder="{{ trans('messages.search.placeholder') }}">
            <img class="search__icon" src="/images/search-icon.png">
        </div>

        <div class="search__result">
        </div>
    </div>

    @if($type == 'article')
        <div class="search__description">{{ trans('messages.search.naprimer') }}, <span class="search__example">{{ trans('messages.search.example_1') }}</span></div>
    @else
        <div class="search__description">{{ trans('messages.search.example_2') }}</div>
    @endif
</div>



