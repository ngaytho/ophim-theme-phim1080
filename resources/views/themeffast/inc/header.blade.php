@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <a href="/" title="{{ $title }}" class="logo" rel="home">
                        @if ($logo)
                            {!! $logo !!}
                        @else
                            {!! $brand !!}
                        @endif
                    </a>
                </div>
                <div class="navbar-menu-toggle" id="navbar-toggle">
                    <i class="icon-menu"></i>
                </div>
                <div class="navbar-header-user">
                    <div class="user-login user-avatar" id="user-avatar">
                        <i class="icon-person"></i>
                    </div>
                    <div class="fanpage">
                        <a href="#" target="_blank">
                            <i class="icon-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="navbar-left" id="navbar-left">
                <form method="GET" id="form-search1" action="/" >
                    <div class="navbar-search">
                        <div class="search-box">
                            <input type="text" name="search" placeholder="Tìm kiếm phim..." value="{{ request('search') }}" autocomplete="off">
                            <button type="submit" style="border:0;padding:0;margin:0">
                                <i class="icon icon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="navbar-menu">
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li class="navbar-menu-item navbar-menu-has-sub">
                                <a href="javascript:void(0);">
                                    {!! ffast_format_icon_menu_left($item['name']) !!}
                                    {{ $item['name'] }}
                                </a>
                                <ul class="navbar-submenu">
                                    @foreach ($item['children'] as $children)
                                        <li class="navbar-submenu-item">
                                            <a class="navbar-menu-ditem"
                                                href="{{ $children['link'] }}">{{ $children['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="navbar-menu-item">
                                <a href="{{ $item['link'] }}">
                                    {!! ffast_format_icon_menu_left($item['name']) !!}
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </div>
                <div class="navbar-close">
                    <i class="icon-close"></i>
                </div>
                <div class="navbar-brand">
                    <a class="logo" href="/">
                        <img src="/themes/ffast/phim1080.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
