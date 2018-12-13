<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <!-- BEGIN: Left Aside -->
    <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
        <i class="la la-close"></i>
    </button>

    @include('admin.sidebar')

    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        @if($__env->yieldContent('page_title'))
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        @yield('page_title')
                    </h3>
                    @widget('Admin.Breadcrumbs')

                    {{--<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">--}}
                        {{--<li class="m-nav__item m-nav__item--home">--}}
                            {{--<a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">--}}
                                {{--<i class="m-nav__link-icon la la-home"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="m-nav__separator">--}}
                            {{-----}}
                        {{--</li>--}}
                        {{--<li class="m-nav__item">--}}
                            {{--<a href="" class="m-nav__link">--}}
                                {{--<span class="m-nav__link-text">--}}
                                    {{--Actions--}}
                                {{--</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                </div>
            </div>
        </div>
        @endif

        <!-- END: Subheader -->
        <div class="m-content">
            @if($__env->yieldContent('content'))
                <div class="m-portlet">
                    @if($__env->yieldContent('page_subtitle'))
                        <div class="m-portlet__head">
                            @yield('page_subtitle')
                        </div>
                    @endif

                    <div class="m-portlet__body">
                        @include('flash::message')

                        @yield('content')
                    </div>
                </div>
            @elseif($__env->yieldContent('content_empty'))
                @yield('content_empty')
            @endif
        </div>
    </div>
</div>
