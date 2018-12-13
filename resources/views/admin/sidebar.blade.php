<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div
            id="m_ver_menu"
            class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
            data-menu-vertical="true"
            data-menu-scrollable="false" data-menu-dropdown-timeout="100"
    >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

            {{--prozorro--}}
            @if(Auth::user()->can('settings'))
                <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.prozorro.main'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                    <a  href="/admin/prozorro/start-blocks" class="m-menu__link ">
                        <i class="m-menu__link-icon fa fa-home"></i>
                        <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Iнфоблоки
                            </span>
                        </span>
                    </span>
                    </a>
                </li>
            @endif

            @if(isset($categories))
                @foreach($categories as $category)
                    @include('admin.main.block.each_menu', ['category' => $category, 'opened_categories' => $opened_categories, 'selected_category' => $selected_category])
                @endforeach
            @endif

            @permission('comments')
            <li class="nav-item {{ Helpers::areActiveRoutes(['admin.comments.index', 'admin.comments.not_approved']) }}">
                <a href="{{ route('admin.comments.not_approved') }}" class="nav-link">
                    <span class="glyphicon glyphicon-comment"></span>
                    <span class="title">{{ trans('admin.menu.comments') }}</span>
                    @if(!Helpers::areActiveRoutes(['admin.comments.index', 'admin.comments.not_approved']))
                        <span class="badge @if(\App\Models\Comment::notApprovedCommentCount()) badge-danger @endif">{{ \App\Models\Comment::notApprovedCommentCount() }}</span>
                    @endif
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ Helpers::areActiveRoutes(['admin.comments.not_approved']) }}">
                        <a href="{{ route('admin.comments.not_approved') }}" class="nav-link ">
                            <span class="title">{{ trans('admin.menu.comments-not-approved') }}</span>
                            <span class="badge badge-danger">{{ \App\Models\Comment::notApprovedCommentCount() }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Helpers::areActiveRoutes(['admin.comments.index']) }}">
                        <a href="{{ route('admin.comments.index') }}" class="nav-link ">
                            <span class="title">{{ trans('admin.menu.comments-all') }}</span>
                            <span class="selected"></span>
                            <span class="badge badge-default">{{ \App\Models\Comment::totalCommentCount() }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endpermission

            @permission('tags')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.tag.index', 'admin.tag.edit'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.tag.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-tags"></i>
                    <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">
                            {{ trans('admin.menu.tags') }}
                        </span>
                    </span>
                </span>
                </a>
            </li>
            @endpermission

            @if(Auth::user()->can('user') || Auth::user()->can('role'))
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Users
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            @endif

            @permission('user')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.user.index', 'admin.user.edit', 'admin.user.create'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.user.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon la la-user"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                 {{ trans('admin.menu.users') }}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            @permission('role')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.role.index','admin.role.create','admin.role.edit'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.role.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon la 	la-key"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{ trans('admin.menu.role') }}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            @if(Auth::user()->can('seo') || Auth::user()->can('translations') || Auth::user()->can('settings') || Auth::user()->can('type') || Auth::user()->can('backup'))
                <li class="m-menu__section">
                    <h4 class="m-menu__section-text">
                        {{ trans('admin.menu.settings') }}
                    </h4>
                    <i class="m-menu__section-icon flaticon-more-v3"></i>
                </li>
            @endif

            @permission('seo')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.seo.index'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.seo.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{ trans('admin.menu.seo') }}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            @permission('translations')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.translations.view'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.translations.view', 'messages') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-globe"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{ trans('admin.menu.translations') }}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            @permission('settings')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.settings.index'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.settings.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon la la-gear"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{ trans('admin.menu.settings') }}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            @permission('type')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.type.index', 'admin.type.create', 'admin.type.edit'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.type.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon la la-code"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{ trans('admin.menu.type') }}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            @permission('backup')
            <li class="m-menu__item {{ Helpers::areActiveRoutes(['admin.backup.index'], 'm-menu__item--expanded m-menu__item--active') }}" aria-haspopup="true" >
                <a  href="{{ route('admin.backup.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon la la-cloud-download"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                 {{ trans('admin.menu.backup') }}
                            </span>
                            {{--<span class="m-menu__link-badge">--}}
                                {{--<span class="m-badge m-badge--danger">--}}
                                    {{--2--}}
                                {{--</span>--}}
                            {{--</span>--}}
                        </span>
                    </span>
                </a>
            </li>
            @endpermission

            {{--<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
                {{--<a  href="#" class="m-menu__link m-menu__toggle">--}}
                    {{--<i class="m-menu__link-icon flaticon-suitcase"></i>--}}
                    {{--<span class="m-menu__link-text">--}}
                        {{--Custom Pages--}}
                    {{--</span>--}}
                    {{--<i class="m-menu__ver-arrow la la-angle-right"></i>--}}
                {{--</a>--}}
                {{--<div class="m-menu__submenu ">--}}
                    {{--<span class="m-menu__arrow"></span>--}}
                    {{--<ul class="m-menu__subnav">--}}
                        {{--<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >--}}
                            {{--<span class="m-menu__link">--}}
                                {{--<span class="m-menu__link-text">--}}
                                    {{--Custom Pages--}}
                                {{--</span>--}}
                            {{--</span>--}}
                        {{--</li>--}}
                        {{--<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
                            {{--<a  href="#" class="m-menu__link m-menu__toggle">--}}
                                {{--<i class="m-menu__link-bullet m-menu__link-bullet--dot">--}}
                                    {{--<span></span>--}}
                                {{--</i>--}}
                                {{--<span class="m-menu__link-text">--}}
                                    {{--User Pages--}}
                                {{--</span>--}}
                                {{--<i class="m-menu__ver-arrow la la-angle-right"></i>--}}
                            {{--</a>--}}
                            {{--<div class="m-menu__submenu ">--}}
                                {{--<span class="m-menu__arrow"></span>--}}
                                {{--<ul class="m-menu__subnav">--}}
                                    {{--<li class="m-menu__item " aria-haspopup="true" >--}}
                                        {{--<a target="_blank" href="../snippets/pages/user/login-1.html" class="m-menu__link ">--}}
                                            {{--<i class="m-menu__link-bullet m-menu__link-bullet--dot">--}}
                                                {{--<span></span>--}}
                                            {{--</i>--}}
                                            {{--<span class="m-menu__link-text">--}}
                                                {{--Login - 1--}}
                                            {{--</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</li>--}}
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
