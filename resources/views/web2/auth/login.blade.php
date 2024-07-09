@extends('web2.layout.app-blank')

@section('page_title', 'HomeDesignsAI - Login to your account')

@section('head')
    @include('web.meta.meta_head_login')
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
            <div class="gs-login-form">
                <a href="{{ url('/') }}"><img src="{{ asset('web2/images/logo-icon.svg') }}"></a>
                <h1>Welcome to <span>HomeDesignAI</span></h1>
                <p>Log in to to start creating magic.</p>
                <form autocomplete="off" action="{{ url('login') }}" method="post" id="userLoginForm">
                    @csrf
                    <div class="gs-login-form-icon">
                        <img src="{{ asset('web2/images/gs-edit-setting-email-field.svg') }}">
                        <input type="email" name="email" class="gs-edit-setting-field" placeholder="Email" id="email" value="{{ old('email', '') }}">
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block d-block">{{ $errors->first('email') }}</span>
                    @endif
                    <div class="gs-login-form-icon view-icon-password">
                        <img src="{{ asset('web2/images/gs-edit-setting-password-field.svg') }}">
                        <input name="password" type="password" id="password" class="gs-edit-setting-field password-field" placeholder="Password">
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <img src="{{ asset('web2/images/show_password_icon.png') }}" id="password-toggle-icon">
                        </span>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block d-block">{{ $errors->first('password') }}</span>
                    @endif
                    <div class="gs-login-remeber-login">
                        <div class="gs-login-remeber-me">
                            <input type="checkbox">
                            <span></span>
                            <label>Remember me</label>
                        </div>
                        <div class="gs-login-forgot-passwrd">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="gs-login-brn-outer" id="button_container">
                        <input type="submit" class="gs-login-btn loginbutt selected _disable_on_submit" value="Log in">
                    </div>
                </form>
                <div class="gs-login-continue">
                    <p><span>or continue with</span></p>
                    <div class="gs-login-continue-google">
                        <a href="{{ route('login.google') }}" class="google-login-button d-none"><img
                                src="{{ asset('web2/images/login-continue-google.svg') }}"></a>
                        <a href="{{ url('auth/facebook') }}" class="facebook-login-button d-none"><img
                                src="{{ asset('web2/images/login-continue-apple.svg') }}"></a>
                    </div>
                </div>
                <div class="gs-login-remeber-login">
                    <div class="gs-login-create-account">Not registered?
                        <a href="{{ route('register') }}">Create an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#userLoginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please enter your password.",
                    }
                },
                errorElement: "span",
                errorClass: "help-block d-block",
                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.gs-login-form-icon').addClass('has-error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.gs-login-form-icon').removeClass('has-error');
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        function togglePasswordVisibility() {
            const passwordField = document.querySelector('.password-field');
            const passwordToggleIcon = document.getElementById('password-toggle-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordToggleIcon.src =
                "{{ asset('web2/images/hide_password_icon.png') }}"; // Update this to your hide icon
            } else {
                passwordField.type = 'password';
                passwordToggleIcon.src =
                "{{ asset('web2/images/show_password_icon.png') }}"; // Update this to your view icon
            }
        }
    </script>
@endsection
