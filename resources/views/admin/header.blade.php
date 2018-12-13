<header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <span class="m-brand__logo-wrapper" style="color: #e6e6e6; font-size: 22px;">
                            {{ env('SITE_NAME') }}
                        </span>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">

                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel">
                            <a  href="/" class="m-menu__link" target="_blank">
                                <i class="m-menu__link-icon fa fa-external-link"></i>
                                <span class="m-menu__link-text">
                                    {{ trans('admin.header.view-site') }}
                                </span>
                            </a>
                        </li>

                        <!--
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
                            <a  href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-add"></i>
                                <span class="m-menu__link-text">
												Actions
											</span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item  m-menu__item--active"  aria-haspopup="true">
                                        <a  href="../header/actions.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-file"></i>
                                            <span class="m-menu__link-text">
															Create New Post
														</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                        <a  href="../header/actions.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-diagram"></i>
                                            <span class="m-menu__link-title">
															<span class="m-menu__link-wrap">
																<span class="m-menu__link-text">
																	Generate Reports
																</span>
																<span class="m-menu__link-badge">
																	<span class="m-badge m-badge--success">
																		2
																	</span>
																</span>
															</span>
														</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item  m-menu__item--submenu"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true">
                                        <a  href="#" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-business"></i>
                                            <span class="m-menu__link-text">
															Manage Orders
														</span>
                                            <i class="m-menu__hor-arrow la la-angle-right"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                            <span class="m-menu__arrow "></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Latest Orders
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Pending Orders
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Processed Orders
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Delivery Reports
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Payments
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Customers
																	</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item  m-menu__item--submenu"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true">
                                        <a  href="#" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-chat-1"></i>
                                            <span class="m-menu__link-text">
															Customer Feedbacks
														</span>
                                            <i class="m-menu__hor-arrow la la-angle-right"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                            <span class="m-menu__arrow "></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Customer Feedbacks
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Supplier Feedbacks
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Reviewed Feedbacks
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Resolved Feedbacks
																	</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                                    <a  href="../header/actions.html" class="m-menu__link ">
																	<span class="m-menu__link-text">
																		Feedback Reports
																	</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                        <a  href="../header/actions.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-users"></i>
                                            <span class="m-menu__link-text">
															Register Member
														</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        -->

                        @if(count($langs)>1)
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
                            <a  href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon fa fa-globe"></i>
                                <span class="m-menu__link-text">
                                    {{ $lang_active_name }}
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    @foreach($langs as $lang_code=>$lang_name)
                                        <li class="m-menu__item  @if($lang_code == $lang_active) m-menu__item--active @endif"  aria-haspopup="true">
                                            <a  href="{{ \Helpers::buildLangRoute($lang_code) }}" class="m-menu__link ">
                                                <i class="m-menu__link-icon la la-angle-right"></i>
                                                <span class="m-menu__link-text">
                                                    {{ $lang_name }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif

                    </ul>
                </div>
                <!-- END: Horizontal Menu -->
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            {{--<li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" data-dropdown-toggle="click" data-dropdown-persistent="true" id="m_quicksearch" data-search-type="dropdown">--}}
                                {{--<a href="#" class="m-nav__link m-dropdown__toggle">--}}
                                    {{--<span class="m-nav__link-icon">--}}
                                        {{--<i class="flaticon-search-1"></i>--}}
                                    {{--</span>--}}
                                {{--</a>--}}
                                {{--<div class="m-dropdown__wrapper">--}}
                                    {{--<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>--}}
                                    {{--<div class="m-dropdown__inner ">--}}
                                        {{--<div class="m-dropdown__header">--}}
                                            {{--<form  class="m-list-search__form">--}}
                                                {{--<div class="m-list-search__form-wrapper">--}}
                                                    {{--<span class="m-list-search__form-input-wrapper">--}}
                                                        {{--<input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="Search...">--}}
                                                    {{--</span>--}}
                                                    {{--<span class="m-list-search__form-icon-close" id="m_quicksearch_close">--}}
                                                        {{--<i class="la la-remove"></i>--}}
                                                    {{--</span>--}}
                                                {{--</div>--}}
                                            {{--</form>--}}
                                        {{--</div>--}}
                                        {{--<div class="m-dropdown__body">--}}
                                            {{--<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-max-height="300" data-mobile-max-height="200">--}}
                                                {{--<div class="m-dropdown__content"></div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                            @if (Auth::user())
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic" style="padding-right: 10px;">
                                        <img src="{{ Auth::user()->previewCache(['w'=>40, 'h'=>40, 'scale'=>'crop', 'type'=>'', 'default'=>'no_avatar']) }}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                    </span>
                                    <span class="m-topbar__username">
                                        <span class="m-link" style="color: #716aca">
                                            <b>
                                                @if(Auth::user()->name){{ Auth::user()->fullname() }}@else{{ Auth::user()->email }}@endif
                                            </b>
                                        </span>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center" style="background-color: #7b4fda; background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="{{ Auth::user()->previewCache(['w'=>40, 'h'=>40, 'scale'=>'crop', 'type'=>'', 'default'=>'no_avatar']) }}" class="m--img-rounded m--marginless" alt=""/>
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">
                                                        {{ Auth::user()->fullname() }}
                                                    </span>
                                                    <div href="" class="m-card-user__email m--font-weight-300 m-link2" style="color: #9097d6">
                                                        ({{ Auth::user()->getRole('name') }})
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">
                                                            Section
                                                        </span>
                                                    </li>
                                                    @permission('user')
                                                    <li class="m-nav__item {{ Helpers::areActiveRoutes(['user.profile']) }}">
                                                        <a href="{{ route('admin.user.profile') }}" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">
                                                                        {{ trans('admin.user.my-profile') }}
                                                                    </span>
                                                                    {{--<span class="m-nav__link-badge">--}}
                                                                        {{--<span class="m-badge m-badge--success">--}}
                                                                            {{--2--}}
                                                                        {{--</span>--}}
                                                                    {{--</span>--}}
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    @endpermission

                                                    <li class="m-nav__separator m-nav__separator--fit"></li>

                                                    <li class="m-nav__item">
                                                        <a href="{{ url('logout') }}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                            {{ trans('admin.user.logout') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif

                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>