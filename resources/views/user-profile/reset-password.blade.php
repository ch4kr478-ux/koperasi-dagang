@extends('layouts.master')
@section('style')
<style>
    .member-profile-page {
        padding-bottom: 24px;
    }

    .member-profile-card,
    .profile-password-card > .card-box {
        height: calc(100% - 24px);
        margin-bottom: 24px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        background: var(--k-surface);
        box-shadow: var(--k-shadow-xs);
        transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease;
    }

    .member-profile-card:hover,
    .profile-password-card > .card-box:hover {
        transform: translateY(-2px);
        border-color: var(--k-border-strong);
        box-shadow: var(--k-shadow-md);
    }

    .member-profile-card {
        overflow: hidden;
    }

    .member-profile-heading {
        display: flex;
        align-items: center;
        gap: 22px;
        padding: 24px 26px;
        color: #ffffff;
        background: var(--k-navy-gradient);
    }

    .member-profile-avatar {
        display: flex;
        flex: 0 0 108px;
        align-items: center;
        justify-content: center;
        width: 108px;
        height: 144px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 12px;
        background: rgba(255, 255, 255, .12);
        font-size: 32px;
        font-weight: 800;
    }

    .member-profile-avatar img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .member-profile-heading-copy {
        min-width: 0;
    }

    .member-profile-heading h4 {
        margin: 0 0 5px;
        color: #ffffff;
        font-size: 17px;
        font-weight: 800;
    }

    .member-profile-heading p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .member-profile-content {
        padding: 24px 26px;
    }

    .member-profile-section-title {
        margin-bottom: 14px;
        color: var(--k-text-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .member-profile-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 22px;
    }

    .member-profile-detail {
        min-width: 0;
        padding: 14px 16px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-md);
        background: var(--k-surface-alt);
    }

    .member-profile-detail-label {
        display: block;
        margin-bottom: 6px;
        color: var(--k-text-muted);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .member-profile-detail-value {
        overflow-wrap: anywhere;
        color: var(--k-text-main);
        font-size: 13px;
        font-weight: 700;
    }

    .member-profile-status {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: var(--k-radius-full);
        font-size: 10.5px;
        font-weight: 700;
    }

    .member-profile-status-active {
        color: var(--k-success-text);
        background: var(--k-success-bg);
        border: 1px solid var(--k-success-border);
    }

    .member-profile-status-inactive {
        color: var(--k-danger-text);
        background: var(--k-danger-bg);
        border: 1px solid var(--k-danger-border);
    }

    .member-profile-edit {
        padding-top: 20px;
        border-top: 1px solid var(--k-border);
    }

    .profile-password-card .security-heading {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--k-border-subtle);
    }

    .profile-password-card .security-heading-icon {
        display: inline-flex;
        flex: 0 0 40px;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid var(--k-primary-border);
        border-radius: var(--k-radius-md);
        color: var(--k-primary);
        background: var(--k-primary-light);
        font-size: 18px;
    }

    .profile-password-card .security-heading h4 {
        margin: 0 0 4px;
        color: var(--k-text-main);
        font-size: 16px;
        font-weight: 800;
    }

    .profile-password-card .security-heading p {
        margin: 0;
        color: var(--k-text-muted);
        font-size: 12px;
    }

    .member-profile-page .page-title-box small {
        color: var(--k-text-muted);
        font-size: 12px;
    }

    @media (max-width: 575.98px) {
        .member-profile-heading,
        .member-profile-content {
            padding: 18px;
        }

        .member-profile-heading {
            align-items: center;
            gap: 14px;
        }

        .member-profile-avatar {
            flex-basis: 80px;
            width: 80px;
            height: 107px;
            font-size: 26px;
        }

        .member-profile-details {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
@section('content')
<div class="member-profile-page">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="float-left">
                    <h4 class="page-title">
                        <i class="mdi mdi-account-circle text-teal mr-1" aria-hidden="true"></i>
                        Profil {{ $isMember ? 'Anggota' : 'Pengguna' }}
                    </h4>
                    <small>Kelola informasi profil dan keamanan akun Anda.</small>
                </div>
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                    <span class="badge badge-soft-primary">
                        <i class="mdi mdi-shield mr-1" aria-hidden="true"></i>
                        Pengaturan Akun
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('flash_notification.message'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-{{ session()->get('flash_notification.level', 'success') }} alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {!! session()->get('flash_notification.message') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="{{ $isMember && $anggota ? 'col-lg-7' : 'col-12' }}">
            @if($isMember && $anggota)
            <div class="card-box member-profile-card p-0">
                <div class="member-profile-heading">
                    <div class="member-profile-avatar">
                        @if($anggota->pas_foto)
                        <img src="{{ url('storage/' . $anggota->pas_foto) }}" alt="Pas foto {{ $anggota->nama }}">
                        @else
                        <span aria-hidden="true">{{ strtoupper(substr($anggota->nama ?: 'M', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="member-profile-heading-copy">
                        <h4>{{ $anggota->nama }}</h4>
                        <p>Profil anggota koperasi</p>
                    </div>
                </div>
                <div class="member-profile-content">
                    <h5 class="member-profile-section-title">Informasi Anggota</h5>
                    <div class="member-profile-details">
                        <div class="member-profile-detail">
                            <span class="member-profile-detail-label">NIK / Username</span>
                            <span class="member-profile-detail-value">{{ $anggota->nik }}</span>
                        </div>
                        <div class="member-profile-detail">
                            <span class="member-profile-detail-label">Nama</span>
                            <span class="member-profile-detail-value">{{ $anggota->nama }}</span>
                        </div>
                        <div class="member-profile-detail">
                            <span class="member-profile-detail-label">Nomor Telepon</span>
                            <span class="member-profile-detail-value">{{ $anggota->no_telepon ?: '-' }}</span>
                        </div>
                        <div class="member-profile-detail">
                            <span class="member-profile-detail-label">Tanggal Daftar</span>
                            <span class="member-profile-detail-value">{{ $anggota->tgl_daftar ? \Carbon\Carbon::parse($anggota->tgl_daftar)->format('d-m-Y') : '-' }}</span>
                        </div>
                        <div class="member-profile-detail">
                            <span class="member-profile-detail-label">Status</span>
                            <span class="member-profile-status {{ (string) $anggota->status === '1' ? 'member-profile-status-active' : 'member-profile-status-inactive' }}">
                                {{ (string) $anggota->status === '1' ? 'Aktif' : 'Non Aktif' }}
                            </span>
                        </div>
                        <div class="member-profile-detail">
                            <span class="member-profile-detail-label">Home Base</span>
                            <span class="member-profile-detail-value">{{ $anggota->homebase ?: '-' }}</span>
                        </div>
                    </div>
                    <div class="member-profile-edit">
                        <h5 class="member-profile-section-title">Perbarui Jabatan</h5>
                        <form method="post" action="{{ route('user.update-member-profile', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="profile-jabatan">Jabatan</label>
                                <input id="profile-jabatan" type="text" name="jabatan" value="{{ old('jabatan', $anggota->jabatan) }}" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Masukkan jabatan" required>
                                @error('jabatan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1" aria-hidden="true"></i> Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @elseif($isMember)
            <div class="card-box">
                <h4 class="header-title">Profil Anggota</h4>
                <div class="alert alert-warning mb-0" role="alert">
                    Data anggota belum terhubung dengan akun ini. Hubungi administrator untuk memperbaikinya.
                </div>
            </div>
            @else
            <div class="card-box">
                <h4 class="header-title">Profil Pengguna</h4>
                <div class="member-profile-details mb-0">
                    <div class="member-profile-detail">
                        <span class="member-profile-detail-label">NIK / Username</span>
                        <span class="member-profile-detail-value">{{ $user->email }}</span>
                    </div>
                    <div class="member-profile-detail">
                        <span class="member-profile-detail-label">Nama</span>
                        <span class="member-profile-detail-value">{{ $user->name }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if(!$isMember || $anggota)
        <div class="{{ $isMember ? 'col-lg-5' : 'col-12' }} profile-password-card">
            <div class="card-box">
                <div class="security-heading">
                    <span class="security-heading-icon"><i class="mdi mdi-lock-reset" aria-hidden="true"></i></span>
                    <div>
                        <h4>Keamanan Akun</h4>
                        <p>Ubah password untuk menjaga keamanan akun Anda.</p>
                    </div>
                </div>
                <form method="post" action="{{ route('user.edit-password', $user->id) }}" id="basic-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="old_password">Password Lama</label>
                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" autocomplete="current-password" placeholder="Masukkan password lama" required>
                        @error('old_password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password Baru</label>
                        <input id="confirm-password" type="password" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" autocomplete="new-password" placeholder="Ulangi password baru" required>
                        @error('confirm-password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-lock mr-1" aria-hidden="true"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection