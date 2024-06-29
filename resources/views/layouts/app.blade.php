<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>  
   
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!----===== Tabulator CSS ===== -->
    <link rel="stylesheet" href="{{ asset('tabulator-master/dist/css/tabulator_bootstrap5.min.css') }}">
     <!-- Include iziToast CSS -->
    <link rel="stylesheet" href="{{ asset('iziToast-master/dist/css/iziToast.min.css') }}">
    <!-- JQUERY -->
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <!-- Include iziToast JavaScript -->
    <script src="{{ asset('iziToast-master/dist/js/iziToast.min.js') }}"></script>
      <!-- Sweet Alert 2 JavaScript -->
    <script src="{{ asset('js/sweetAlert2/sweetalert2@11') }}"></script>

    @yield('styles')
    <script src="{{ asset('js/notification.js') }}"></script>
    <!-- Tabulator JS Scripts -->
    <script src="{{ asset('tabulator-master/dist/js/tabulator.min.js') }}"></script>
    <!-- Tootl tip JS Scripts -->
    <script src="{{ asset('js/popper.min.js') }}"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown show">
                <a class="nav-link" data-toggle="dropdown" href="#" onclick="showNotification()" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge unread-count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right show" id="notif" style="left: inherit; right: 0px; max-height: 300px; overflow-y: auto">
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    {{ Auth::user()->position_dtls->position.' - '.Auth::user()->department_dtls->department}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                        <i class="mr-2 fas fa-file"></i>
                        {{ __('My profile') }}
                    </a>
                    
                    {{-- <div class="dropdown-divider"></div> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="mr-2 fas fa-sign-out-alt"></i>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="{{ asset('images/cvsu-logo.png') }}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Cvsu - Imus</span>
        </a>

        @include('layouts.navigation')
    </aside>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="d-block border-radius rounded bg-white shadow-sm">
            <h1 class="p-3 fw-semibold fs-4 text-secondary">{{ $title }}</h1>
        </div>
        <div class="px-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item text-secondary">{{ $secondtitle }}</li>
                    <li class="breadcrumb-item text-secondary" aria-current="page">{{ $thirdtitle }}</li>
                </ol>
            </nav>
        </div>
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@vite('resources/js/app.js')
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>


@yield('scripts')


</body>
</html>
