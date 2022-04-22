<nav class="pcoded-navbar" pcoded-header-position="relative">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header" hidden>
                <a href='{{ url('/') }}'
                   style='background-image: url(@if (\App\Bll\Utility::get_main_settings() != null){{ asset('uploads/settings/site_settings/' . \App\Bll\Utility::get_main_settings()->logo) }} @endif; background-repeat: no-repeat;background-position: 50% 50%;background-size: cover;display:block;width:100%;height:100%'>
                </a>
            </div>
            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="{{ url('admin/profile') }}"><i class="ti-user"></i>{{ _i('View Profile') }}</a>
                        <a href="{{ url('admin/settings') }}"><i class="ti-settings"></i>{{ _i('Settings') }}</a>
                        <a href="{{ route('admin.logout') }}"><i class="ti-layout-sidebar-left"></i>{{ _i('Logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">
            {{ _i('MAIN NAVIGATION') }}</div>
        <ul class="pcoded-item pcoded-left-item">

            @if (auth("admin")->user()->can('Dashboard'))
                <li class="{{ request()->url() == route('admin.home') ? 'active' : '' }}">
                    <a href="{{ route('admin.home') }}">
                        <span class="pcoded-micon"><i class="ti-home"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Dashboard') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @can('Products')
                <li class="{{ request()->url() == route('products.index') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Products') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->url() == route('categories.index') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Products Categories') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                {{--            <li class="{{ request()->url() == route('blogs.index') ? 'active' : '' }}">--}}
                {{--                <a href="{{ route('blogs.index') }}">--}}
                {{--                    <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>--}}
                {{--                    <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Blogs') }}</span>--}}
                {{--                    <span class="pcoded-mcaret"></span>--}}
                {{--                </a>--}}
                {{--            </li>--}}
            @endcan
            @can('Comments')
                <li class="{{ request()->url() == route('reviews.index') ? 'active' : '' }}">
                    <a href="{{ route('reviews.index') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Reviews') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan
            @can('Blog')
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i>
                        <span class="pcoded-micon"><i class="ti-ticket"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default">{{_i('Blogs')}}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">

                        <li class="{{ request()->url() == route('blogs_categories.index') ? 'active' : '' }}">
                            <a href="{{ route('blogs_categories.index') }}">
                                <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                                <span class="pcoded-mtext"
                                      data-i18n="nav.dash.default">{{ _i('Blogs Categories') }}</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->url() == route('blogs.index') ? 'active' : '' }}">
                            <a href="{{ route('blogs.index') }}">
                                <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Blogs') }}</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('Security')
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i>
                        <span class="pcoded-micon"><i class="ti-ticket"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default">{{_i('Security')}}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">

                        <li hidden class="{{ request()->is('admin/permission*') ? 'active' : '' }}">
                            <a href="{{ url('admin/permission') }}">
                                {{-- <i class="fa fa-circle-o"></i> --}}
                                <span class="pcoded-micon"><i class="ti-settings"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Permissions') }}</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/role*') ? 'active' : '' }}">
                            <a href="{{ url('/admin/role') }}">
                                {{-- <i class="fa fa-circle-o"></i> --}}
                                <span class="pcoded-micon"><i class="ti-check-box"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Roles') }}</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/admin*') ? 'active' : '' }}">
                            <a href="{{ url('/admin/admin') }}">
                                {{-- <i class="fa fa-circle-o"></i> --}}
                                <span class="pcoded-micon"><i class="ti-check-box"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Admins') }}</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan


            {{--            <li class=" {{ request()->is('admin/promotors') ? 'active' : '' }}">--}}
            {{--                <a href="{{ url('/admin/promotors') }}">--}}
            {{--                    <span class="pcoded-micon"><i class="ti-shopping-cart"></i></span>--}}
            {{--                    <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Promotors') }}</span>--}}
            {{--                    <span class="pcoded-mcaret"></span>--}}

            {{--                </a>--}}
            {{--            </li>--}}
            {{--            <li class=" {{ request()->is('admin/discounts') || request()->is('admin/discounts/*') ? 'active' : '' }}">--}}
            {{--                <a href="{{ url('/admin/discounts') }}">--}}
            {{--                    <span class="pcoded-micon"><i class="ti-shopping-cart"></i></span>--}}
            {{--                    <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Discounts') }}</span>--}}
            {{--                    <span class="pcoded-mcaret"></span>--}}

            {{--                </a>--}}
            {{--            </li>--}}

            {{--            <li--}}
            {{--                class="{{ request()->is('admin/offers/all') || request()->is('admin/offers/all*') ? 'active' : '' }}">--}}
            {{--                <a href="#">--}}
            {{--                    <span class="pcoded-micon"><i class="ti-layout "></i></span>--}}
            {{--                    <span class="pcoded-mtext" data-i18n="nav.dash.default">{{ _i('Offers') }}</span>--}}
            {{--                </a>--}}
            {{--            </li>--}}

            {{--        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">--}}
            {{--            {{ _i('Products') }}--}}
            {{--        </div>--}}

            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">
                {{ _i('Setting') }}</div>
            <ul class="pcoded-item pcoded-left-item">
                <li
                    class=" {{ request()->is('admin/settings/*') || request()->is('admin/settings') || request()->is('admin/content_management') ? 'active' : '' }}">
                    <a href="{{ url('/admin/settings') }}">
                        <span class="pcoded-micon"><i class="ti-settings"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ _i('Settings') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li
                    class=" {{ request()->is('admin/pages/*') || request()->is('admin/pages') ? 'active' : '' }}">
                    <a href="{{ url('/admin/pages') }}">
                        <span class="pcoded-micon"><i class="ti-settings"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ _i('Pages') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li
                    class=" {{ request()->is('admin/services/*') || request()->is('admin/services') ? 'active' : '' }}">
                    <a href="{{ url('/admin/services') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ _i('Services') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li
                    class=" {{ request()->is('admin/contacts/*') || request()->is('admin/contacts') ? 'active' : '' }}">
                    <a href="{{ url('/admin/contacts') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ _i('Contacts') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li
                    class=" {{ request()->is('admin/jobs/*') || request()->is('admin/jobs') ? 'active' : '' }}">
                    <a href="{{ url('/admin/jobs') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ _i('Jobs') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                {{-- order requests --}}
                <li
                    class=" {{ request()->is('admin/order_request/*') || request()->is('admin/order_request') ? 'active' : '' }}">
                    <a href="{{ url('/admin/order_request') }}">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ _i('Orders') }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>


            </ul>
        </ul>

    </div>
</nav>

