@extends('web2.layout.app-blank')

@section('page_title', 'HomeDesignsAI - Reset Password')

@section('head')
    @include('web.meta.meta_head_forgot_password')
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
                @if (session('status'))
                    <div class="alert alert-success email-password-reset" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm">
                    @csrf
                    <div class="gs-login-form-icon">
                        <img src="{{ asset('web2/images/gs-edit-setting-email-field.svg') }}">
                        <input type="email" class="gs-edit-setting-field gs-edit-setting-email-field" placeholder="Email" value="{{ old('email') }}" name="email">
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block d-block">{{ $errors->first('email') }}</span>
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
    {{-- <div>
        <section>
            <div class="dashboard">
                <div class="text-center">
                    <div style="background-color:#1E1634;height: 100vh;">
                        <div style="height: 110px;"></div>
                        <div class="modallog" style="height: 600px">

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="bckg">
                                    <a href="{{ url('/') }}">
                                        <span class="close pad" style="color:#1E1634;">&times;</span>
                                    </a>
                                    <div class="logintext pad">Reset Password</div>
                                    <br>
                                    <div>
                                        <input class="file-options3" type="email" name="email" placeholder="Email"
                                            value="{{ old('email') }}">

                                        @if ($errors->has('email'))
                                            <span class="help-block d-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <br>
                                    <div id="button_container" class="menu pad">
                                        <button class="loginbutt selected _disable_on_submit"
                                            style="border-color: #1E1634; background-color: #1E1634; color:white">
                                            Reset Password
                                        </button>
                                    </div>
                                    <br>
                                    <p class="message">Already have an Account? <a href="{{ route('login') }}">Sign In</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
        </section>
    </div> --}}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#passwordResetForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                        regex: /^[\w\.\-]+@[a-zA-Z\d\-]+\.[a-zA-Z]{1,4}$/
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                        maxlength: "Your email must be less than 255 characters.",
                        regex: "Please enter a valid email address."
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
