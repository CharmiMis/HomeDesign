<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', 'HomeDesignsAI')</title>

    {{-- New css starts --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web2/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('web2/css/jquery-ui.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Kalam&display=swap" rel="stylesheet">
    <link href="{{ asset('web2/css/stylesheet.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('web2/css/style.css') }}?v={{ config('app.style_css_version') }}">
    <link href="{{ asset('web2/css/responsive.css') }}" rel="stylesheet" type="text/css">
    {{-- new css ends --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('web2/css/user-dash.css') }}?v={{ config('app.user_dash_css_version') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/jquery.mCustomScrollbar.css') }}">
    <link rel="preconnect" href="https://stijndv.com">
    <link rel="stylesheet" href="https://stijndv.com/fonts/Eudoxus-Sans.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('web/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Kalam&family=Karla&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('web/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('web/plugins/sweetalert2/sweetalert2.min.css') }}">


    <!-- Meta for the page start -->
    {{-- @include('web.layout.meta_head') --}}

    {{-- <!-- begin Convert Experiences code-->
    <script type="text/javascript" src="//cdn-4.convertexperiments.com/js/10042884-10043877.js"></script>
    <!-- end Convert Experiences code --> --}}

    <!-- Meta for the page end -->

    @yield('styles')
    <script type="text/javascript">
        (function(a, b, c, d, e, f, g) {
            e['ire_o'] = c;
            e[c] = e[c] || function() {
                (e[c].a = e[c].a || []).push(arguments)
            };
            f = d.createElement(b);
            g = d.getElementsByTagName(b)[0];
            f.async = 1;
            f.src = a;
            g.parentNode.insertBefore(f, g);
        })
        ('https://utt.impactcdn.com/A4039998-ea36-4626-8493-8e37f5c94eb61.js', 'script', 'ire', document, window);
    </script>

    <!-- TrustBox script -->
    <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
    <!-- End TrustBox script -->

    <style>
        .custom-select-wrapper .input-wrapper {
            padding: 0 0px;
            display: flex;
            align-items: start;
            flex-wrap: wrap;
            width: 100%;
        }

        .custom-select-wrapper .input-wrapper p {
            border: 0;
            padding: 10px 30px 10px 15px;
            cursor: pointer;
            outline: none;
            font-family: 'Eudoxus Sans';
            font-style: normal;
            margin-bottom: 0;
            line-height: 25px;
            width: calc(100% - 0px);

            color: rgba(255, 255, 255, 0.45);

            border-radius: 12px;
            font-size: 14px;
        }

        .custom-select-wrapper ul {
            list-style: none;
            border-radius: 8px;
            padding: 0;
            text-align: center;
            overflow: hidden;
            margin: 10px 0 !important;
            transition: 0.1s ease-out;
            position: relative;
            width: 100%;
            left: 0;
            right: 0;
            display: none;
        }

        .custom-select-wrapper ul li {
            line-height: 28px;
            padding-bottom: 3px;
            font-size: 14px;
            color: #fff;
            text-align: left;
            padding-left: 25px;
        }

        .custom-select-wrapper ul li:last-child {
            padding-bottom: 0;
        }


        .custom-select-wrapper {
            position: relative;
            margin: 15px 0 0 0;
            cursor: pointer;
        }

        .custom-select-wrapper.open-dropdown i {
            transform: rotate(0deg);
            transition: 0.9s;
            line-height: normal;
        }


        .custom-select-wrapper i {
            transition: 0.9s;
            margin: 0 0px 0 10px;
            line-height: normal;
            background-color: transparent;
            padding: 0;
            right: 15px;
            position: absolute;
            top: 15px;
            transform: rotate(-90deg);
            color: rgba(255, 255, 255, 0.45);
        }

        .custom-select-wrapper .input-wrapper p img {
            width: 25px;
            margin-right: 10px;
        }
    </style>
</head>
@php

    $routes = [
        'user.redesign',
        'user.in-painting',
        'user.fill-spaces',
        'user.decor-staging',
        'user.ai-object-removal',
        'user.color-texture',
        'furniture.finding',
        'skyColor.Index',
        'expertChat.index',
        'styleTransfer.Index',
        'colorSwap.Index',
        'collage_render.Index',
        'user.roast-my-home',
        'designTransfer.Index',
        'user.convenient-redesign',
        'floorEditor.Index',
    ];

    $currentRoute = request()->route()->getName();
@endphp

<body>
    <section>
        <input id="precisionUserdetails" type="hidden" value="{{ $precisionUser ? 'true' : 'false' }}" />
        <input type="hidden" id="precisionUser" value="{{ $precisionUser ? 'true' : 'false' }}">
        <div class="gs-dashboard-wrpper">
            {{-- <div class="gs-dashboard-mobile-header">
                <div class="gs-dashboard-left-logo">
                    <a href="{{ route('user.dashboard') }}">
                        <img src=" {{ asset('web2/images/home-logo.svg') }}" />
                        <img class="light-mode"
                            src=" {{ asset('web2/images/light-mode/NewHomeDesignsAILogo 1.png') }}" />
                    </a>
                    <div class="color_mode">
                        <input type="checkbox" id="toggle-btn-1" class="toggle-btn"
                            {{ auth()->user()->light_mode == 0 ? 'checked' : '' }}>
                        <label for="toggle-btn-1"></label>
                    </div>
                    <img class="menu-icon" src="{{ asset('web2/images/gs-menu-icon.png ') }}" />
                </div>
            </div> --}}
            <div class="gs-dashboard-rigtbar">
                @yield('content')
            </div>
        </div>
        {{-- <div class="dashboard">
            <div class="left-side dash-menus" id="left-side">
                <div class="mn-dashboardlist1">
                    <div class="logo-bx">
                        <a href="https://homedesigns.ai/dashboard" class="my-5">
                            <img class="dash-logo" src="{{ asset('web/images/footer-logo.png') }}" alt="">
                        </a>
                        <a class="close dash-menu-close" href="#">
                            <img src="{{ asset('web/images/close.png') }}" alt="">
                        </a>
                    </div>
                    <div class="client-bx">
                        <ul class="dash-list">
                            <li>
                                <a class="dash-link @if (request()->routeIs('user.dashboard')) active @endif"
                                    href="{{ route('user.dashboard') }}">
                                    <img src="{{ asset('web/images/clear-sky.png') }}" alt="">
                                    Dashboard
                                </a>
                            </li>
                            <div class="custom-select-wrapper">
                                <div class="input-wrapper">
                                    <p>
                                        <img src="{{ asset('web/images/artificial-intelligence-ai-icon.svg') }}"
                                            alt="">

                                        AI Tools <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </p>

                                    <ul>
                                        <li>
                                            <a class="dash-link @if (request()->routeIs('user.redesign')) active @endif"
                                                href="{{ route('user.redesign') }}" tag="Redesign - Creative">
                                                <img src="{{ asset('web/images/dash-generate.svg') }}"
                                                    alt="">Redesign
                                            </a>
                                        </li>
                                        @if ($colorTextureUsers || $precisionUser == false || $api_user)
                                            <li>
                                                <a class="dash-link @if (request()->routeIs('user.color-texture')) active @endif"
                                                    href="{{ route('user.color-texture') }}" tag="Colors & Textures">
                                                    <img src="{{ asset('web/images/colors.png') }}" alt="">
                                                    Colors & Textures
                                                </a>
                                            </li>
                                        @else
                                            <li class="nw-tgtype ips-bf-parent">
                                                <a class="dash-link @if (request()->routeIs('user.color-texture')) active @endif"
                                                    class="dash-link " href="{{ route('user.color-texture') }}">
                                                    <img src="{{ asset('web/images/colors.png') }}" alt="">
                                                    Colors & Textures
                                                    @if ($userFreeTrialPlan != 1)
                                                        <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="ips-bf-child paid_feature_modal"></div>
                                            @else
                                                </a>
                                        @endif
                                        </li>
                                        @endif
                                        @if ($precisionUser == false || $api_user)
                                            <li>

                                                <a class="dash-link @if (request()->routeIs('user.in-painting')) active @endif"
                                                    class="dash-link " href="{{ route('user.in-painting') }}"
                                                    tag="Precision+">
                                                    <img src="{{ asset('web/images/paint-brush1.png') }}"
                                                        alt="">
                                                    Precision+

                                                </a>
                                            </li>
                                        @else
                                            <li class="nw-tgtype ips-bf-parent">
                                                <a class="dash-link @if (request()->routeIs('user.in-painting')) active @endif"
                                                    class="dash-link " href="{{ route('user.in-painting') }}"
                                                    tag="Precision+">
                                                    <img src="{{ asset('web/images/paint-brush1.png') }}"
                                                        alt="">
                                                    Precision+
                                                    @if ($userFreeTrialPlan != 1 || $api_user)
                                                        <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="ips-bf-child paid_feature_modal"></div>
                                            @else
                                                </a>
                                        @endif
                                        </li>
                                        @endif
                                        @if ($precisionUser == false || $api_user)
                                            <li>
                                                <a class="dash-link @if (request()->routeIs('user.fill-spaces')) active @endif"
                                                    href="{{ route('user.fill-spaces') }}" tag="Fill Spaces">
                                                    <img src="{{ asset('web/images/living-room1.svg') }}"
                                                        alt="">
                                                    Fill Spaces</a>
                                            </li>
                                        @else
                                            <li class="nw-tgtype ips-bf-parent">
                                                <a class="dash-link @if (request()->routeIs('user.fill-spaces')) active @endif"
                                                    href="{{ route('user.fill-spaces') }}" tag="Fill Spaces">
                                                    <img src="{{ asset('web/images/living-room1.svg') }}"
                                                        alt="">
                                                    Fill Spaces
                                                    @if ($userFreeTrialPlan != 1 || $api_user)
                                                        <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="ips-bf-child paid_feature_modal"></div>
                                            @else
                                                </a>
                                        @endif
                                        </li>
                                        @endif



                    <img class="close-icon" src="{{ asset('web2/images/gs-close-icon.png') }}" />
                </div>
                <div class="gs-dashboard-left-sec">
                    <div class="gs-dashboard-links">
                        <ul>
                            <li class="@if (request()->routeIs('user.dashboard')) active @endif">
                                <a href="{{ route('user.dashboard') }}">
                                <img src="{{ asset('web2/images/gs-leftbar-icon1.svg') }}" />
                                <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon1.svg') }}" /><span>Dashboard</span></a>
                            </li>
                            <li class="@if (request()->routeIs('user.redesign') || request()->routeIs('user.in-painting') || request()->routeIs('user.fill-spaces') || request()->routeIs('user.decor-staging') || request()->routeIs('user.ai-object-removal') || request()->routeIs('user.color-texture') || request()->routeIs('furniture.finding') || request()->routeIs('skyColor.Index') || request()->routeIs('expertChat.index')) active @endif">
                                <a href="{{ route('user.redesign') }}" tag="Redesign - Creative">
                                <img src="{{ asset('web2/images/gs-leftbar-icon2.svg') }}" />
                                <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon2.svg') }}" />
                                <span>All
                                        Tools</span></a>
                            </li>
                            @if (!$apiUser)
                                <li class="@if (request()->routeIs('api.guide')) active @endif">
                                    <a href="{{ route('api.guide') }}">
                                    <img src="{{ asset('web2/images/gs-leftbar-icon7.svg') }}" />
                                    <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon7.svg') }}" />
                                    <span>Enterprise</span></a>
                                </li>
                            @endif
                            <li class="@if (request()->routeIs('user.favorites')) active @endif">
                                <a href="{{ route('user.favorites') }}">
                                <img src="{{ asset('web2/images/gs-leftbar-icon3.svg') }}" />
                                <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon3.svg') }}" />
                                <span>Favorites</span></a>
                            </li>
                            <li class="@if (str_starts_with(request()->path(), 'user/projects')) active @endif">
                                <a href="{{ route('user.projects') }}">
                                <img src="{{ asset('web2/images/gs-leftbar-icon4.svg') }}" />
                                <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon4.svg') }}" />
                                <span>Projects</span></a>
                            </li>
                            <li class="@if (request()->routeIs('tutorial.guide')) active @endif">
                                <a href="{{ route('tutorial.guide') }}">
                                <img src="{{ asset('web2/images/gs-leftbar-icon5.svg') }}" />
                                <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon5.svg') }}" />
                                <span>Tutorials</span></a>
                            </li>
                            <li>
                                <a href="https://homedesignsai.reamaze.com/" target="_blank">
                                <img src="{{ asset('web2/images/gs-leftbar-icon6.svg') }}" />
                                <img class="light-mode" src="{{ asset('web2/images/light-mode/gs-leftbar-icon6.svg') }}" />
                                <span>Support</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="gs-dashboard-try-ai">
                        <h3>Tip of the day</h3>
                        <p id="tip-of-the-day"></p>
                    </div>

                </div>
                <div class="gs-dashboard-user">
                    <div class="gs-dashboard-user-icon">
                        <img src="{{ asset('web2/images/user-avatar.png') }}" />
                    </div>
                    <div class="gs-dashboard-user-name">
                        <strong>{{ $customer->name }}</strong>
                        <p>{{ $currentPlan }}</p>
                    </div>
                    <div class="gs-dashboard-setting">
                        <a href="{{ route('user.settings') }}">
                        <img src="{{ asset('web2/images/setting-icon.svg') }}" alt="" />
                        <img class="light-mode" src="{{ asset('web2/images/light-mode/setting-icon.svg') }}" alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="gs-dashboard-rigtbar">
                @yield('content')
            </div>
        </div>
        {{-- <div class="dashboard">
            <div class="left-side dash-menus" id="left-side">
                <div class="mn-dashboardlist1">
                    <div class="logo-bx">
                        <a href="https://homedesigns.ai/dashboard" class="my-5">
                            <img class="dash-logo" src="{{ asset('web/images/footer-logo.png') }}" alt="">
                        </a>
                        <a class="close dash-menu-close" href="#">
                            <img src="{{ asset('web/images/close.png') }}" alt="">
                        </a>
                    </div>
                    <div class="client-bx">
                        <ul class="dash-list">
                            <li>
                                <a class="dash-link @if (request()->routeIs('user.dashboard')) active @endif"
                                    href="{{ route('user.dashboard') }}">
                                    <img src="{{ asset('web/images/clear-sky.png') }}" alt="">
                                    Dashboard
                                </a>
                            </li>
                            <div class="custom-select-wrapper">
                                <div class="input-wrapper">
                                    <p>
                                        <img src="{{ asset('web/images/artificial-intelligence-ai-icon.svg') }}"
                                            alt="">

                                        AI Tools <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </p>

                                    <ul>
                                        <li>
                                            <a class="dash-link @if (request()->routeIs('user.redesign')) active @endif"
                                                href="{{ route('user.redesign') }}" tag="Redesign - Creative">
                                                <img src="{{ asset('web/images/dash-generate.svg') }}"
                                                    alt="">Redesign
                                            </a>
                                        </li>
                                        @if ($colorTextureUsers || $precisionUser == false || $api_user)
                                            <li>
                                                <a class="dash-link @if (request()->routeIs('user.color-texture')) active @endif"
                                                    href="{{ route('user.color-texture') }}" tag="Colors & Textures">
                                                    <img src="{{ asset('web/images/colors.png') }}" alt="">
                                                    Colors & Textures
                                                </a>
                                            </li>
                                        @else
                                            <li class="nw-tgtype ips-bf-parent">
                                                <a class="dash-link @if (request()->routeIs('user.color-texture')) active @endif"
                                                    class="dash-link " href="{{ route('user.color-texture') }}">
                                                    <img src="{{ asset('web/images/colors.png') }}" alt="">
                                                    Colors & Textures
                                                    @if ($userFreeTrialPlan != 1)
                                                        <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="ips-bf-child paid_feature_modal"></div>
                                            @else
                                                </a>
                                        @endif
                                        </li>
                                        @endif
                                        @if ($precisionUser == false || $api_user)
                                            <li>

                                                <a class="dash-link @if (request()->routeIs('user.in-painting')) active @endif"
                                                    class="dash-link " href="{{ route('user.in-painting') }}"
                                                    tag="Precision+">
                                                    <img src="{{ asset('web/images/paint-brush1.png') }}"
                                                        alt="">
                                                    Precision+

                                                </a>
                                            </li>
                                        @else
                                            <li class="nw-tgtype ips-bf-parent">
                                                <a class="dash-link @if (request()->routeIs('user.in-painting')) active @endif"
                                                    class="dash-link " href="{{ route('user.in-painting') }}"
                                                    tag="Precision+">
                                                    <img src="{{ asset('web/images/paint-brush1.png') }}"
                                                        alt="">
                                                    Precision+
                                                    @if ($userFreeTrialPlan != 1 || $api_user)
                                                        <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="ips-bf-child paid_feature_modal"></div>
                                            @else
                                                </a>
                                        @endif
                                        </li>
                                        @endif
                                        @if ($precisionUser == false || $api_user)
                                            <li>
                                                <a class="dash-link @if (request()->routeIs('user.fill-spaces')) active @endif"
                                                    href="{{ route('user.fill-spaces') }}" tag="Fill Spaces">
                                                    <img src="{{ asset('web/images/living-room1.svg') }}"
                                                        alt="">
                                                    Fill Spaces</a>
                                            </li>
                                        @else
                                            <li class="nw-tgtype ips-bf-parent">
                                                <a class="dash-link @if (request()->routeIs('user.fill-spaces')) active @endif"
                                                    href="{{ route('user.fill-spaces') }}" tag="Fill Spaces">
                                                    <img src="{{ asset('web/images/living-room1.svg') }}"
                                                        alt="">
                                                    Fill Spaces
                                                    @if ($userFreeTrialPlan != 1 || $api_user)
                                                        <i class="fa fa-lock c-fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="ips-bf-child paid_feature_modal"></div>
                                            @else
                                                </a>
                                        @endif
                                        </li>
                                        @endif

                                        <li>
                                            <a class="dash-link @if (request()->routeIs('user.decor-staging')) active @endif"
                                                href="{{ route('user.decor-staging') }}"
                                                onclick="myClickHandler(event)" tag="Decor Staging">
                                                <img src="{{ asset('web/images/living-room.png') }}" alt="">
                                                Decor Staging
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dash-link @if (request()->routeIs('user.ai-object-removal')) active @endif"
                                                href="{{ route('user.ai-object-removal') }}"
                                                onclick="myClickHandler(event)" tag="Furniture Removal">
                                                <img src="{{ asset('web/images/furniture-removal.png') }}"
                                                    alt="">
                                                Furniture Removal
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dash-link @if (request()->routeIs('furniture.finding')) active @endif"
                                                href="{{ route('furniture.finding') }}" tag="Furniture Finder">
                                                <img src="{{ asset('web/images/finder.png') }}" alt="">
                                                Furniture Finder
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dash-link @if (request()->routeIs('skyColor.Index')) active @endif"
                                                href="{{ route('skyColor.Index') }}">
                                                <img src="{{ asset('web/images/clear-sky.png') }}" alt="">
                                                Sky Colors
                                            </a>
                                        </li>
                                    </ul>

                                </div>

                            </div>


                            <li>
                                <a class="dash-link @if (request()->routeIs('user.favorites')) active @endif"
                                    href="{{ route('user.favorites') }}" tag="Your Favorites">
                                    <img src="{{ asset('web/images/generate-gallery.svg') }}" alt="">
                                    Your Favorites
                                </a>
                            </li>
                            <li>
                                <a class="dash-link @if (str_starts_with(request()->path(), 'user/projects')) active @endif"
                                    href="{{ route('user.projects') }}">
                                    <img src="{{ asset('web/images/folder_icons.png') }}" alt="">
                                    Projects
                                </a>
                            </li>

                            <li>
                                <a class="dash-link @if (request()->routeIs('tutorial.guide')) active @endif"
                                    href="{{ route('tutorial.guide') }}">
                                    <img src="{{ asset('web/images/tutorial-icon.svg') }}" alt="">
                                    Tutorials
                                </a>
                            </li>
                            @if ($apiUser)

                            @else
                                <li>
                                    <a class="dash-link @if (request()->routeIs('api.guide')) active @endif"
                                        href="{{ route('api.guide') }}" tag="Api Board">
                                        <img src="{{ asset('web/images/tutorial-icon.svg') }}" alt="">
                                        Api Board
                                    </a>
                                </li>
                            @endif
                            @if (!$apiUser)
                                <li>
                                    <a class="dash-link @if (request()->routeIs('api.get.mask.image')) active @endif"
                                        href="{{ route('api.get.mask.image') }}" tag="Mask Image">
                                        <img src="{{ asset('web/images/tutorial-icon.svg') }}" alt="">
                                        Mask Image
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a class="dash-link" href="https://homedesignsai.reamaze.com/" target="blank"
                                    tag="Support">
                                    <img src="{{ asset('web/images/help-icon.svg') }}" alt="">Support
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <div class="right-box dash-form bg_color_set_right">
                <div class="mobile-header">
                    <a href="https://homedesigns.ai/dashboard"> <img class="dash-logo"
                            src="{{ asset('web/images/dashboardlogonew2.png') }}" alt=""> </a>
                    <div class="mobile-menu">
                        <a href="#" class="dash_mobile_menu"><img
                                src="{{ asset('web/images/menu.png') }}"></a>
                    </div>
                </div>
                <div class="mobile-menu bottom">
                    <a href="#" class="dash_mobile_menu"><img
                            src="{{ asset('web/images/menubottom.png') }}"></a>
                </div>
                <div class="right-boxinner ">
                    <div class="upper_header">
                        <div class="customer-info-dropdown">
                            <a href="#" onclick="toggleDiv()">Hi, {{ $customer->name }}
                                <img src="{{ asset('web/images/down_arrow1.svg') }}" />
                            </a>

                        </div>


                        <div id="myDiv" class="card hidden setting-menu">
                            <div class="card-body">
                                <a href="{{ route('user.settings') }}"><img
                                        src="{{ asset('web/images/setting.png') }}" alt="setting" />Settings</a>
                                <a class="logout_user" href="javascript:void(0)"> <img
                                        src="{{ asset('web/images/logout.png') }}" alt="logout" />Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div> --}}

        <div id="feedbackForm" class="modal feedback_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hdc-modal">

                    <div class="mdp-cl-btn mdl-close-btn">
                        <span class="precision_suggestion_closebt" data-bs-dismiss="modal">
                            <i class="fa fa-times fa-unset" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="head">
                        <h5 class="modal-title">Provide additional feedback</h5>
                    </div>

                    <div class="body">
                        <input type="hidden" name="sidebarmodule" value="" id="sidebarmodule" />
                        <input type="hidden" name="module_category" value="" id="module_category" />
                        <input type="hidden" id="feedback_image" name="feedback_image" value="" />
                        <input type="hidden" id="gallery_id" name="gallery_id" value="" />
                        <textarea id="feedback_description" name="feedback"
                            placeholder="The more details you give us, the better. Tell us what's wrong with this result.."></textarea>
                    </div>

                    <div id="full-stars-example-two" class="rating_star_main">
                        <span class="rating_title text-center">Rate this image from 0 to 5 stars</span>
                        <div class="rating-group">
                            <input disabled checked class="rating__input rating__input--none" name="rating3"
                                id="rating3-none" value="0" type="radio">
                            <label aria-label="1 star" class="rating__label" for="rating3-1"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-1" value="1"
                                type="radio">
                            <label aria-label="2 stars" class="rating__label" for="rating3-2"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-2" value="2"
                                type="radio">
                            <label aria-label="3 stars" class="rating__label" for="rating3-3"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-3" value="3"
                                type="radio">
                            <label aria-label="4 stars" class="rating__label" for="rating3-4"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-4" value="4"
                                type="radio">
                            <label aria-label="5 stars" class="rating__label" for="rating3-5"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                            <input class="rating__input" name="rating3" id="rating3-5" value="5"
                                type="radio">
                        </div>
                    </div>
                    <div class="modal_footer_content">
                        <button class="modal_footer_button" id="feedback_submit_button">Submit Feedback</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalStyleUpgradePlan" class="modal fade gs-modal-background" tabindex="-1" role="dialog">
            <div class="modal-dialog gs-modal-container" role="document">
                <div class="modal-content hdc-modal gs-modal-content">
                    <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                            src="{{ asset('web2/images/gs-close-icon.svg') }}"></button>
                    <div class="head">
                        <h5 class="modal-title">Not available in your account.</h5>
                    </div>

                    <div class="body">
                        <p class="style_body_header"><strong>This style is part of the <span class="add-ons-heading"
                                    data-toggle="tooltip"
                                    title="Pop Art, Vintage Glam, Candy Land, Barbie, Doodle, Sketch, Maximalist, Professional, Airbnb, Halloween, Retro, Romantic, Glam Rock, Safari, Tuscan, Nautical, Craftsman, Farmhouse Chic, Prairie, and Cubism.">Extra
                                    Styles Add-on</span>.</strong> Upgrade your account to use this style.</p>
                    </div>
                    <div class="modal_footer_content">
                        <button class="card-submit modal_footer_button"
                            data-fsc-item-path='homedesignsai-extra-styles'
                            data-fsc-item-path-value='homedesignsai-extra-styles' data-fsc-action="Add, Checkout"
                            onclick="hideCred()">Upgrade Your Account</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalRoomTypeUpgradePlan" class="modal fade gs-modal-background" tabindex="-1" role="dialog">
            <div class="modal-dialog gs-modal-container" role="document">
                <div class="modal-content hdc-modal gs-modal-content">
                    <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                            src="{{ asset('web2/images/gs-close-icon.svg') }}"></button>
                    <div class="head">
                        <h5 class="modal-title">Not available in your account.</h5>
                    </div>

                    <div class="body">
                        <p class="room_body_header"><strong>This room type is part of the <span
                                    class="add-ons-heading" data-toggle="tooltip"
                                    title="Wedding Room, Porch, Playground, Laundry Room, Outdoor Kitchen, Utility Room, Pet Room, Home Gym, Lounge, Walk-in Closet, Playroom, Reading Nook, Sauna, Man Cave, Foyer, Greenhouse, She Shed, Conservatory, Nursery, and Prayer Room">Extra
                                    Room Types Add-on</span>.</strong> Upgrade your account to use this room type.</p>
                    </div>
                    <div class="modal_footer_content">
                        <button class="card-submit modal_footer_button"
                            data-fsc-item-path='homedesignsai-extra-room-types'
                            data-fsc-item-path-value='homedesignsai-extra-room-types' data-fsc-action="Add, Checkout"
                            onclick="hideCred()">Upgrade Your Account</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade gs-modal-background" id="uploading_instruction" role="dialog">
        <div class="modal-dialog gs-modal-container">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                        src="{{ asset('web2/images/gs-close-icon.svg') }}"></button>
                <div class="gs-modal-best-results">
                    <div class="gs-modal-best-left">
                        <img src="{{ asset('web2/images/for-best-results1.svg') }}">
                    </div>
                    <div class="gs-modal-best-right">
                        <h4>For Best Results:</h4>
                        <p>Upload high-resolution images in common formats (JPEG, PNG, GIF), ensuring a balanced
                            contrast.</p>
                    </div>
                </div>
                <div class="gs-modal-best-results">
                    <div class="gs-modal-best-left">
                        <img src="{{ asset('web2/images/for-best-results2.svg') }}">
                    </div>
                    <div class="gs-modal-best-right">
                        <h4>Avoid:</h4>
                        <ul>
                            <li><img src="{{ asset('web2/images/gs-avoid-img1.png') }}"><span>Avoid blurry
                                    image</span></li>
                            <li><img src="{{ asset('web2/images/gs-avoid-img2.png') }}"><span>Avoid dark image</span>
                            </li>
                            <li><img src="{{ asset('web2/images/gs-avoid-img3.png') }}"><span>Avoid Screenshots</span>
                            </li>
                            <li><img src="{{ asset('web2/images/gs-avoid-img4.png') }}"><span>Avoid Fisheye
                                    effect</span></li>
                            <li><img src="{{ asset('web2/images/gs-avoid-img5.png') }}"><span>Avoid Ultra Wide</span>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="gs-modal-best-btns">
                    <a href="javascript:void(0)" class="gs-modal-best-inderstand">I Understand</a>
                    <a href="javascript:void(0)" class="gs-modal-dont-show-modal">Don’t show this again</a>
                    {{-- <a href="#" class="gs-modal-best-inderstand"  data-dismiss="modal" data-toggle="modal" data-target="#loading_brilliance">I Understand</a> --}}
                    {{-- <a href="#"  data-dismiss="modal" data-toggle="modal" data-target="#loading_brilliance">Don’t show this again</a> --}}
                    {{-- <div class="redirection-link" style="display: none;">redesign-customise-generate.html</div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade gs-modal-background" id="loading_brilliance" role="dialog">
        <div class="modal-dialog gs-modal-container">
            <div class="modal-content gs-modal-content">
                {{-- <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                        src="{{ asset('web2/images/gs-close-icon.svg') }}"></button> --}}
                <div class="gs-modal-uploading_instruction">
                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                    <dotlottie-player src="https://lottie.host/f153e458-6b70-4270-84a7-bb5665de0dbf/GLxYOI5N17.json"
                        background="transparent" speed="1" style="width: 300px; height: 300px;" loop
                        autoplay></dotlottie-player>
                    <h3>Loading brilliance....</h3>
                    <p>Unleashing the AI magic!</p>

                    <div class="gs-modal-uploading_instruction_slider">
                        <div class="gs-modal-uploading_instruction_slide"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('web2.designs_options.interior_room_type')

    @include('web2.designs_options.interior_design_style')

    @include('web2.designs_options.exterior_style')

    @include('web2.designs_options.garden_types')

    @include('web2.designs_options.garden_styles')

    <div class="modal fade gs-modal-background" id="logoutModal" role="dialog">
        <div class="modal-dialog gs-modal-container">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal">
                    <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
                </button>
                <h3 class="logout_heading">Are you sure you want to logout?</h3>
                <div class="gs-project-add-new-form">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="gs-login-brn-outer">
                            <button class="gs-login-btn" type="submit">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade gs-modal-background" id="errorModal" role="dialog">
        <div class="modal-dialog gs-modal-container">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal">
                    <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
                </button>
                <div class="error-wrapper">
                    <img src="{{ asset('web2/images/close_icon.png') }}" alt="">
                    <h4></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade gs-modal-background" id="pdfModal" tabindex="-1" role="dialog"
        aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg gs-modal-container" role="document">
            <div class="modal-content gs-modal-content">
                <div class="modal-header">
                    <button class="pdf-icon fullscreen-icon" id="toggleFullscreen">Toggle Fullscreen</button>
                    {{-- <button type="button" class="pdf-icon btn" id="customCloseButton">Close</button> --}}
                    <button type="button" class="gs-modal-close" data-dismiss="modal"><img
                            src="{{ asset('web2/images/gs-close-icon.svg') }}"></button>
                </div>
                <div class="pdf_body">
                    <div id="pdfContainer" class="pdf-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade gs-modal-background" id="confirm_delete_modal" role="dialog">
        <div class="modal-dialog gs-modal-container">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal">
                    <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
                </button>
                <div class="confirm-content">
                    <img src="{{ asset('web2/images/success_icon.png') }}">
                    <h2 class="modal-title" id="modalTitle">Deleted!</h2>
                    <p>Your Images have been deleted.</p>
                    <div class="confirm-modal-button">
                        <button class="gs-login-btn close-confirm-delete-modal" type="button">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade gs-modal-background" id="success_project_modal" role="dialog">
        <div class="modal-dialog gs-modal-container">
            <div class="modal-content gs-modal-content">
                <button type="button" class="gs-modal-close" data-dismiss="modal">
                    <img src="{{ asset('web2/images/gs-close-icon.svg') }}">
                </button>
                <div class="confirm-content">
                    <img src="{{ asset('web2/images/success_icon.png') }}">
                    <h2 class="modal-title" id="modalTitle">Added!</h2>
                    <p>Your Images has been added successfully!</p>
                    <div class="confirm-modal-button">
                        <button class="gs-login-btn close-confirm-project-modal" type="button">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="routeToRunpodType" data-route="{{ route('nextrunpod.name') }}"></div>
    <div id="routeToGetFailedResp" data-route="{{ route('failed_response.data') }}"></div>
    <div id="deleteRenderImages" class="hidden" data-route="{{ route('image.delete') }}"></div>
    {{-- <div id="addImagesToProject" class="hidden" data-route="{{ route('user.add-images-to-project') }}"></div> --}}
    {{-- <div id="addAllImagesAsFavourite" class="hidden" data-route="{{ route('user.add-images-as-favourite') }}"> --}}
    </div>
    {{-- <div id="editAsPrecision" data-route="{{ route('editAs.precision') }}"></div> --}}
    @include('web2.common.design-preview')

    {{-- new js --}}
    <script src="{{ asset('web2/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web2/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web2/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('web2/js/slick.min.js') }}"></script>
    <script src="{{ asset('web2/js/after-before.js') }}"></script>
    <script src="{{ asset('web2/js/custom.js') }}?v={{config('app.custom_js_web2')}}"></script>
    {{-- new js ends --}}

    <script src="{{ asset('web/js/wow.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"
        integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.js"
        integrity="sha512-3FKAKNDHbfUwAgW45wNAvfgJDDdNoTi5PZWU7ak3Xm0X8u0LbDBWZEyPklRebTZ8r+p0M2KIJWDYZQjDPyYQEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script src=" {{ asset('web/js/jquery.mCustomScrollbar.js') }} "></script>
    <script>
        const SITE_BASE_URL = "{{ config('app.url') }}";
        const user = JSON.parse('@json(auth()->user())');
        const APP_LOCAL = "{{ config('app.env') }}";
        const GPU_SERVER_HOST = "{{ config('app.GPU_SERVER_HOST') }}";
        const API_GPU_SERVER_HOST = "{{ config('app.API_GPU_SERVER_HOST') }}";
        const API_BRONZE_CREDIT = "{{ config('app.API_BRONZE_CREDIT') }}";
        const API_SILVER_CREDIT = "{{ config('app.API_SILVER_CREDIT') }}";
        const API_GOLD_CREDIT = "{{ config('app.API_GOLD_CREDIT') }}";
        const API_SME_CREDIT = "{{ config('app.API_SME_CREDIT') }}";
        const GPU_SERVER_HOST_INIT = "{{ config('app.GPU_SERVER_HOST_INIT') }}";
        const GPU_SERVER_HOST_SEG = "{{ config('app.GPU_SERVER_HOST_SEG') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('web/js/script.js') }}?v={{ config('app.script_js_version') }}"></script>
    <script src="{{ asset('web2/js/custom-script.js') }}?v={{ config('app.custom_script_version') }}"></script>
    <script src="{{ asset('web/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>

    @yield('scripts')

    @stack('script-stack')
    <script>
        // $('[data-toggle="tooltip"]').tooltip();
        $(document).on('click', '.cancel_subscription_btn', function() {
            swal.fire({
                    title: 'Are you sure you want to cancel your active subscription?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!'
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $('#cancel_subscription_form').submit();
                        Swal.fire(
                            'Deleted!',
                            'Your Current Subscription has been cancled successfully',
                            'success'
                        )
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000); //refresh every 2 seconds
                    }
                });
        });
    </script>
    <script>
        function hideCred() {
            console.log("");
        };

        function toggleDiv() {
            var div = document.getElementById("myDiv");
            div.classList.toggle("hidden");
            event.stopPropagation();
        }
    </script>
    <script>
        if (window.innerWidth < 768) {
            // Set a different width for mobile view
            $('.welcome_video').html(
                '<iframe width="100%" height="180" src="https://www.youtube.com/embed/cIYIejIHjDA" frameborder="0" allowfullscreen></iframe>'
            );
        } else {
            // Use the default width for other screen sizes
            $('.welcome_video').html(
                '<iframe width="560" height="315" src="https://www.youtube.com/embed/cIYIejIHjDA" frameborder="0" allowfullscreen></iframe>'
            );
        }
        let clickCount = 1;

    </script>
    <script>
        $(document).ready(function() {
            //Open Drop Down
            // Check the state of the checkbox on page load
            $(".custom-select-wrapper p").click(function() {

                $(".custom-select-wrapper ul").slideToggle(700);
                $(this).parent().parent().toggleClass('open-dropdown');
            });

            const activeLinks = $(".dash-list ul li a.active");

            if (activeLinks.length > 0) {
                $('.dash-list .custom-select-wrapper ul').css('display', 'block');
                $('.dash-list .custom-select-wrapper').addClass('open-dropdown');

            } else {
                $('.dash-list .custom-select-wrapper ul').css('display', 'none');
                $('.dash-list .custom-select-wrapper').removeClass('open-dropdown');
            }
        });
    </script>

    <script>
        function selectRoomType(roomType, sec) {
            // Set the selected room type in the hidden input
            document.getElementById('selectedRoomType' + sec).value = roomType;

            // Update the display
            var roomTypeDisplay = document.getElementById('roomTypeDisplay' + sec);
            var allRoomTypes = document.getElementById('allRoomTypes' + sec);

            // Remove the "active" class from all room type divs in allRoomTypes
            var activeDivAllRoomTypes = roomTypeDisplay.querySelector('.gs-select-room-style-single.active');
            if (activeDivAllRoomTypes) {
                activeDivAllRoomTypes.classList.remove('active');
            }

            var activeDivAllRoomTypes = allRoomTypes.querySelector('.gs-select-room-style-single.active');
            if (activeDivAllRoomTypes) {
                activeDivAllRoomTypes.classList.remove('active');
            }

            // Check if the selected room type div is already present in roomTypeDisplay
            var selectedRoomTypeDivRoomTypeDisplay = roomTypeDisplay.querySelector(`[data-room-type="${roomType}"]`);

            if (selectedRoomTypeDivRoomTypeDisplay) {
                // Add the "active" class to the selected room type div in roomTypeDisplay
                selectedRoomTypeDivRoomTypeDisplay.classList.add('active');

                // Add the "active" class to the corresponding room type div in allRoomTypes
                var selectedRoomTypeDivAllRoomTypes = allRoomTypes.querySelector(`[data-room-type="${roomType}"]`);
                if (selectedRoomTypeDivAllRoomTypes) {
                    selectedRoomTypeDivAllRoomTypes.classList.add('active');
                }
            } else {
                // Remove the last child of roomTypeDisplay
                if (roomTypeDisplay.children.length > 0) {
                    roomTypeDisplay.removeChild(roomTypeDisplay.lastElementChild);
                }

                // Clone the selected room type div from allRoomTypes before moving it
                var selectedRoomTypeDivAllRoomTypes = allRoomTypes.querySelector(`[data-room-type="${roomType}"]`);
                if (selectedRoomTypeDivAllRoomTypes) {
                    var clonedRoomTypeDiv = selectedRoomTypeDivAllRoomTypes.cloneNode(true);

                    // Add the "active" class to the cloned room type div
                    clonedRoomTypeDiv.classList.add('active');

                    // Insert the new cloned room type div as the first child of roomTypeDisplay
                    roomTypeDisplay.insertBefore(clonedRoomTypeDiv, roomTypeDisplay.firstChild);

                    // Add the "active" class to the corresponding room type div in allRoomTypes
                    selectedRoomTypeDivAllRoomTypes.classList.add('active');
                }
            }
        }

        function selectDesignStyle(style, sec) {
            // Set the selected design style in the hidden input
            document.getElementById('selectedDesignStyle' + sec).value = style;

            // Update the display logic here (if needed)
            // For example, you can highlight the selected design style visually
            var designStyleDisplay = document.getElementById('designStyleDisplay' + sec);
            var allDesignStyles = document.getElementById('allDesignStyles' + sec);

            // Remove the "active" class from all design style divs in allDesignStyles
            var activeDivAllDesignStyles = designStyleDisplay.querySelector('.gs-select-room-style-single.active');
            if (activeDivAllDesignStyles) {
                activeDivAllDesignStyles.classList.remove('active');
            }

            var activeDivAllDesignStyles = allDesignStyles.querySelector('.gs-select-room-style-single.active');
            if (activeDivAllDesignStyles) {
                activeDivAllDesignStyles.classList.remove('active');
            }

            // Check if the selected design style div is already present in designStyleDisplay
            var selectedDesignStyleDivDesignStyleDisplay = designStyleDisplay.querySelector(
                `[data-design-style="${style}"]`);

            if (selectedDesignStyleDivDesignStyleDisplay) {
                // Add the "active" class to the selected design style div in designStyleDisplay
                selectedDesignStyleDivDesignStyleDisplay.classList.add('active');

                // Add the "active" class to the corresponding design style div in allDesignStyles
                var selectedDesignStyleDivAllDesignStyles = allDesignStyles.querySelector(`[data-design-style="${style}"]`);
                if (selectedDesignStyleDivAllDesignStyles) {
                    selectedDesignStyleDivAllDesignStyles.classList.add('active');
                }
            } else {
                // Remove the last child of designStyleDisplay
                if (designStyleDisplay.children.length > 0) {
                    designStyleDisplay.removeChild(designStyleDisplay.lastElementChild);
                }

                // Clone the selected design style div from allDesignStyles before moving it
                var selectedDesignStyleDivAllDesignStyles = allDesignStyles.querySelector(`[data-design-style="${style}"]`);
                if (selectedDesignStyleDivAllDesignStyles) {
                    var clonedDesignStyleDiv = selectedDesignStyleDivAllDesignStyles.cloneNode(true);

                    // Add the "active" class to the cloned design style div
                    clonedDesignStyleDiv.classList.add('active');

                    // Insert the new cloned design style div as the first child of designStyleDisplay
                    designStyleDisplay.insertBefore(clonedDesignStyleDiv, designStyleDisplay.firstChild);

                    // Add the "active" class to the corresponding design style div in allDesignStyles
                    selectedDesignStyleDivAllDesignStyles.classList.add('active');
                }
            }
        }

        function selectModeType(modeType, sec) {
            $(`.gs-select-room-style-single[data-room-type="${modeType}"][onclick*="(${modeType},${sec})"]`).removeClass('active');
            $(`.gs-select-room-style-single[data-room-type="${modeType}"][onclick*="(${modeType},${sec})"]`).addClass('active');
            document.getElementById('selectedModeType' + sec).value = modeType;
        }

    </script>
    <script>
        $(".ai-tool-search").click(function() {
            $(".ai-tool-wrapper").toggleClass("slide-close");
        });
    </script>
    {{-- <div class="elfsight-app-c277abde-f388-4053-bb82-572a308f96f1"></div> --}}
</body>

</html>
