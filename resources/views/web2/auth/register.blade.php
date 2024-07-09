@extends('web2.layout.app-blank')

@section('page_title', 'HomeDesignsAI - Register New Account')

@section('head')
    @include('web.meta.meta_head_register')
    <style>
        .loginbutt {
            border-color: #1E1634 !important;
            background-color: #1E1634 !important;
            color: white !important;
        }
    </style>
    {!! RecaptchaV3::initJs() !!}
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
                <a href="{{ url('/') }}"><img src="{{ asset('web2/images/logo-icon.svg') }}"></a>
                <h1>Welcome to <span>HomeDesignAI</span></h1>
                <p>Register to start creating magic.</p>
                <form action="{{ url('register') }}" method="post" id="userRegistrationForm">
                    <input type="hidden" name="current_url" value="{{ $source }}">
                    @if ($errors->has('g-recaptcha-response'))
                        <div>
                            <span class="text-danger">Recaptcha verification failed.</span>
                        </div>
                    @endif

                    @csrf
                    <div class="gs-login-form-icon">
                        <input type="text" class="gs-edit-setting-field gs-edit-setting-name-field" placeholder="Name"
                            value="{{ old('name', '') }}" name="name">
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block d-block">{{ $errors->first('name') }}</span>
                    @endif
                    <div class="gs-login-form-icon">
                        <img src="{{ asset('web2/images/gs-edit-setting-email-field.svg') }}">
                        <input type="email" class="gs-edit-setting-field gs-edit-setting-email-field" placeholder="Email"
                            value="{{ old('email', '') }}" name="email">
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block d-block">{{ $errors->first('email') }}</span>
                    @endif
                    <div class="gs-login-form-icon view-icon-password">
                        <img src="{{ asset('web2/images/gs-edit-setting-password-field.svg') }}">
                        <input type="password" class="gs-edit-setting-field gs-edit-setting-password-field password-field"
                            placeholder="Password" name="password">
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <img src="{{ asset('web2/images/show_password_icon.png') }}" id="password-toggle-icon">
                        </span>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block d-block">{{ $errors->first('password') }}</span>
                    @endif

                    <div class="gs-login-brn-outer" id="button_container">
                        <input type="submit" class="gs-login-btn g-recaptcha" value="Register">
                    </div>
                    {!! RecaptchaV3::field('register') !!}
                </form>
                <div class="gs-login-continue">
                    <p><span>or continue with</span></p>
                    <div class="gs-login-continue-google">
                        <a href="{{ route('login.google') }}"><img
                                src="{{ asset('web2/images/login-continue-google.svg') }}"></a>
                        <a href="{{ url('auth/facebook') }}"><img
                                src="{{ asset('web2/images/login-continue-apple.svg') }}"></a>
                    </div>
                </div>
                <div class="gs-login-remeber-login">
                    <div class="gs-login-forgot-passwrd">Already have an Account?
                        <a href="{{ route('login') }}">Sign In</a>
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
            $("#userRegistrationForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50,
                        regex: /^[a-zA-Z\s]+$/
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                        regex: /^[\w\.\-]+@[a-zA-Z\d\-]+\.[a-zA-Z]{1,4}$/
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 25
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name.",
                        maxlength: "Your name must be less than 50 characters.",
                        regex: "Your name must contain only letters and spaces."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                        maxlength: "Your email must be less than 255 characters.",
                        regex: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Your password must be at least 6 characters long.",
                        maxlength: "Your password must be less than 25 characters."
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

            // Add custom validation method for regex
            $.validator.addMethod("regex", function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            }, "Please check your input.");
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
