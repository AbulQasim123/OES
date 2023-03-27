@extends('layout/layout-common')
@section('layout-master')

<style>
    .mainDiv {
        display: flex;
        min-height: 100%;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        font-family: 'Open Sans', sans-serif;
    }

    .cardStyle {
        width: 500px;
        border-color: white;
        background: #fff;
        padding: 36px 0;
        border-radius: 4px;
        margin: 30px 0;
        box-shadow: 0px 0 2px 0 rgba(0, 0, 0, 0.25);
    }

    #signupLogo {
        max-height: 100px;
        margin: auto;
        display: flex;
        flex-direction: column;
    }

    .formTitle {
        font-weight: 600;
        margin-top: 20px;
        color: #2F2D3B;
        text-align: center;
    }

    .inputLabel {
        font-size: 12px;
        color: #555;
        margin-bottom: 6px;
        margin-top: 24px;
    }

    .inputDiv {
        width: 70%;
        display: flex;
        flex-direction: column;
        margin: auto;
    }

    input {
        height: 40px;
        font-size: 16px;
        border-radius: 4px;
        border: none;
        border: solid 1px #ccc;
        padding: 0 11px;
    }

    input:disabled {
        cursor: not-allowed;
        border: solid 1px #eee;
    }

    .buttonWrapper {
        margin-top: 40px;
    }

    .submitButton {
        width: 70%;
        height: 40px;
        margin: auto;
        display: block;
        color: #fff;
        background-color: #065492;
        border-color: #065492;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .error {
        color: red;
    }
    .alert{
        text-align: center;
    }
</style>
<div class="mainDiv">
    <div class="cardStyle">
        <form action="{{ route('ResetPassword') }}" method="post">
            @csrf
            <h2 class="formTitle">Reset Your Password</h2>
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible" id="result">
                <a href="" class="close" data-dismiss="alert">&times;</a>
                {{ Session::get('error') }}
            </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-danger alert-dismissible" id="result">
                <a href="" class="close" data-dismiss="alert">&times;</a>
                {{ Session::get('success') }}
            </div>
            @endif
            <div class="inputDiv">
                <input type="hidden" name="resetid" value="{{ $resetuser[0]['id'] }}">
                <label class="inputLabel" for="old_password">Old Password</label>
                <input type="password" id="old_password" name="old_password">
                @if($errors->has('old_password'))
                    <pre class="error my-1 user_email">{{ $errors->first('old_password') }}</pre>
                @endif
            </div>

            <div class="inputDiv">
                <label class="inputLabel" for="password">New Password</label>
                <input type="password" id="password" name="password">
                @if($errors->has('password'))
                <pre class="error my-1 user_email">{{ $errors->first('password') }}</pre>
                @endif
            </div>

            <div class="inputDiv">
                <label class="inputLabel" for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="password_confirmation">
                @if($errors->has('password_confirmation'))
                <pre class="error my-1 user_email">{{ $errors->first('password_confirmation') }}</pre>
                @endif
            </div>

            <div class="buttonWrapper">
                <button type="submit" id="submitButton" class="submitButton pure-button pure-button-primary">
                    <span>Continue</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection