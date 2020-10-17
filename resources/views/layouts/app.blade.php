<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIONIL | Sistem Olah Nilai SMP Islamic Mumtaz</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('admin-lte\plugins\fontawesome-free\css\all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-lte\plugins\tempusdominus-bootstrap-4\css\tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte\plugins\icheck-bootstrap\icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte\plugins\jqvmap\jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte\plugins\overlayScrollbars\css\OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte\plugins\icheck-bootstrap\icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte\plugins\toastr\toastr.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>
    <div id="app">
        <nav class="main-header navbar navbar-expand navbar-primary navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="av-item d-none d-sm-inline-block">
                    <a href="{{ url('/') }}" class="nav-link">
                        Home</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
                <img src="{{ asset('/images/logo_mumtazajhs.png') }}" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/images/admin.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/matapelajaran" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Mata Pelajaran
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/guru" class="nav-link">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                   Guru
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/jenjang" class="nav-link">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <p>
                                    Jenjang
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/siswa" class="nav-link">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Siswa
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/kelas" class="nav-link">
                                <i class="nav-icon fas fa-chalkboard"></i>
                                <p>
                                    Kelas
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/tahunakademik" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Tahun Akademik
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/jadwalpelajaran" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>
                                    Jadwal Pelajaran
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item ">
                            <a href="/ruangan" class="nav-link">
                                <i class="nav-icon fas fa-door-closed"></i>
                                <p>
                                    Ruangan
                                </p>
                            </a>
    
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside>

        

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- App scripts -->
    @stack('scripts')

</body>

</html>