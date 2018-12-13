<header class="header">
    <div class="container">
        <div class="navigation-bar">

            <a href='/' class="navigation-bar-logo-panel">
                <img src="/images/logo.png" class="navigation-bar-logo-panel__image">
                <div class="navigation-bar-logo-panel__title">
                    <span>PROZORRO <span>інфобокс</span></span>
                    <span class="navigation-bar-logo-panel__title-desc">інформація про систему</span>
                </div>
            </a>

            <div class="navigation-bar-menu">
                {{--<a href="#" class="navigation-bar-menu__link navigation-bar-menu__link_login"><i class="fa fa-user-circle"></i> Вхід</a>--}}
                <a href="http://specifications.prozorro.org/specifications" class="navigation-bar-menu__link">{{ trans('messages.menu.specifications') }}</a>
                <a href="{{ route('articles') }}" class="navigation-bar-menu__link {{ Helpers::areActiveRoutes(['articles','articles.view']) }}">{{ trans('messages.menu.articles') }}</a>
                <a href="{{ route('news') }}" class="navigation-bar-menu__link {{ Helpers::areActiveRoutes(['news','news.view']) }}">{{ trans('messages.menu.news') }}</a>
                <a href="{{ route('news-mert') }}" class="navigation-bar-menu__link {{ Helpers::areActiveRoutes(['news-mert','news-mert.view']) }}">{{ trans('messages.menu.news-mert') }}</a>
                <a href="{{ route('faq') }}" class="navigation-bar-menu__link {{ Helpers::areActiveRoutes(['faq']) }}">{{ trans('messages.menu.faq') }}</a>
                <a href="{{ route('courses') }}" class="navigation-bar-menu__link {{ Helpers::areActiveRoutes(['courses']) }}">{{ trans('messages.menu.courses') }}</a>
                <a href="http://edubox.prozorro.org/forum" target="_blank" class="navigation-bar-menu__link">{{ trans('messages.menu.forum') }}</a>
                {{--<a href="#" class="navigation-bar-menu__link">Контакти</a>--}}
            </div>

            <a class="navigaton-bar-button navigaton-bar-button_x">
                <div class="navigaton-bar-button__icon"></div>
            </a>

            {{--<a href="http://edubox.prozorro.org/" class="navigation-bar-login">вхід</a>--}}
        </div>
    </div>
</header>

