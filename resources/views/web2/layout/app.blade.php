<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', 'HomeDesignsAI')</title>
    <link rel="shortcut icon" href="{{ asset('web/images/favicon.ico') }}" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/style.css') }}?v={{ config('app.style_css_version') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/animate.css') }}">

    <link rel="preconnect" href="https://stijndv.com">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/Eudoxus-Sans.css') }}">
    {{-- <link rel="stylesheet" href="https://stijndv.com/fonts/Eudoxus-Sans.css"> --}}

    <link rel="preconnect" type="text/css" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link href="{{ asset('web/css/main-style.css')}}?v={{ config('app.main_style_css_version') }}" rel="stylesheet" >
    <link href="{{ asset('web/css/responsive.css')}}" rel="stylesheet" >
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/googleapisFonts.css')}}">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Kalam&family=Karla&display=swap" rel="stylesheet"> --}}

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('head')

    @env('production')
    <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0034/9410.js" async="async"></script>

    <!-- Google Tag Manager (script) start -->
    @include('web.layout.google_tag_manager')
    <!-- Google Tag Manager (script) start -->


    @if (!auth()->check())
        @include('web.layout.provely')
    @endif
    @endenv
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

    <script type="text/javascript">
        (function(w,d,u){
            w.$productFruits = w.$productFruits || [];
            w.productFruits=w.productFruits||{ };w.productFruits.scrV='2';
            let a=d.getElementsByTagName('head')[0];let r=d.createElement('script');r.async=1;r.src=u;a.appendChild(r);
        })(window,document,'https://app.productfruits.com/static/script.js');
    </script>

</head>
@php
    $customer = auth()->user();
    $currenturl = request()->path();
    $curr_bank = 0;
    if ($customer) {
        $customerId = $customer->id;
        $customerName = $customer->name;
        $customerEmail = sha1($customer->email);
        $curr_bank = $customer->curr_bank;
    } else {
        $customerId = '';
        $customerName = '';
        $customerEmail = '';
        $curr_bank = 0;
    }
    session(['source' => Request::path()]);
    //session(['redirectTo' => url()->current() . '#buy']);
@endphp

<body>
    @env('production')
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K4VHLCT" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endenv

    <main id="hmn-main">

        <div class="ips-limit-crossed" id="limitCrossedMessage">
            <strong>You do not have</strong> enough credits! Wait 24 hours for 3 new credits or <strong>UPGRADE NOW -
                Our Early Bird discount will expire soon. You'll never see these low prices again!</strong>
        </div>
        <!--condition to remove header and footer from precision page -->
        @if($currenturl == 'premium-upgrade' || $currenturl == 'premium-upgrade-software' || $currenturl == 'premium-upgrade-cb' || $currenturl == 'special-offer-extra-rooms' || $currenturl == 'special-offer-extra-styles' || $currenturl == 'special-offer-monetization-guide')
            @yield('content')
        @else
            <!-- Header start -->
            @include('web.layout.header')
            <!-- Header end -->


            @yield('content')


            <!-- footer -->
            @include('web.layout.footer')
            <!-- footer end -->
        @endif

        @if (auth()->check())
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
            </form>
        @else
            <div id="loginModel" class="modal"
                style="position: fixed; top: 0; left: 0; z-index: 1040; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(10px);">
                <div class="modal-content">
                    <div class="modallog">
                        <div class="bckg">
                            <form action="{{ route('ajaxLogin') }}" method="POST" id="loginModelForm">
                                @csrf
                                <span class="close pad" onclick="closeModal()" style="color: #1E1634">&times;</span>
                                <div class="logintext pad">Login or Register</div>
                                <br>
                                <div>
                                    <div class="mb-4">
                                        <input class="file-options3" name="email" type="email" id="email"
                                            placeholder="Email">
                                        <span class="help-block d-block error-block"></span>
                                    </div>

                                    <div class="mb-4">
                                        <input class="file-options3" name="password" type="password" id="password"
                                            placeholder="password">
                                        <span class="help-block d-block error-block"></span>
                                    </div>
                                </div>

                                <div id="button_container" class="menu pad">
                                    <button type="button"
                                        class="loginbutt selected _home_login_submit _disable_on_submit"
                                        style="border-color: #1E1634; background-color: #1E1634; color:white">
                                        Login
                                    </button>
                                </div>
                            </form>
                             <a href="{{ route('login.google', ['redirectTo' => url()->current() . '#buy']) }}" class="google-login-button d-none">
                                <img class='signingoogle' src="{{ asset('web/images/') }}/download.png"
                                    style="margin-top: 10px;" alt="gmail login homedesignsai">
                            </a>
                            <br>
                            <a href="{{ url('auth/facebook') }}" class="facebook-login-button d-none">
                                <img class='signingoogle' src="{{ asset('web/images/facebook_login.png') }}" style="margin-top: 10px;">
                            </a>
                            <p class="message">Not registered? <a
                                    href="{{ route('register', ['redirectTo' => url()->current() . '#buy']) }}"> Create
                                    an
                                    account</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div id="modalUpgradePlan" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hdc-modal">

                    <div class="head">
                        <h5 class="modal-title">Available only for Premium members.</h5>
                    </div>

                    <div class="body">
                        <p>If you want to use the premium features you must first upgrade your license.</p>
                    </div>
                    @if($curr_bank == 2 )
                    <div class="modal_footer_content">
                        <a href="{{ route('premium.upgradeCB')}}"><button class="modal_footer_button">Upgrade to Premium CB</button></a>
                    </div>
                    @else
                    <div class="modal_footer_content">
                        <a href="{{ route('premium.upgradeSoftware')}}"><button class="modal_footer_button">Learn More About Premium</button></a>
                    </div>
                    <img src="{{asset('web/images/permium_feture_icon.png')}}" class="mt-3" alt="sam">
                </div>
            </div>
        </div>
        <div id="modalStyleUpgradePlan" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hdc-modal">
                    <div class="mdp-cl-btn mdl-close-btn">
                        <span class="precision_suggestion_closebt" id="closeExtraStyleModal" data-bs-dismiss="modal">
                            <i class="fa fa-times fa-unset" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="head">
                        <h5 class="modal-title">Not available in your account.</h5>
                    </div>

                    <div class="body">
                        <p class="style_body_header"><strong>This style is part of the <span class="add-ons-heading" data-toggle="tooltip" title="Pop Art, Vintage Glam, Candy Land, Barbie, Doodle, Sketch, Maximalist, Professional, Airbnb, Halloween, Retro, Romantic, Glam Rock, Safari, Tuscan, Nautical, Craftsman, Farmhouse Chic, Prairie, and Cubism.">Extra Styles Add-on</span>.</strong> Upgrade your account to use this style.</p>
                    </div>
                    <div class="modal_footer_content">
                        <button class="card-submit modal_footer_button" data-fsc-item-path='homedesignsai-extra-styles' data-fsc-item-path-value='homedesignsai-extra-styles' data-fsc-action="Add, Checkout" onclick="hideCred()">Upgrade Your Account</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalRoomTypeUpgradePlan" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hdc-modal">
                    <div class="mdp-cl-btn mdl-close-btn">
                        <span class="precision_suggestion_closebt" id="closeExtraRoomModal" data-bs-dismiss="modal">
                            <i class="fa fa-times fa-unset" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="head">
                        <h5 class="modal-title">Not available in your account.</h5>
                    </div>

                    <div class="body">
                        <p class="room_body_header"><strong>This room type is part of the <span class="add-ons-heading" data-toggle="tooltip" title="Wedding Room, Porch, Playground, Laundry Room, Outdoor Kitchen, Utility Room, Pet Room, Home Gym, Lounge, Walk-in Closet, Playroom, Reading Nook, Sauna, Man Cave, Foyer, Greenhouse, She Shed, Conservatory, Nursery, and Prayer Room">Extra Room Types Add-on</span>.</strong> Upgrade your account to use this room type.</p>
                    </div>
                    <div class="modal_footer_content">
                        <button class="card-submit modal_footer_button" data-fsc-item-path='homedesignsai-extra-room-types' data-fsc-item-path-value='homedesignsai-extra-room-types' data-fsc-action="Add, Checkout" onclick="hideCred()">Upgrade Your Account</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div id="hdaLoaderOuter" class="justify-content-center align-items-center">
            <div class="hda-inner text-center">
                <div class="hda-loader"></div>
                <p class="hda-loader-message">
                    Do not refresh page. We are processing your order.
                </p>
            </div>
        </div>

        <div id="modalDailyFairUsage" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hdc-modal">

                    <div class="head">
                        <h5 class="modal-title">Fair usage policy limit reached!</h5>
                    </div>

                    <div class="body">
                        <p>
                            You've hit the fair usage policy limit for your subscription! New generations are disabled
                            for 24 hours. To continue using our service without restriction, please contact our support
                            team for additional verifications: help@homedesigns.ai
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @include('web.common.design-preview')


    </main>
    <?php
    $active_plan = '';
    ?>

    <script>
        const SITE_BASE_URL = "{{ config('app.url') }}";
        const APP_LOCAL = "{{ config('app.env') }}";
    </script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/wow.min.js') }}"></script>
    <script src="{{ asset('web/js/script.js') }}?v={{ config('app.script_js_version') }}"></script>
    <script src="{{ asset('web/js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('web/js/custom-script.js') }}?v={{ config('app.custom_script_version') }}"></script>
    <script src="{{ asset('web/js/jquery-ui.js') }}"></script>

    <script>
        // Webview check and hide the Google Login button
        function isFacebookInAppBrowser() {
            // Check for Facebook in-app browser
            return navigator.userAgent.includes("FBAN") || navigator.userAgent.includes("FBAV");
        }

        function isInstagramInAppBrowser() {
            // Check for Instagram in-app browser
            return navigator.userAgent.includes("Instagram");
        }

        function isTikTokInAppBrowser() {
            const userAgent = navigator.userAgent.toLowerCase();
            return userAgent.indexOf('tiktok') !== -1 || userAgent.indexOf('bytedance') !== -1;
        }

        function isPinterestInAppBrowser() {
            // Check for Pinterest in-app browser
            return navigator.userAgent.includes("Pinterest");
        }
        let isPinterestInAppBrowserPattern = /pinterest\.com/.test(window.location.href);

        function isWebView() {
            // Check for WebView on Android
            if (navigator.userAgent.match(/Android/) && !navigator.userAgent.match(/Chrome/)) {
                return true;
            }

            // Check for WebView on iOS
            if (navigator.userAgent.match(/iPhone|iPad|iPod/) && !navigator.userAgent.match(/Safari/)) {
                return true;
            }

            // Check for Facebook in-app browser
            if (isFacebookInAppBrowser()) {
                $(".facebook-login-button").removeClass('d-none');
                return true;
            }

            // Check for Instagram in-app browser
            if (isInstagramInAppBrowser()) {
                $(".facebook-login-button").removeClass('d-none');
                return true;
            }

            // Check for TikTok in-app browser
            if (isTikTokInAppBrowser()) {
                return true;
            }

            // Check for Pinterest in-app browser
            if (isPinterestInAppBrowser() || isPinterestInAppBrowserPattern) {
                return true;
            }

            return false;
        }

        if (isWebView()) {
            // Code to run if the app is running inside a WebView, Facebook in-app browser, Instagram in-app browser, TikTok in-app browser, or Pinterest in-app browser
            $(".facebook-login-button").removeClass('d-none'); //Display FB Login everywhere if you remove this line then FB login will display only on FB's embedded browser.
        } else {
            // Code to run if the app is not running inside a WebView, Facebook in-app browser, Instagram in-app browser, TikTok in-app browser, or Pinterest in-app browser
            $(".google-login-button").removeClass('d-none');
            $(".facebook-login-button").removeClass('d-none');
            console.log('Not running inside a WebView or in-app browser!');
        }
        // End Webview check and hide the Google Login button
    </script>

    <script>
        let homeRedirectSection = '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const user = JSON.parse('@json(auth()->user())');
        const activeplan = '{{$active_plan}}';
        const GPU_SERVER_HOST = "{{ config('app.GPU_SERVER_HOST') }}";
        const API_GPU_SERVER_HOST = "{{ config('app.API_GPU_SERVER_HOST') }}";
        const API_BRONZE_CREDIT = "{{ config('app.API_BRONZE_CREDIT') }}";
        const API_SILVER_CREDIT = "{{ config('app.API_SILVER_CREDIT') }}";
        const API_GOLD_CREDIT = "{{ config('app.API_GOLD_CREDIT') }}";
        const API_SME_CREDIT = "{{ config('app.API_SME_CREDIT') }}";
        const GPU_SERVER_HOST_INIT = "{{ config('app.GPU_SERVER_HOST_INIT')}}";
        const GPU_SERVER_HOST_SEG = "{{ config('app.GPU_SERVER_HOST_SEG')}}";
    </script>

    @yield('scripts')
    @stack('script-stack')
    <script>

        ire('identify', {
            customerid: "{{$customerId}}",
            customeremail: "{{$customerEmail}}"
        });
        // $('[data-toggle="tooltip"]').tooltip();
    </script>
    <script>
        $(".only-mobile").click(function() {
            $(".sidenav").addClass("open-menu");
        });

        $(".closebtn").click(function() {
            $(".sidenav").removeClass("open-menu");
        });
        //Script provided by client
        (() => {
            "use strict";
            var t = {
                    792: (t, e, i) => {
                        i.d(e, {
                            Z: () => n
                        });
                        var s = i(609),
                            o = i.n(s)()(function(t) {
                                return t[1];
                            });
                        o.push([
                            t.id,
                            ':host{--divider-width: 1px;--divider-color: #fff;--divider-shadow: none;--default-handle-width: 50px;--default-handle-color: #fff;--default-handle-opacity: 1;--default-handle-shadow: none;--handle-position-start: 50%;position:relative;display:inline-block;overflow:hidden;line-height:0;direction:ltr}@media screen and (-webkit-min-device-pixel-ratio: 0)and (min-resolution: 0.001dpcm){:host{outline-offset:1px}}::slotted(*){-webkit-user-drag:none;-khtml-user-drag:none;-moz-user-drag:none;-o-user-drag:none;user-drag:none;-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.first{position:absolute;left:0;top:0;right:0;line-height:normal;font-size:100%;max-height:100%;height:100%;width:100%;--exposure: 50%;--keyboard-transition-time: 0ms;--default-transition-time: 0ms;--transition-time: var(--default-transition-time)}.first .first-overlay-container{position:relative;clip-path:inset(0 var(--exposure) 0 0);transition:clip-path var(--transition-time);height:100%}.first .first-overlay{overflow:hidden;height:100%}.first.focused{will-change:clip-path}.first.focused .first-overlay-container{will-change:clip-path}.second{position:relative}.handle-container{transform:translateX(50%);position:absolute;top:0;right:var(--exposure);height:100%;transition:right var(--transition-time),bottom var(--transition-time)}.focused .handle-container{will-change:right}.divider{position:absolute;height:100%;width:100%;left:0;top:0;display:flex;align-items:center;justify-content:center;flex-direction:column}.divider:after{content:" ";display:block;height:100%;border-left-width:var(--divider-width);border-left-style:solid;border-left-color:var(--divider-color);box-shadow:var(--divider-shadow)}.handle{position:absolute;top:var(--handle-position-start);pointer-events:none;box-sizing:border-box;margin-left:1px;transform:translate(calc(-50% - 0.5px), -50%);line-height:0}.default-handle{width:var(--default-handle-width);opacity:var(--default-handle-opacity);transition:all 1s;filter:drop-shadow(var(--default-handle-shadow))}.default-handle path{stroke:var(--default-handle-color)}.vertical .first-overlay-container{clip-path:inset(0 0 var(--exposure) 0)}.vertical .handle-container{transform:translateY(50%);height:auto;top:unset;bottom:var(--exposure);width:100%;left:0;flex-direction:row}.vertical .divider:after{height:1px;width:100%;border-top-width:var(--divider-width);border-top-style:solid;border-top-color:var(--divider-color);border-left:0}.vertical .handle{top:auto;left:var(--handle-position-start);transform:translate(calc(-50% - 0.5px), -50%) rotate(90deg)} .before-text {border-radius: 5px;background: rgba(0, 0, 0, 0.31);top: 82px;left: 23px;min-height: 25px;position: absolute;display: flex;align-items: center;min-width: 70px;justify-content: center;color: #FFF;font-family: Gellix;font-size: 11px;font-style: normal;font-weight: 500;line-height: 12.6px;letter-spacing: 2px;text-transform: uppercase;} .after-text {border-radius: 5px;background: #7558EA;top: 82px;right: 23px;min-height: 25px;position: absolute;display: flex;align-items: center;min-width: 70px;justify-content: center;color: #FFF;font-family: Gellix;font-size: 11px;font-style: normal;font-weight: 500;line-height: 12.6px;letter-spacing: 2px;text-transform: uppercase;} @media (max-width: 991.98px) {.after-text, .before-text{font-size: 12px; top: 50px;}}@media (max-width: 767.98px) {};',
                            "",
                        ]);
                        const n = o;
                    },
                    609: (t) => {
                        t.exports = function(t) {
                            var e = [];
                            return (
                                (e.toString = function() {
                                    return this.map(function(e) {
                                        var i = t(e);
                                        return e[2] ? "@media ".concat(e[2], " {").concat(i,
                                            "}") : i;
                                    }).join("");
                                }),
                                (e.i = function(t, i, s) {
                                    "string" == typeof t && (t = [
                                        [null, t, ""]
                                    ]);
                                    var o = {};
                                    if (s)
                                        for (var n = 0; n < this.length; n++) {
                                            var r = this[n][0];
                                            null != r && (o[r] = !0);
                                        }
                                    for (var a = 0; a < t.length; a++) {
                                        var d = [].concat(t[a]);
                                        (s && o[d[0]]) || (i && (d[2] ? (d[2] = "".concat(i, " and ")
                                            .concat(d[2])) : (d[2] = i)), e.push(d));
                                    }
                                }),
                                e
                            );
                        };
                    },
                },
                e = {};

            function i(s) {
                var o = e[s];
                if (void 0 !== o) return o.exports;
                var n = (e[s] = {
                    id: s,
                    exports: {}
                });
                return t[s](n, n.exports, i), n.exports;
            }
            (i.n = (t) => {
                var e = t && t.__esModule ? () => t.default : () => t;
                return i.d(e, {
                    a: e
                }), e;
            }),
            (i.d = (t, e) => {
                for (var s in e) i.o(e, s) && !i.o(t, s) && Object.defineProperty(t, s, {
                    enumerable: !0,
                    get: e[s]
                });
            }),
            (i.o = (t, e) => Object.prototype.hasOwnProperty.call(t, e)),
            (() => {
                var t = i(792);
                const e = "rendered",
                    s = (t, e) => {
                        const i = t.getBoundingClientRect();
                        let s, o;
                        return "mousedown" === e.type ? ((s = e.clientX), (o = e.clientY)) : ((s = e.touches[0]
                                .clientX), (o = e.touches[0].clientY)), s >= i.x && s <= i.x + i.width && o >= i
                            .y && o <= i.y + i.height;
                    },
                    o = document.createElement("template");
                o.innerHTML =
                    '<div class="second" id="second"><div class="after-text">after</div><slot name="second"><slot name="before"></slot></slot> </div> <div class="first" id="first"> <div class="first-overlay"> <div class="first-overlay-container" id="firstImageContainer"> <div class="before-text">Before</div><slot name="first"><slot name="after"></slot></slot> </div> </div> <div class="handle-container"> <div class="divider"></div> <div class="handle" id="handle"> <slot name="handle"> <img class="handle-image" src="{{ 'web/images/thumb.svg' }}" alt""> </slot> </div> </div> </div> ';
                const n = {
                        ArrowLeft: -1,
                        ArrowRight: 1
                    },
                    r = ["horizontal", "vertical"],
                    a = (t) => ({
                        x: t.touches[0].pageX,
                        y: t.touches[0].pageY
                    }),
                    d = (t) => ({
                        x: t.pageX,
                        y: t.pageY
                    });
                class h extends HTMLElement {
                    constructor() {
                        super(),
                            (this.exposure = this.hasAttribute("value") ? parseFloat(this.getAttribute(
                                "value")) : 50),
                            (this.slideOnHover = !1),
                            (this.slideDirection = "horizontal"),
                            (this.keyboard = "enabled"),
                            (this.isMouseDown = !1),
                            (this.animationDirection = 0),
                            (this.isFocused = !1),
                            (this.handle = !1),
                            (this.onMouseMove = (t) => {
                                if (this.isMouseDown || this.slideOnHover) {
                                    const e = d(t);
                                    this.slideToPage(e);
                                }
                            }),
                            (this.bodyUserSelectStyle = ""),
                            (this.onMouseDown = (t) => {
                                if (this.slideOnHover) return;
                                if (this.handle && !s(this.handleElement, t)) return;
                                t.preventDefault(), window.addEventListener("mousemove", this.onMouseMove),
                                    window.addEventListener("mouseup", this.onWindowMouseUp), (this
                                        .isMouseDown = !0), this.enableTransition();
                                const e = d(t);
                                this.slideToPage(e), this.focus(), (this.bodyUserSelectStyle = window
                                    .document.body.style.userSelect), (window.document.body.style
                                    .userSelect = "none");
                            }),
                            (this.onWindowMouseUp = () => {
                                (this.isMouseDown = !1), (window.document.body.style.userSelect = this
                                    .bodyUserSelectStyle), window.removeEventListener("mousemove", this
                                    .onMouseMove), window.removeEventListener("mouseup", this
                                    .onWindowMouseUp);
                            }),
                            (this.touchStartPoint = null),
                            (this.isTouchComparing = !1),
                            (this.hasTouchMoved = !1),
                            (this.onTouchStart = (t) => {
                                (this.handle && !s(this.handleElement, t)) || ((this.touchStartPoint = a(
                                    t)), this.isFocused && (this.enableTransition(), this.slideToPage(this
                                        .touchStartPoint)));
                            }),
                            (this.onTouchMove = (t) => {
                                if (null === this.touchStartPoint) return;
                                const e = a(t);
                                if (this.isTouchComparing) return this.slideToPage(e), t.preventDefault(), !
                                    1;
                                if (!this.hasTouchMoved) {
                                    const i = Math.abs(e.y - this.touchStartPoint.y),
                                        s = Math.abs(e.x - this.touchStartPoint.x);
                                    if (("horizontal" === this.slideDirection && i < s) || ("vertical" ===
                                            this.slideDirection && i > s)) return (this.isTouchComparing = !
                                            0), this.focus(), this.slideToPage(e), t.preventDefault(), !
                                        1;
                                    this.hasTouchMoved = !0;
                                }
                            }),
                            (this.onTouchEnd = () => {
                                (this.isTouchComparing = !1), (this.hasTouchMoved = !1), (this
                                    .touchStartPoint = null);
                            }),
                            (this.onBlur = () => {
                                this.stopSlideAnimation(), (this.isFocused = !1), this.firstElement
                                    .classList.remove("focused");
                            }),
                            (this.onFocus = () => {
                                (this.isFocused = !0), this.firstElement.classList.add("focused");
                            }),
                            (this.onKeyDown = (t) => {
                                if ("disabled" === this.keyboard) return;
                                const e = n[t.key];
                                this.animationDirection !== e && void 0 !== e && ((this.animationDirection =
                                    e), this.startSlideAnimation());
                            }),
                            (this.onKeyUp = (t) => {
                                if ("disabled" === this.keyboard) return;
                                const e = n[t.key];
                                void 0 !== e && this.animationDirection === e && this.stopSlideAnimation();
                            }),
                            (this.resetDimensions = () => {
                                (this.imageWidth = this.offsetWidth), (this.imageHeight = this
                                .offsetHeight);
                            });
                        const e = this.attachShadow({
                                mode: "open"
                            }),
                            i = document.createElement("style");
                        (i.innerHTML = t.Z),
                        this.getAttribute("nonce") && i.setAttribute("nonce", this.getAttribute("nonce")),
                            e.appendChild(i),
                            e.appendChild(o.content.cloneNode(!0)),
                            (this.firstElement = e.getElementById("first")),
                            (this.secondElement = e.getElementById("second")),
                            (this.handleElement = e.getElementById("handle"));
                    }
                    get value() {
                        return this.exposure;
                    }
                    set value(t) {
                        const e = parseFloat(t);
                        e !== this.exposure && ((this.exposure = e), this.enableTransition(), this
                        .setExposure());
                    }
                    get hover() {
                        return this.slideOnHover;
                    }
                    set hover(t) {
                        (this.slideOnHover = "false" !== t.toString().toLowerCase()), this.removeEventListener(
                            "mousemove", this.onMouseMove), this.slideOnHover && this.addEventListener(
                            "mousemove", this.onMouseMove);
                    }
                    get direction() {
                        return this.slideDirection;
                    }
                    set direction(t) {
                        (this.slideDirection = t.toString().toLowerCase()), this.slide(0), this.firstElement
                            .classList.remove(...r), r.includes(this.slideDirection) && this.firstElement
                            .classList.add(this.slideDirection);
                    }
                    static get observedAttributes() {
                        return ["hover", "direction"];
                    }
                    connectedCallback() {
                        this.hasAttribute("tabindex") || (this.tabIndex = 0),
                            this.addEventListener("dragstart", (t) => (t.preventDefault(), !1)),
                            new ResizeObserver(this.resetDimensions).observe(this),
                            this.setExposure(0),
                            (this.keyboard = this.hasAttribute("keyboard") && "disabled" === this.getAttribute(
                                "keyboard") ? "disabled" : "enabled"),
                            this.addEventListener("keydown", this.onKeyDown),
                            this.addEventListener("keyup", this.onKeyUp),
                            this.addEventListener("focus", this.onFocus),
                            this.addEventListener("blur", this.onBlur),
                            this.addEventListener("touchstart", this.onTouchStart, {
                                passive: !0
                            }),
                            this.addEventListener("touchmove", this.onTouchMove, {
                                passive: !1
                            }),
                            this.addEventListener("touchend", this.onTouchEnd),
                            this.addEventListener("mousedown", this.onMouseDown),
                            (this.handle = this.hasAttribute("handle")),
                            (this.hover = !!this.hasAttribute("hover") && this.getAttribute("hover")),
                            (this.direction = this.hasAttribute("direction") ? this.getAttribute("direction") :
                                "horizontal"),
                            this.resetDimensions(),
                            this.classList.contains(e) || this.classList.add(e),
                            this.querySelectorAll('[slot="before"], [slot="after"]').length > 0 &&
                            console.warn(
                                '<img-comparison-slider>: slot names "before" and "after" are deprecated and soon won\'t be supported. Please use slot="first" instead of slot="after", and slot="second" instead of slot="before".'
                                );
                    }
                    disconnectedCallback() {
                        this.transitionTimer && window.clearTimeout(this.transitionTimer);
                    }
                    attributeChangedCallback(t, e, i) {
                        "hover" === t && (this.hover = i), "direction" === t && (this.direction = i),
                            "keyboard" === t && (this.keyboard = "disabled" === i ? "disabled" : "enabled");
                    }
                    setExposure(t = 0) {
                        var e;
                        (this.exposure = (100, (e = this.exposure + t) < 0 ? 0 : e > 100 ? 100 : e)), this
                            .firstElement.style.setProperty("--exposure", 100 - this.exposure + "%");
                    }
                    slide(t = 0) {
                        this.setExposure(t);
                        const e = new Event("slide");
                        this.dispatchEvent(e);
                    }
                    slideToPage(t) {
                        "horizontal" === this.slideDirection && this.slideToPageX(t.x), "vertical" === this
                            .slideDirection && this.slideToPageY(t.y);
                    }
                    slideToPageX(t) {
                        const e = t - this.getBoundingClientRect().left - window.scrollX;
                        (this.exposure = (e / this.imageWidth) * 100), this.slide(0);
                    }
                    slideToPageY(t) {
                        const e = t - this.getBoundingClientRect().top - window.scrollY;
                        (this.exposure = (e / this.imageHeight) * 100), this.slide(0);
                    }
                    enableTransition() {
                        this.firstElement.style.setProperty("--transition-time", "100ms"),
                            (this.transitionTimer = window.setTimeout(() => {
                                this.firstElement.style.setProperty("--transition-time",
                                    "var(--default-transition-time)"), (this.transitionTimer = null);
                            }, 100));
                    }
                    startSlideAnimation() {
                        let t = null,
                            e = this.animationDirection;
                        this.firstElement.style.setProperty("--transition-time",
                            "var(--keyboard-transition-time)");
                        const i = (s) => {
                            if (0 === this.animationDirection || e !== this.animationDirection) return;
                            null === t && (t = s);
                            const o = ((s - t) / 16.666666666666668) * this.animationDirection;
                            this.slide(o), setTimeout(() => window.requestAnimationFrame(i), 0), (t = s);
                        };
                        window.requestAnimationFrame(i);
                    }
                    stopSlideAnimation() {
                        (this.animationDirection = 0), this.firstElement.style.setProperty("--transition-time",
                            "var(--default-transition-time)");
                    }
                }
                "undefined" != typeof window && window.customElements.define("img-comparison-slider", h);
            })();
        })();
        //# sourceMappingURL=index.js.map
        //End Script provided by client
    </script>

    <script type="text/javascript">
        $productFruits.push(['init', 'jz7YULFHbhRincAX', 'en', { username: '{{$customerName}}' }]);
    </script>
</body>

</html>
