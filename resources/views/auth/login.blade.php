<!DOCTYPE html>
<html>
    <head>
        @php
            $logo=asset(Storage::url('logo/'));
        @endphp
        <meta charset="utf-8" />
        <title>Sistem Informasi Koperasi Karyawan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Aplikasi Koperasi Untuk Memenuhi Kebutuhan Administrasi Di Dalam Koperasi." name="description" />
        <meta content="Asep IT" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- Google Font - Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- App favicon -->
        <link rel="shortcut icon" class="img-fluid logo-img" href="{{ $logo.'/logo.png' }}">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App css -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/koperasi-theme.css') }}" rel="stylesheet" type="text/css" />
        <style>
            :root {
                --login-green: #0f766e;
                --login-green-dark: #115e59;
                --login-green-soft: #f0fdfa;
                --login-ink: #0f172a;
                --login-muted: #64748b;
                --login-border: #e2e8f0;
            }

            html,
            body {
                min-height: 100%;
            }

            body.login-page {
                min-height: 100vh;
                margin: 0;
                color: var(--login-ink);
                background:
                    radial-gradient(circle at 12% 14%, rgba(15, 118, 110, .14), transparent 32%),
                    radial-gradient(circle at 88% 82%, rgba(15, 23, 42, .08), transparent 30%),
                    #f8fafc;
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                -webkit-font-smoothing: antialiased;
            }

            .login-shell {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 38px 20px;
            }

            .login-card {
                display: grid;
                grid-template-columns: minmax(300px, .92fr) minmax(380px, 1.08fr);
                width: 100%;
                max-width: 940px;
                min-height: 560px;
                overflow: hidden;
                border: 1px solid rgba(224, 230, 226, .95);
                border-radius: 20px;
                background: #fff;
                box-shadow: 0 24px 65px rgba(39, 60, 46, .12), 0 3px 12px rgba(39, 60, 46, .04);
            }

            .login-brand-panel {
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                overflow: hidden;
                padding: 42px 38px 34px;
                color: #fff;
                background: linear-gradient(145deg, #0f766e 0%, #115e59 50%, #0f172a 100%);
            }

            .login-brand-panel:before,
            .login-brand-panel:after {
                position: absolute;
                border: 1px solid rgba(255, 255, 255, .1);
                border-radius: 50%;
                content: "";
                pointer-events: none;
            }

            .login-brand-panel:before {
                top: 22%;
                right: -140px;
                width: 340px;
                height: 340px;
                box-shadow: 0 0 0 24px rgba(255, 255, 255, .025), 0 0 0 52px rgba(255, 255, 255, .02);
            }

            .login-brand-panel:after {
                right: 24px;
                bottom: -180px;
                width: 290px;
                height: 290px;
                border-color: rgba(255, 255, 255, .07);
            }

            .login-brand-top,
            .login-brand-message,
            .login-brand-footer {
                position: relative;
                z-index: 1;
            }

            .login-brand-logo {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 60px;
                height: 60px;
                margin-bottom: 24px;
                border: 1px solid rgba(255, 255, 255, .25);
                border-radius: 17px;
                background: rgba(255, 255, 255, .12);
                box-shadow: 0 8px 22px rgba(13, 35, 21, .12);
            }

            .login-brand-logo img {
                max-width: 43px;
                max-height: 43px;
                object-fit: contain;
            }

            .login-brand-kicker {
                margin: 0 0 9px;
                color: rgba(255, 255, 255, .68);
                font-size: 10px;
                font-weight: 700;
                letter-spacing: .14em;
                text-transform: uppercase;
            }

            .login-brand-title {
                max-width: 320px;
                margin: 0;
                color: #fff;
                font-size: 29px;
                font-weight: 700;
                line-height: 1.24;
                letter-spacing: -.025em;
            }

            .login-brand-description {
                max-width: 310px;
                margin: 16px 0 0;
                color: rgba(255, 255, 255, .76);
                font-size: 13px;
                line-height: 1.75;
            }

            .login-brand-footer {
                color: rgba(255, 255, 255, .57);
                font-size: 10px;
            }

            .login-form-panel {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 48px 52px;
            }

            .login-form-content {
                width: 100%;
                max-width: 365px;
            }

            .login-welcome-label {
                margin-bottom: 8px;
                color: #7f8d81;
                font-size: 10px;
                font-weight: 700;
                letter-spacing: .12em;
                text-transform: uppercase;
            }

            .login-form-content h1 {
                margin: 0 0 8px;
                color: #303c33;
                font-size: 25px;
                font-weight: 700;
                letter-spacing: -.02em;
            }

            .login-form-description {
                margin: 0 0 29px;
                color: var(--login-muted);
                font-size: 12px;
                line-height: 1.6;
            }

            .login-form-content .form-group {
                margin-bottom: 19px;
            }

            .login-form-content label {
                display: block;
                margin-bottom: 7px;
                color: #4d5a50;
                font-size: 11px;
                font-weight: 600;
            }

            .login-input-wrap {
                position: relative;
            }

            .login-input-wrap > i {
                position: absolute;
                top: 50%;
                left: 13px;
                z-index: 2;
                color: #8a998e;
                font-size: 16px;
                transform: translateY(-50%);
                pointer-events: none;
            }

            .login-input-wrap .form-control {
                height: 45px;
                padding: 10px 13px 10px 40px;
                border: 1px solid var(--login-border);
                border-radius: 8px;
                color: #38443b;
                background: #fff;
                font-size: 12px;
                box-shadow: none;
                transition: border-color .15s ease, box-shadow .15s ease;
            }

            .login-input-wrap .form-control::placeholder {
                color: #a5adb5;
            }

            .login-input-wrap .form-control:focus {
                border-color: #91a998;
                box-shadow: 0 0 0 3px rgba(85, 123, 100, .1);
            }

            .login-input-wrap .form-control.is-invalid {
                border-color: #d59b9e;
            }

            .login-form-content .invalid-feedback {
                font-size: 10px;
            }

            .login-submit {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                min-height: 45px;
                margin-top: 26px;
                border: 1px solid var(--login-green);
                border-radius: 8px;
                color: #fff;
                background: linear-gradient(110deg, #557b64, #426a50);
                box-shadow: 0 6px 14px rgba(66, 106, 80, .17);
                font-size: 12px;
                font-weight: 700;
                letter-spacing: .02em;
                transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
            }

            .login-submit:hover,
            .login-submit:focus {
                color: #fff;
                background: linear-gradient(110deg, #496f58, #365e44);
                box-shadow: 0 8px 17px rgba(66, 106, 80, .22);
                transform: translateY(-1px);
            }

            .login-submit i {
                margin-left: 8px;
                font-size: 15px;
            }

            .login-secure-note {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 20px;
                color: #9aa39b;
                font-size: 10px;
            }

            .login-secure-note i {
                margin-right: 5px;
                color: #78917e;
                font-size: 13px;
            }

            @media (max-width: 767.98px) {
                .login-shell {
                    align-items: flex-start;
                    padding: 18px 13px;
                }

                .login-card {
                    display: block;
                    max-width: 470px;
                    min-height: 0;
                    border-radius: 15px;
                }

                .login-brand-panel {
                    min-height: 205px;
                    padding: 23px 25px;
                }

                .login-brand-logo {
                    width: 46px;
                    height: 46px;
                    margin-bottom: 15px;
                    border-radius: 13px;
                }

                .login-brand-logo img {
                    max-width: 34px;
                    max-height: 34px;
                }

                .login-brand-title {
                    max-width: 300px;
                    font-size: 21px;
                }

                .login-brand-description {
                    margin-top: 8px;
                    font-size: 11px;
                }

                .login-brand-footer {
                    display: none;
                }

                .login-form-panel {
                    padding: 29px 25px 27px;
                }

                .login-form-content h1 {
                    font-size: 22px;
                }

                .login-form-description {
                    margin-bottom: 22px;
                }
            }
        </style>
    </head>


    <body class="login-page">
        <main class="login-shell">
            <section class="login-card" aria-label="Masuk ke aplikasi koperasi">
                <div class="login-brand-panel">
                    <div class="login-brand-top">
                        <a href="{{ url('/') }}" class="login-brand-logo" aria-label="Beranda">
                            <img src="{{ $logo.'/small_logo.png' }}" alt="Logo Koperasi">
                        </a>
                        <p class="login-brand-kicker">Layanan Koperasi</p>
                    </div>
                    <div class="login-brand-message">
                        <h2 class="login-brand-title">Bersama membangun kesejahteraan.</h2>
                        <p class="login-brand-description">Akses informasi simpanan, pinjaman, dan layanan koperasi dengan mudah dalam satu platform.</p>
                    </div>
                    <div class="login-brand-footer">Sistem Informasi Koperasi Karyawan</div>
                </div>

                <div class="login-form-panel">
                    <div class="login-form-content">
                        <div class="login-welcome-label">Selamat datang kembali</div>
                        <h1>Masuk ke akun Anda</h1>
                        <p class="login-form-description">Gunakan email atau nomor anggota untuk melanjutkan.</p>

                        <form method="POST" action="{{ route('login') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email atau No Anggota</label>
                                <div class="login-input-wrap">
                                    <i class="mdi mdi-account-outline" aria-hidden="true"></i>
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="username" autofocus required placeholder="Masukkan email atau nomor anggota">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="login-input-wrap">
                                    <i class="mdi mdi-lock-outline" aria-hidden="true"></i>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" required placeholder="Masukkan password">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button class="login-submit" type="submit">
                                Masuk <i class="mdi mdi-arrow-right" aria-hidden="true"></i>
                            </button>
                        </form>
                        <div class="login-secure-note">
                            <i class="mdi mdi-shield" aria-hidden="true"></i>
                            Akses aman untuk anggota dan pengelola koperasi
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- jQuery  -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('js/waves.js') }}"></script>
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('js/jquery.core.js') }}"></script>
        <script src="{{ asset('js/jquery.app.js') }}"></script>
    </body>
</html>
