<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
        integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <title>SIONIL | Sistem Olah Nilai SMP Islamic Mumtaz</title>
</head>

<body>
    <div class="body">
        <div class="content">
            <form method="POST" action="/konseling/login" aria-label="{{ __('Login') }}">
                @csrf
                <div style="text-align:center;margin-bottom:3px;">
                    <img src="{{ asset('/images/LogoMumtaza.png') }}">
                </div>
                <div class="alert alert-danger" id="alert-login" style="text-align:center;/* margin-bottom: 0; */">
                    Masukkan Email dan Password </div>
                <div class="form-group row">


                    <input id="email" type="email" placeholder="Email"
                        class="mt-4 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                </div>

                <div class="form-group row">


                    <input id="password" type="password" placeholder="Password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif

                </div>

                <div class="form-actions" style="text-align:left">
                    <div class="form-group row mb-0">

                        <button type="submit" class="btn btn-success">
                            {{ __('LOGIN') }}
                            <i class="fa fa-arrow-right"></i>
                        </button>

                        {{-- <a class="forget-password" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                        </a> --}}

                    </div>
                </div>
                <div class="footer" style="color:#FFFFFF;font-weight:bold">
                    2020 © Sistem Olah Nilai - 2
                </div>
            </form>

        </div>
    </div>
</body>

</html>







<style>
    html,
    body {
        background-color: #00404F;
        color: #636b6f;

        height: 100vh;
        margin: 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn-success {
        color: #fff;
        background-color: #45B6AF;
        border-color: #3ea49d;
        padding: 10px 20px !important;
    }



    .content {
        background-color: #eceef1;
        -webkit-border-radius: 7px;
        -moz-border-radius: 7px;
        -ms-border-radius: 7px;
        -o-border-radius: 7px;
        border-radius: 7px;
        width: 400px;
        margin: 40px auto 10px auto;
        padding: 30px;
        padding-top: 10px;
        overflow: hidden;
        position: relative;
    }

    .content .form-control {
        border: none;
        background-color: #dde3ec;
        height: 43px;
        color: #8290a3;
        border: 1px solid #dde3ec;
    }

    .content .form-actions {
        clear: both;
        border: 0px;
        border-bottom: 1px solid #eee;
        padding: 0px 30px 25px 30px;
        margin-left: -30px;
        margin-right: -30px;
    }

    /* .content .forget-password {
        font-size: 14px;
        float: right;
        display: inline-block;
        margin-top: 10px;
    } */

    .content .footer {
        margin: 0 -40px -40px -40px;
        padding: 15px 0 17px 0;
        text-align: center;
        background-color: #6c7a8d;
        -webkit-border-radius: 0 0 7px 7px;
        -moz-border-radius: 0 0 7px 7px;
        -ms-border-radius: 0 0 7px 7px;
        -o-border-radius: 0 0 7px 7px;
        border-radius: 0 0 7px 7px;
    }
</style>