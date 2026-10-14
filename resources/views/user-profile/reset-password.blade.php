@extends('layouts.master')
@section('style')
<style>
    .member-profile-card,
    .profile-password-card {
        border-radius: 8px;
        overflow: hidden;
    }

    .member-profile-heading {
        display: flex;
        align-items: center;
        padding: 24px;
        color: #fff;
        background: linear-gradient(120deg, #364fc7, #4263eb);
    }

    .member-profile-avatar {
        display: flex;
        flex: 0 0 58px;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        margin-right: 16px;
        border: 2px solid rgba(255, 255, 255, .65);
        border-radius: 50%;
        background: rgba(255, 255, 255, .16);
        font-size: 23px;
        font-weight: 600;
    }

    .member-profile-heading h4 {
        margin: 0 0 5px;
        color: #fff;
        font-size: 18px;
    }

    .member-profile-heading p {
        margin: 0;
        color: rgba(255, 255, 255, .8);
    }

    .member-profile-content {
        padding: 24px;
    }

    .member-profile-section-title {
        margin-bottom: 14px;
        color: #495057;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .member-profile-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }

    .member-profile-detail {
        min-width: 0;
        padding: 14px 16px;
        border: 1px solid #edf0f2;
        border-radius: 6px;
        background: #fbfcfd;
    }

    .member-profile-detail-label {
        display: block;
        margin-bottom: 6px;
        color: #868e96;
        font-size: 12px;
    }

    .member-profile-detail-value {
        overflow-wrap: anywhere;
        color: #343a40;
        font-weight: 600;
    }

    .member-profile-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .member-profile-status-active {
        color: #2b8a3e;
        background: #ebfbee;
    }

    .member-profile-status-inactive {
        color: #c92a2a;
        background: #fff5f5;
    }

    .member-profile-edit {
        padding-top: 20px;
        border-top: 1px solid #edf0f2;
    }

    .profile-password-card .card-box {
        padding: 24px;
    }

    .profile-password-card .form-group label {
        color: #495057;
        font-weight: 600;
    }

    @media (max-width: 575.98px) {
        .member-profile-heading,
        .member-profile-content,
        .profile-password-card .card-box {
            padding: 18px;
        }

        .member-profile-details {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Profil {{ $isMember ? 'Member' : 'Pengguna' }}</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil {{ $isMember ? 'Member' : 'Pengguna' }}</li>
            </ol>
            <div class="clearfix"></div>
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
                <div class="member-profile-avatar" aria-hidden="true">{{ strtoupper(substr($anggota->nama ?: 'M', 0, 1)) }}</div>
                <div>
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
                            <i class="fa fa-save mr-1" aria-hidden="true"></i> Simpan Jabatan
                        </button>
                    </form>
                </div>
            </div>
        </div> <!-- end card-box -->
        @elseif($isMember)
        <div class="card-box">
            <h4 class="header-title">Profil Member</h4>
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
            <div class="mb-4">
                <h4 class="header-title mb-1">Keamanan Akun</h4>
                <p class="text-muted mb-0">Ubah password untuk menjaga keamanan akun Anda.</p>
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
                    <i class="fa fa-lock mr-1" aria-hidden="true"></i> Simpan Password
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection