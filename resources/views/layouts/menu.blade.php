<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!-- Sidebar User Mini-Card -->
        <div class="sidebar-user-card">
            <div class="sidebar-user-avatar">
                @if($userPhotoUrl)
                <img src="{{ $userPhotoUrl }}" alt="Foto {{ $users->name }}">
                @else
                <span class="user-avatar-fallback" aria-label="Inisial {{ $users->name }}">{{ $userInitial }}</span>
                @endif
                <span class="user-status-indicator" title="Status: Online & Terverifikasi"></span>
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-greeting">LAYANAN KOPERASI</div>
                <div class="sidebar-user-name" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</div>
                <div class="sidebar-user-role mt-1">
                    <span class="badge badge-soft-primary" style="font-size: 9.5px; padding: 2px 7px;">
                        {{ Auth::user()->roles->first()->display_name ?? 'Karyawan' }}
                    </span>
                </div>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Dashboard Utama</li>
                <li class="{{ set_active(['home']) }}">
                    <a href="{{ route('home') }}" class="{{ set_active(['home']) }}">
                        <i class="fi-air-play"></i> <span>Dashboard Utama</span>
                    </a>
                </li>

                <li class="menu-title">DATA MASTER KOPERASI</li>
                @permission('manage-anggota')
                <li class="{{ set_active(['anggota.index', 'anggota.create', 'anggota.edit'])}}">
                    <a href="{{ route('anggota.index') }}" class="{{ set_active(['anggota.index', 'anggota.create', 'anggota.edit'])}}">
                        <i class="fi-head"></i> <span>Data Anggota</span>
                    </a>
                </li>
                @endpermission
                
                @if(Auth::user()->hasMemberRole())
                <li class="{{ set_active(['user.user-profile']) }}">
                    <a href="{{ route('user.user-profile', Auth::user()->id) }}" class="{{ set_active(['user.user-profile']) }}">
                        <i class="fi-head"></i> <span>Profil Anggota</span>
                    </a>
                </li>
                @endif
                
                @permission('manage-divisi')
                <li class="{{ set_active(['divisi.index', 'divisi.create', 'divisi.edit'])}}">
                    <a href="{{ route('divisi.index') }}" class="{{ set_active(['divisi.index', 'divisi.create', 'divisi.edit'])}}">
                        <i class="fi-layers"></i> <span>Master Divisi</span>
                    </a>
                </li>
                @endpermission
                
                @permission('manage-produk-pinjaman')
                <li class="{{ set_active(['produk-pinjaman.index', 'produk-pinjaman.create', 'produk-pinjaman.edit']) }}">
                    <a href="{{ route('produk-pinjaman.index') }}" class="{{ set_active(['produk-pinjaman.index', 'produk-pinjaman.create', 'produk-pinjaman.edit']) }}">
                        <i class="fi-box"></i> <span>Produk Pinjaman</span>
                    </a>
                </li>
                @endpermission
                
                @permission('manage-periode')
                <li class="{{ set_active(['periode.index', 'periode.create', 'periode.edit'])}}">
                    <a href="{{ route('periode.index') }}" class="{{ set_active(['periode.index', 'periode.create', 'periode.edit'])}}">
                        <i class="fi-clock"></i> <span>Periode Buku</span>
                    </a>
                </li>
                @endpermission
                
                @permission('manage-biaya')
                <li class="{{ set_active(['biaya.index', 'biaya.create'])}}">
                    <a href="{{ route('biaya.index') }}" class="{{ set_active(['biaya.index', 'biaya.create'])}}">
                        <i class="fi-paper-stack"></i> <span>Master Biaya</span>
                    </a>
                </li>
                @endpermission

                @if(Auth::user()->hasMemberRole() || Auth::user()->can('manage-debet-simpanan') || Auth::user()->can('manage-kredit-simpanan') || Auth::user()->can('manage-debet-pinjaman') || Auth::user()->can('manage-kredit-pinjaman') || Auth::user()->can('manage-debet-divisi') || Auth::user()->can('manage-kredit-divisi') || Auth::user()->can('manage-copy-saldo'))
                <li class="menu-title">TRANSAKSI KEUANGAN</li>
                @endif

                @permission('manage-copy-saldo')
                <li class="{{ set_active(['copy-saldo.index', 'copy-saldo.create', 'copy-saldo.edit'])}}">
                    <a href="{{ route('copy-saldo.index') }}" class="{{ set_active(['copy-saldo.index', 'copy-saldo.create', 'copy-saldo.edit'])}}">
                        <i class="fi-cloud-upload"></i> <span>Copy Saldo Periode</span>
                    </a>
                </li>
                @endpermission

                @if(Auth::user()->hasMemberRole() || Auth::user()->can('manage-debet-simpanan') || Auth::user()->can('manage-kredit-simpanan'))
                <li class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload',
                'simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload',
                    'simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                        <i class="fi-server"></i> <span> Simpanan </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false">
                        @if(Auth::user()->can('manage-debet-simpanan') || Auth::user()->hasMemberRole())
                        <li class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload'])}}">
                            <a href="{{ route('simpanan-debet.index') }}" class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload'])}}">
                                Debet (Setoran)
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->can('manage-kredit-simpanan') || Auth::user()->hasMemberRole())
                        <li class="{{ set_active(['simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                            <a href="{{ route('simpanan-kredit.index') }}" class="{{ set_active(['simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                                Kredit (Penarikan)
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(Auth::user()->hasMemberRole() || Auth::user()->can('manage-debet-pinjaman') || Auth::user()->can('manage-kredit-pinjaman') || Auth::user()->can('pinjaman-debet-create'))
                <li class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload',
                'pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload',
                    'pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                        <i class="fi-tag"></i> <span> Pinjaman </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false">
                        @if(Auth::user()->can('manage-debet-pinjaman') || Auth::user()->hasMemberRole())
                        <li class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload'])}}">
                            <a href="{{ route('pinjaman-debet.index') }}" class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload'])}}">
                                Debet (Angsuran)
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->can('manage-kredit-pinjaman') || Auth::user()->hasMemberRole())
                        <li class="{{ set_active(['pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                            <a href="{{ route('pinjaman-kredit.index') }}" class="{{ set_active(['pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                                Kredit (Pencairan)
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @permission('manage-debet-divisi|manage-kredit-divisi')
                <li class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload',
                'divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload',
                    'divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                        <i class="fi-folder"></i> <span> Divisi </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false">
                        @permission('manage-debet-divisi')
                        <li class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload'])}}">
                            <a href="{{ route('divisi-debet.index') }}" class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload'])}}">Debet Divisi</a>
                        </li>
                        @endpermission
                        @permission('manage-kredit-divisi')
                        <li class="{{ set_active(['divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                            <a href="{{ route('divisi-kredit.index') }}" class="{{ set_active(['divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">Kredit Divisi</a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endpermission

                @permission('manage-laporan-kas-bank|manage-laporan-divisi|manage-laporan-pinjaman-anggota|manage-laporan-simpanan-anggota|
                manage-laporan-pinjaman-all|manage-laporan-simpanan-all')
                <li class="menu-title">LAPORAN & ANALISIS</li>
                @endpermission

                @permission('manage-laporan-kas-bank')
                <li class="{{ set_active(['laporan.cash-bank']) }}">
                    <a href="{{ route('laporan.cash-bank') }}" class="{{ set_active(['laporan.cash-bank']) }}">
                        <i class="fi-briefcase"></i> <span>Laporan Kas / Bank</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-laporan-simpanan-all')
                <li class="{{ set_active(['laporan.simpanan-all']) }}">
                    <a href="{{ route('laporan.simpanan-all') }}" class="{{ set_active(['laporan.simpanan-all']) }}">
                        <i class="mdi mdi-chart-pie" aria-hidden="true"></i> <span>Rekap Simpanan</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-laporan-pinjaman-all')
                <li class="{{ set_active(['laporan.pinjaman-all']) }}">
                    <a href="{{ route('laporan.pinjaman-all') }}" class="{{ set_active(['laporan.pinjaman-all']) }}">
                        <i class="mdi mdi-chart-bar" aria-hidden="true"></i> <span>Rekap Pinjaman</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-simpanan-anggota')
                <li class="{{ set_active(['laporan.simpanan']) }}">
                    <a href="{{ route('laporan.simpanan') }}" class="{{ set_active(['laporan.simpanan']) }}">
                        <i class="fi-file"></i> <span>Simpanan Anggota</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-pinjaman-anggota')
                <li class="{{ set_active(['laporan.pinjaman']) }}">
                    <a href="{{ route('laporan.pinjaman') }}" class="{{ set_active(['laporan.pinjaman']) }}">
                        <i class="mdi mdi-file-document" aria-hidden="true"></i> <span>Pinjaman Anggota</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-laporan-divisi')
                <li class="{{ set_active(['laporan.per-divisi']) }}">
                    <a href="{{ route('laporan.per-divisi') }}" class="{{ set_active(['laporan.per-divisi']) }}">
                        <i class="fi-layout"></i> <span>Laporan Per Divisi</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-permissions|manage-user|manage-role|manage-option|manage-module')
                <li class="menu-title">ADMINISTRASI SISTEM</li>
                @endpermission

                @permission('manage-module')
                <li class="{{ set_active(['module.index', 'module.create', 'module.edit'])}}">
                    <a href="{{ route('module.index') }}" class="{{ set_active(['module.index', 'module.create', 'module.edit'])}}">
                        <i class="fi-archive"></i> <span>Modul Sistem</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-permissions')
                <li class="{{ set_active(['permission.index', 'permission.create', 'permission.edit'])}}">
                    <a href="{{ route('permission.index') }}" class="{{ set_active(['permission.index', 'permission.create', 'permission.edit'])}}">
                        <i class="fi-lock"></i> <span>Hak Akses</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-role')
                <li class="{{ set_active(['role.index', 'role.create', 'role.edit'])}}">
                    <a href="{{ route('role.index') }}" class="{{ set_active(['role.index', 'role.create', 'role.edit'])}}">
                        <i class="mdi mdi-account-key" aria-hidden="true"></i> <span>Peran (Role)</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-user')
                <li class="{{ set_active(['user.index', 'user.create', 'user.edit'])}}">
                    <a href="{{ route('user.index') }}" class="{{ set_active(['user.index', 'user.create', 'user.edit'])}}">
                        <i class="fi-head"></i> <span>Pengguna</span>
                    </a>
                </li>
                @endpermission

                @permission('manage-option')
                <li class="{{ set_active(['option.index', 'option.create', 'option.edit'])}}">
                    <a href="{{ route('option.index') }}" class="{{ set_active(['option.index', 'option.create', 'option.edit'])}}">
                        <i class="fi-cog"></i> <span>Pengaturan</span>
                    </a>
                </li>
                @endpermission
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
