<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', 'HomeDesignsAI')</title>
    {{-- <link rel="shortcut icon" href="{{ asset('web2/images/favicon.ico') }}" type="image/x-icon" /> --}}
    {{-- New css starts --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web2/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('web2/css/jquery-ui.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Kalam&display=swap" rel="stylesheet">
    <link href="{{ asset('web2/css/stylesheet.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('web2/css/style.css') }}?v={{ config('app.style_css_version') }}">
    <link href="{{ asset('web2/css/responsive.css') }}" rel="stylesheet" type="text/css">
    {{-- new css ends --}}

    <link rel="preconnect" href="https://stijndv.com">
    <link rel="stylesheet" href="https://stijndv.com/fonts/Eudoxus-Sans.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Kalam&family=Karla&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Tag Manager (script) start -->
    @include('web.layout.google_tag_manager')
    <!-- Google Tag Manager (script) start -->

    @yield('head')

    <style>
        body {
            background-color: #1E1634;
        }
    </style>
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

</head>
@php
    $customer = auth()->user();
    if ($customer) {
        $customerId = $customer->id;
        $customerEmail = sha1($customer->email);
    } else {
        $customerId = '';
        $customerEmail = '';
    }
    session(['source' => Request::path()]);
@endphp

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K4VHLCT" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <main id="">


        @yield('content')


        @if (auth()->check())
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
            </form>
        @endif

        @include('web.common.design-preview')
    </main>

    <script>
        const SITE_BASE_URL = "{{ config('app.url') }}";
        const APP_LOCAL = "{{ config('app.env') }}";
    </script>
    {{-- new js --}}
    <script src="{{ asset('web2/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web2/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web2/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('web2/js/slick.min.js') }}"></script>
    <script src="{{ asset('web2/js/after-before.js') }}"></script> 
    <script src="{{ asset('web2/js/custom.js') }}"></script> 
    {{-- new js ends --}}
 
    {{-- <script src="{{ asset('web/js/wow.min.js') }}"></script>
    <script src="{{ asset('web/js/script.js') }}?v={{ config('app.script_js_version') }}"></script>
    <script src="{{ asset('web/js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('web/js/custom-script.js') }}?v={{ config('app.custom_script_version') }}"></script> --}}

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

        function isPinterestInAppBrowser() {
            // Check for Pinterest in-app browser
            return navigator.userAgent.includes("Pinterest");
        }

        function isTikTokInAppBrowser() {
            const userAgent = navigator.userAgent.toLowerCase();
            return userAgent.indexOf('tiktok') !== -1 || userAgent.indexOf('bytedance') !== -1;
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
    </script>

    <script>
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
    <script>
        ire('identify', {
            customerid: "{{$customerId}}",
            customeremail: "{{$customerEmail}}"
        });
    </script>
</body>

</html>
