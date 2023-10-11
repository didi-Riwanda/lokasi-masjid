<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title')</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-polyfills/0.1.43/polyfill.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    >
    <!-- Font Awesome Icons -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    >
    <!-- overlayScrollbars -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"
    >

    @stack('windowhead')

    <!-- Theme style -->
    <link
        rel="preload"
        as="style"
        fetchpriority="low"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('css/adminlte.min.css') }}"
    >

    <style>
        .user-panel img {
            width: 2.1rem;
            height: 2.1rem;
            object-fit: cover;
        }
        .table th.fit,
        .table td.fit,
        .dataTable th.fit,
        .dataTable td.fit {
            width: 1%;
            white-space: nowrap;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('img/AdminLTELogo.png') }}" fetchpriority="low" alt="AdminLTELogo" height="60" width="60">
        </div>

        @includeIf('layouts.components.app.header')

        @includeIf('layouts.components.app.sidebar')

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                @hasSection ('header')
                    @yield('header')
                @else
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">@yield('title', 'Document')</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                @hasSection('breadcrumb')
                                    @yield('breadcrumb')
                                @else
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Dashboard v1</li>
                                    </ol>
                                @endif
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                @endif
            </div>
            <!-- /.content-header -->

            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        @includeIf('layouts.components.app.footer')
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('windowbody')
</body>
</html>
