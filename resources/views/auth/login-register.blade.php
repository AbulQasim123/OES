@extends('layout/layout-common')
@section('layout-master')
<link rel="stylesheet" href="{{ asset('assets\css\customstyle.css') }}">
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <!--<img src="images/frontImg.jpg" alt="">-->
            <div class="text">
                <span class="text-1">Every new Students is a <br> new adventure</span>
                <span class="text-2">Let's get connected</span>
            </div>
        </div>
        <div class="back">
            <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
            <div class="text">
                <span class="text-1">Complete miles of journey <br> with one step</span>
                <span class="text-2">Let's get started</span>
            </div>
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible" id="result">
                    <a href="" class="close" data-dismiss="alert">&times;</a>
                    {{ Session::get('error') }}
                </div>
                @endif
                <div class="title text-primary">Login</div>
                <form action="{{ route('login') }}" id="login_form" method="post">
                    @csrf
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="email" id="email" placeholder="Enter your email">
                        </div>
                        @if($errors->has('email'))
                        <pre class="error my-1 name_err">{{ $errors->first('email') }}</pre>
                        @endif

                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Enter your password">
                        </div>
                        @if($errors->has('password'))
                        <pre class="error my-1 name_err">{{ $errors->first('password') }}</pre>
                        @endif

                        <div class="text"><a href="/forget-password">Forgot password?</a></div>
                        <div class="button input-box">
                            <input type="submit" value="Sumbit">
                        </div>
                        <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup now</label></div>
                    </div>
                </form>
            </div>
            <div class="signup-form">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" id="result">
                    <a href="" class="close" data-dismiss="alert">&times;</a>
                    {{ Session::get('success') }}
                </div>
                @endif

                <div class="title">Signup</div>
                <form action="{{ route('register') }}" id="register_form" method="post">
                    @csrf
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" id="name" placeholder="Enter your name">
                        </div>
                        @if($errors->has('name'))
                        <pre class="error my-1 name_err">{{ $errors->first('name') }}</pre>
                        <!-- <style>
                            .name{
                                border: 1px solid red;
                            }
                        </style> -->
                        @endif

                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="email" id="email" placeholder="Enter your email">
                        </div>
                        @if($errors->has('email'))
                        <pre class="error my-1 email_err">{{ $errors->first('email') }}</pre>
                        @endif

                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <label for="password" style="display: none">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter your password">
                        </div>
                        @if($errors->has('password'))
                        <pre class="error my-1 password_err">{{ $errors->first('password') }}</pre>
                        @endif

                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <label for="conf_pass" style="display: none;">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="conf_pass" placeholder="Enter Confirm Password">
                        </div>
                        @if($errors->has('password_confirmation'))
                        <pre class="error my-1 conf_pass_err">{{ $errors->first('password_confirmation') }}</pre>
                        @endif

                        <div class="button input-box">
                            <input type="submit" value="Sumbit">
                        </div>
                        <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
<script>
    
</script>
@endsection