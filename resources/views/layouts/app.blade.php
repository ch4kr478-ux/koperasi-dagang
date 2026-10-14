<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Koperasi Karyawan') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/koperasi-theme.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
    <div id="app" class="auth-layout">
        <header class="auth-navbar">
            <div class="auth-navbar-inner">
                <a class="auth-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-kopkar.png') }}" alt="Logo Koperasi">
                    <span class="auth-brand-copy">
                        <strong>{{ config('app.name', 'Koperasi Karyawan') }}</strong>
                        <small>Sistem Informasi Koperasi</small>
                    </span>
                </a>

                <nav class="auth-navbar-actions" aria-label="Navigasi akun">
                    @guest
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="auth-register-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <span class="auth-user-name">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">{{ __('Logout') }}</button>
                        </form>
                    @endguest
                </nav>
            </div>
        </header>

        <main class="auth-content">
            @yield('content')
        </main>

        <footer class="auth-footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Koperasi Karyawan') }}
        </footer>
    </div>
</body>
</html>
