<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-polyfills/0.1.43/polyfill.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    >
    <!-- Font Awesome -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"
    >
    <!-- icheck bootstrap -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
    >
    <!-- Theme style -->
    <link
        rel="preload"
        as="style"
        fetchpriority="low"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('css/adminlte.min.css') }}"
    >
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                @yield('content')
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</body>
</html>
