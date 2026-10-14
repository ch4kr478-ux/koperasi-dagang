<!DOCTYPE html>
<html lang="id">
    <head>
        @php
            $logo = asset(Storage::url('logo/'));
        @endphp
        <meta charset="utf-8" />
        <title>Sistem Informasi Koperasi Karyawan — Enterprise Portal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Sistem Informasi Manajemen Koperasi Karyawan Tingkat Korporasi" name="description" />
        <meta content="Enterprise IT Solutions" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <!-- Google Font - Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- App favicon -->
        <link rel="shortcut icon" class="img-fluid" href="{{ $logo.'/logo.png' }}">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Core & Plugin CSS -->
        <link href="{{ asset('plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- Corporate Enterprise Theme System -->
        <link href="{{ asset('assets/css/koperasi-theme.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/bootstrap-chosen.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/yellow.css')}}" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap-fileinput.css')}}" rel="stylesheet" />
        @yield('style')
        
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    </head>
    <body>
        @php
            $logo = asset(Storage::url('logo/'));
            $profile = asset(Storage::url('avatar/'));
            $users = \Auth::user();
        @endphp
        
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="{{ url('/') }}" class="logo">
                        <img class="img-fluid" src="{{ $logo.'/logo.png' }}" alt="Logo Koperasi" width="40" height="40" style="object-fit: contain;">
                        <div class="logo-brand d-none d-sm-flex">
                            <span class="logo-title">KOPKAR</span>
                            <span class="logo-subtitle">ENTERPRISE</span>
                        </div>
                    </a>
                </div>

                <nav class="navbar-custom">
                    <!-- Left Section: Toggle & Status Chip -->
                    <ul class="list-inline menu-left mb-0 float-left d-flex align-items-center">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect" title="Toggle Navigasi">
                                <i class="dripicons-menu"></i>
                            </button>
                        </li>
                        <li class="d-none d-md-inline-block">
                            <div class="topbar-status-chip">
                                <span class="status-dot"></span>
                                <span>Portal Koperasi Terpadu</span>
                                <span class="text-white-50">•</span>
                                <span id="corporate-live-clock">Memuat waktu...</span>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Section: User Profile Dropdown -->
                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('images/users/avatar-1.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle">
                                <div class="d-none d-md-flex flex-column text-left mr-1" style="line-height: 1.2;">
                                    <span class="font-weight-bold">{{ Auth::user()->name }}</span>
                                    <small class="text-white-50" style="font-size: 10px;">{{ Auth::user()->roles->first()->display_name ?? 'Member' }}</small>
                                </div>
                                <i class="mdi mdi-chevron-down ml-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                <div class="noti-title">
                                    <h6>Informasi Akun</h6>
                                    <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                                    <div class="badge badge-soft-primary mt-1">{{ Auth::user()->email }}</div>
                                </div>
                                <a href="{{ route('user.user-profile', Auth::user()->id )}}" class="dropdown-item notify-item">
                                    <i class="fi-head"></i> <span>Profil & Akun Saya</span>
                                </a>
                                <div class="dropdown-divider my-1"></div>
                                <a href="{{ url('/logout') }}" class="dropdown-item notify-item text-danger"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fi-power"></i> <span>Keluar Sistem</span>
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.menu')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div> <!-- container -->
                </div> <!-- content -->

                <footer class="footer">
                    <div class="footer-left">
                        <strong>&copy; {{ date('Y') }} Koperasi Karyawan Prasetiya Mulya</strong>
                        <span class="footer-separator">·</span> Portal Manajemen Koperasi
                    </div>
                    <div class="footer-right d-none d-sm-flex">
                        <span class="badge badge-soft-success"><i class="mdi mdi-check-circle-outline" aria-hidden="true"></i> Sistem Operasional</span>
                    </div>
                </footer>
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

        <!-- jQuery & Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('js/waves.js') }}"></script>
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('js/jquery.core.js') }}"></script>
        <script src="{{ asset('js/jquery.app.js') }}"></script>
        <script src="{{ asset('plugins/jquery-toastr/jquery.toast.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/chosen.jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-fileinput.js') }}" type="text/javascript"></script>

        @yield('script')
        @if ($message = Session::get('error'))
            <script>
                $.toast({
                    heading: 'Pemberitahuan Sistem',
                    text: '{!! $message !!}',
                    position: 'top-right',
                    loaderBg: '#ef4444',
                    icon: 'error',
                    hideAfter: 4000,
                    stack: 1
                });
            </script>
        @endif
        @if ($message = Session::get('success'))
            <script>
                $.toast({
                    heading: 'Berhasil !',
                    text: '{!! $message !!}',
                    position: 'top-right',
                    loaderBg: '#10b981',
                    icon: 'success',
                    hideAfter: 4000,
                    stack: 1
                });
            </script>
        @endif

        <script>
            $(function() {
                $(".chosen-select").chosen();
                $('#edit_publish').click(function(){
                    $('.publish').show();
                    $('#edit_publish').hide();
                });

                // Live Clock for Corporate Topbar
                function updateCorporateClock() {
                    var now = new Date();
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    
                    var dayName = days[now.getDay()];
                    var dayNum = now.getDate();
                    var monthName = months[now.getMonth()];
                    var year = now.getFullYear();
                    
                    var hours = String(now.getHours()).padStart(2, '0');
                    var minutes = String(now.getMinutes()).padStart(2, '0');
                    var seconds = String(now.getSeconds()).padStart(2, '0');
                    
                    var clockEl = document.getElementById('corporate-live-clock');
                    if (clockEl) {
                        clockEl.textContent = dayName + ', ' + dayNum + ' ' + monthName + ' ' + year + ' ' + hours + ':' + minutes + ':' + seconds + ' WIB';
                    }
                }
                updateCorporateClock();
                setInterval(updateCorporateClock, 1000);
            });
        </script>
    </body>
</html>
