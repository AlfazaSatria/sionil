<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIONIL | Sistem Olah Nilai SMP Islam Mumtaza</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #00404F;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class=" m-b-md text-light">
                    <h1 class="font-weight-bold ">SISTEM OLAH NILAI</h1> 
                    <img src="{{ asset('/images/logo_mumtazajhs.png') }}" class="logo">
                </div>
              
                <div class="container">
                    <a href="walas/login" class="btn btn-info text-light btn-lg font-weight-bold"><i class="fas fa-users"></i> Login Wali Kelas</a>
                    <a href="/siswa/login" class="btn btn-danger text-light btn-lg font-weight-bold"><i class="fas fa-user-graduate"></i> Login Siswa</a>
                    <a href="/guru/login" class="btn btn-success text-light btn-lg font-weight-bold"><i class="fas fa-chalkboard-teacher"></i> Login Guru </a>
                </div>
            </div>
        </div>
    </body>
</html>

<style>
    .logo{
        width: 50em;
    }
</style>