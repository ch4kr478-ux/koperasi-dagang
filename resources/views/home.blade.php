@extends('layouts.master')
@section('style')
<style>
    .home-portal {
        padding-bottom: 24px;
    }

    .home-banner {
        position: relative;
        overflow: hidden;
        padding: 34px 38px;
        margin-bottom: 26px;
        border: 1px solid var(--k-border);
        border-left: 5px solid var(--k-primary);
        border-radius: var(--k-radius-lg);
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 55%, #f0fdfa 100%);
        box-shadow: var(--k-shadow-sm);
    }

    .home-banner:after {
        position: absolute;
        top: -100px;
        right: 8%;
        width: 280px;
        height: 280px;
        border: 1px solid rgba(15, 118, 110, 0.08);
        border-radius: 50%;
        box-shadow: 0 0 0 28px rgba(15, 118, 110, 0.02), 0 0 0 60px rgba(15, 118, 110, 0.015);
        content: "";
        pointer-events: none;
    }

    .home-banner-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: var(--k-radius-full);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--k-primary);
        background: var(--k-primary-subtle);
        border: 1px solid var(--k-primary-border);
        margin-bottom: 12px;
    }

    .home-banner h3 {
        margin: 0 0 8px;
        font-size: 26px;
        font-weight: 800;
        color: var(--k-text-main);
        letter-spacing: -0.02em;
    }

    .home-banner p {
        margin: 0 0 20px;
        color: var(--k-text-muted);
        font-size: 14px;
        max-width: 680px;
        line-height: 1.6;
    }

    .home-banner-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* KPI Cards */
    .kpi-card {
        position: relative;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--k-shadow-xs);
        transition: all 0.2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--k-shadow-md);
        border-color: #cbd5e1;
    }

    .kpi-card:before {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3.5px;
        background: var(--k-primary-gradient);
        content: "";
    }

    .kpi-card.kpi-secondary:before {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    }

    .kpi-card.kpi-warning:before {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .kpi-card.kpi-success:before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: var(--k-radius-md);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .kpi-icon.primary {
        color: var(--k-primary);
        background: var(--k-primary-subtle);
        border: 1px solid var(--k-primary-border);
    }

    .kpi-icon.info {
        color: var(--k-info);
        background: var(--k-info-bg);
        border: 1px solid var(--k-info-border);
    }

    .kpi-icon.warning {
        color: var(--k-warning);
        background: var(--k-warning-bg);
        border: 1px solid var(--k-warning-border);
    }

    .kpi-icon.success {
        color: var(--k-success);
        background: var(--k-success-bg);
        border: 1px solid var(--k-success-border);
    }

    .kpi-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--k-text-muted);
        margin-bottom: 6px;
    }

    .kpi-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--k-text-main);
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }

    .kpi-subtext {
        font-size: 12px;
        color: var(--k-text-subtle);
        font-weight: 500;
    }

    /* Module Cards Grid */
    .section-title {
        display: flex;
        align-items: center;
        margin: 10px 0 18px;
        color: var(--k-text-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .section-title:after {
        flex: 1;
        height: 1px;
        margin-left: 14px;
        background: var(--k-border);
        content: "";
    }

    .module-card {
        background: #ffffff;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        padding: 22px;
        margin-bottom: 24px;
        box-shadow: var(--k-shadow-xs);
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: calc(100% - 24px);
    }

    .module-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--k-shadow-md);
        border-color: #cbd5e1;
    }

    .module-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
    }

    .module-icon-box {
        width: 44px;
        height: 44px;
        border-radius: var(--k-radius-md);
        background: var(--k-surface-alt);
        border: 1px solid var(--k-border);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--k-primary);
    }

    .module-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--k-text-main);
        margin: 0;
    }

    .module-desc {
        font-size: 12.5px;
        color: var(--k-text-muted);
        line-height: 1.5;
        margin-bottom: 16px;
    }

    .module-link {
        font-size: 12px;
        font-weight: 700;
        color: var(--k-primary);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .module-link:hover {
        color: var(--k-primary-hover);
        gap: 9px;
    }
</style>
@endsection

@section('content')
<div class="home-portal">
    <!-- Corporate Executive Welcome Banner -->
    <div class="home-banner">
        <div class="home-banner-badge">
            <i class="mdi mdi-shield-check"></i> Enterprise Corporate Portal
        </div>
        <h3>Sistem Informasi Manajemen Koperasi Karyawan</h3>
        <p>
            Selamat datang di portal operasional Koperasi Karyawan Prasetiya Mulya. Sistem terintegrasi untuk pengelolaan data anggota, transaksi simpan pinjam, pembukuan divisi, serta laporan keuangan akurat dan transparan.
        </p>
        <div class="home-banner-actions">
            @permission('manage-anggota')
            <a href="{{ route('anggota.index') }}" class="btn btn-primary">
                <i class="fi-head"></i> Kelola Anggota
            </a>
            @endpermission

            @permission('manage-laporan-kas-bank')
            <a href="{{ route('laporan.cash-bank') }}" class="btn btn-outline-secondary">
                <i class="fi-briefcase"></i> Laporan Kas & Bank
            </a>
            @endpermission
        </div>
    </div>

    <!-- KPI Summary Row -->
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-icon primary">
                    <i class="fi-head"></i>
                </div>
                <div class="kpi-label">Anggota Terdaftar</div>
                <div class="kpi-value" data-plugin="counterup">{{ $countAnggota ?? 0 }}</div>
                <div class="kpi-subtext"><span class="text-success"><i class="mdi mdi-check-circle"></i> Anggota Aktif</span></div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="kpi-card kpi-secondary">
                <div class="kpi-icon info">
                    <i class="fi-layers"></i>
                </div>
                <div class="kpi-label">Divisi Perusahaan</div>
                <div class="kpi-value" data-plugin="counterup">{{ $countDivisi ?? 0 }}</div>
                <div class="kpi-subtext">Unit kerja terintegrasi</div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="kpi-card kpi-success">
                <div class="kpi-icon success">
                    <i class="fi-shield"></i>
                </div>
                <div class="kpi-label">Keamanan Sistem</div>
                <div class="kpi-value">256-Bit</div>
                <div class="kpi-subtext">Enkripsi data & sesi aktif</div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="kpi-card kpi-warning">
                <div class="kpi-icon warning">
                    <i class="fi-clock"></i>
                </div>
                <div class="kpi-label">Status Server</div>
                <div class="kpi-value">Online</div>
                <div class="kpi-subtext">Operasional real-time</div>
            </div>
        </div>
    </div>

    <!-- Quick Access Modules -->
    <div class="section-title">Modul Operasional Utama</div>
    <div class="row">
        @permission('manage-anggota')
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="module-card">
                <div>
                    <div class="module-header">
                        <div class="module-icon-box">
                            <i class="fi-head"></i>
                        </div>
                        <h5 class="module-title">Data Anggota</h5>
                    </div>
                    <p class="module-desc">Registrasi, verifikasi status, pembaharuan profil, dan ekspor data seluruh anggota koperasi.</p>
                </div>
                <a href="{{ route('anggota.index') }}" class="module-link">
                    Buka Modul Anggota <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endpermission

        @if(Auth::user()->can('manage-debet-simpanan') || Auth::user()->hasMemberRole())
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="module-card">
                <div>
                    <div class="module-header">
                        <div class="module-icon-box">
                            <i class="fi-server"></i>
                        </div>
                        <h5 class="module-title">Transaksi Simpanan</h5>
                    </div>
                    <p class="module-desc">Pencatatan setoran simpanan pokok, wajib, sukarela, dan penarikan saldo secara terperinci.</p>
                </div>
                <a href="{{ route('simpanan-debet.index') }}" class="module-link">
                    Buka Transaksi Simpanan <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif

        @if(Auth::user()->can('manage-debet-pinjaman') || Auth::user()->hasMemberRole())
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="module-card">
                <div>
                    <div class="module-header">
                        <div class="module-icon-box">
                            <i class="fi-tag"></i>
                        </div>
                        <h5 class="module-title">Transaksi Pinjaman</h5>
                    </div>
                    <p class="module-desc">Manajemen pencairan pinjaman, skema angsuran pokok & bunga pinjaman, serta kalkulator kredit.</p>
                </div>
                <a href="{{ route('pinjaman-debet.index') }}" class="module-link">
                    Buka Transaksi Pinjaman <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif

        @permission('manage-laporan-kas-bank|manage-laporan-simpanan-all|manage-laporan-pinjaman-all')
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="module-card">
                <div>
                    <div class="module-header">
                        <div class="module-icon-box">
                            <i class="fi-briefcase"></i>
                        </div>
                        <h5 class="module-title">Laporan Keuangan</h5>
                    </div>
                    <p class="module-desc">Akses laporan kas/bank, rekapitulasi simpanan dan pinjaman, serta neraca per divisi per periode.</p>
                </div>
                <a href="{{ route('laporan.cash-bank') }}" class="module-link">
                    Buka Pusat Laporan <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endpermission

        @permission('manage-divisi')
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="module-card">
                <div>
                    <div class="module-header">
                        <div class="module-icon-box">
                            <i class="fi-layers"></i>
                        </div>
                        <h5 class="module-title">Master Divisi</h5>
                    </div>
                    <p class="module-desc">Pengaturan struktur divisi perusahaan dan alokasi kode rekening transaksi antar divisi.</p>
                </div>
                <a href="{{ route('divisi.index') }}" class="module-link">
                    Buka Master Divisi <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endpermission

        @permission('manage-option|manage-user')
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="module-card">
                <div>
                    <div class="module-header">
                        <div class="module-icon-box">
                            <i class="fi-cog"></i>
                        </div>
                        <h5 class="module-title">Pengaturan Sistem</h5>
                    </div>
                    <p class="module-desc">Konfigurasi identitas perusahaan, manajemen hak akses role, serta parameter sistem koperasi.</p>
                </div>
                <a href="{{ route('option.index') }}" class="module-link">
                    Buka Pengaturan <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endpermission
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
@endsection
