@extends('web2.layout.app-blank')

@section('page_title', 'HomeDesignsAI - Verify email')

@section('head')
    <!-- Meta for the page start -->
    @include('web.layout.meta_head')
    <!-- Meta for the page end -->
    <style>
        .loginbutt {
            border-color: #1E1634 !important;
            background-color: #1E1634 !important;
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="gs-dashboard-wrpper">
        <div class="gs-login-left">
            <div id="marqueeContainer">
                <div id="marqueeWrapper">
                    <div class="login-tesimonial-wrapper">
                        @include('web2.common.user-testimonials')
                    </div>

                </div>
            </div>
        </div>
        <div class="gs-login-right">
            <div class="gs-login-form gs-register-form">
                <a href="#"><img src="{{ asset('web2/images/logo-icon.svg') }}"></a>
                <h1>Welcome to <span>HomeDesignAI</span></h1>
                <p>We have send you an email on {{Auth::user()->email ?? ""}}. Please check your inbox.</p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div class="gs-login-brn-outer" style="margin-bottom: 20px;">
                        <input type="submit" class="gs-login-btn" value="Resend Verification Email">
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="gs-login-brn-outer">
                        <input type="submit" class="gs-login-btn" value="Log Out">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
