@extends('layout/layout-common')
@section('layout-master')


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "segoe ui", verdana, helvetica, arial, sans-serif;
        font-size: 16px;
        transition: all 500ms ease;
    }

    .row {
        background-color: #535c68;
        color: #fff;
        text-align: center;
        padding: 2em 2em 0.5em;
        width: 100%;
        margin: 2em auto;
        border-radius: 5px;
    }

    .row h1 {
        font-size: 2.5em;
    }

    .row .form-group {
        margin: 0.5em 0;
    }

    .row .form-group label {
        display: block;
        color: #fff;
        text-align: left;
        font-weight: 600;
    }

    .row .form-group input,
    .row .form-group button {
        display: block;
        padding: 0.5em 0;
        width: 100%;
        margin-top: 1em;
        margin-bottom: 0.5em;
        background-color: inherit;
        border: none;
        border-bottom: 1px solid #555;
        color: #eee;
    }

    .row .form-group input:focus,
    .row .form-group button:focus {
        background-color: #fff;
        color: #000;
        border: none;
        padding: .5em 0.5em;
        animation: pulse 1s infinite ease;
    }

    .row .form-group button {
        border: 1px solid #fff;
        border-radius: 5px;
        outline: none;
        -moz-user-select: none;
        user-select: none;
        color: #333;
        font-weight: 800;
        cursor: pointer;
        margin-top: 2em;
        padding: 1em;
    }

    .row .form-group button:hover,
    .row .form-group button:focus {
        background-color: #fff;
    }

    .information-text {
        color: #ddd;
    }

    @media screen and (max-width: 320px) {
        .row {
            padding-left: 1em;
            padding-right: 1em;
        }

        .row h1 {
            font-size: 1.5em !important;
        }
    }

    @media screen and (min-width: 900px) {
        .row {
            width: 50%;
        }
    }

    .error{
        color: red;
        font-size: 18px;
        margin-right: 120px;
    }
</style>
<div class="container">
    <div class="row">
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" id="result">
            <a href="" class="close" data-dismiss="alert">&times;</a>
            {{ Session::get('error') }}
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" id="result">
            <a href="" class="close" data-dismiss="alert">&times;</a>
            {{ Session::get('success') }}
        </div>
        @endif
        <h4>Forgot Password</h4>
        <h6 class="information-text">Enter your registered email to reset your password.</h6>
        <form action="{{ route('ForgetPassword') }}" method="post">
            @csrf
            <div class="form-group">
                <p><label for="username">Email</label></p>
                <input type="text" name="user_email" id="user_email" style="width: 300px" placeholder="Enter Your Email">
                @if($errors->has('user_email'))
                <pre class="error my-1 user_email">{{ $errors->first('user_email') }}</pre>
                @endif
                <button>Reset Password</button>
            </div>
        </form>
    </div>

</div>

@endsection