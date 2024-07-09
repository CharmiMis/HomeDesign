@extends('web2.layout.app-blank')

@section('page_title', 'HomeDesignsAI - Reset Password')

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
                <a href="{{ url('/') }}"><img src="{{ asset('web2/images/logo-icon.svg') }}"></a>
                <h1>Welcome to <span>HomeDesignAI</span></h1>
                <p>Reset Password</p>
                <form method="POST" action="{{ route('password.store') }}" id="passwordResetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="email" class="gs-edit-setting-field gs-edit-setting-email-field" name="email" placeholder="Email"
                            value="{{ old('email', $request->email) }}">
                    @if ($errors->has('email'))
                        <span class="help-block d-block">{{ $errors->first('email') }}</span>
                    @endif
                    <input type="password" class="gs-edit-setting-field gs-edit-setting-password-field"
                        placeholder="Password" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block d-block">{{ $errors->first('password') }}</span>
                    @endif
                    <input type="password" class="gs-edit-setting-field gs-edit-setting-password-field"
                        placeholder="Confirm Password" name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block d-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                    <div class="gs-login-brn-outer">
                        <input type="submit" class="gs-login-btn" value="Reset Password">
                    </div>
                </form>

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
            $("#resetPasswordForm").validate({
                rules: {
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
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "[name='password']"
                    }
                },
                messages: {
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
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Your passwords do not match."
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
    </script>
@endsection
