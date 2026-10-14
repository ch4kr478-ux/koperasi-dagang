@extends('layouts.master')
@section('style')
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Pengguna</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Management</a></li>
                <li class="breadcrumb-item active">Profile Pengguna</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
@if (session()->has('flash_notification.message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="{{ $isMember && $anggota ? 'col-6' : 'col-12' }}">
        <div class="card-box">
            <h4 class="m-t-0 header-title">Profil {{ $isMember ? 'Member' : 'Pengguna' }}</h4>
            <div class="p-20">
                @if($isMember && $anggota)
                <table class="table no-border">
                    <tbody>
                        <tr>
                            <td><strong>NIK / Username</strong></td>
                            <td>:</td>
                            <td>{{ $anggota->nik }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>:</td>
                            <td>{{ $anggota->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Daftar</strong></td>
                            <td>:</td>
                            <td>{{ $anggota->tgl_daftar ? \Carbon\Carbon::parse($anggota->tgl_daftar)->format('d-m-Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>:</td>
                            <td>{{ (string) $anggota->status === '1' ? 'Aktif' : 'Non Aktif' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Home Base</strong></td>
                            <td>:</td>
                            <td>{{ $anggota->homebase }}</td>
                        </tr>
                    </tbody>
                </table>
                <form method="post" action="{{ route('user.update-member-profile', $user->id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="profile-jabatan">Jabatan</label>
                        <div class="col-8">
                            <input id="profile-jabatan" type="text" name="jabatan" value="{{ old('jabatan', $anggota->jabatan) }}" class="form-control @error('jabatan') is-invalid @enderror" required>
                            @error('jabatan')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                @elseif($isMember)
                <div class="alert alert-warning mb-0" role="alert">
                    Data anggota belum terhubung dengan akun ini. Hubungi administrator untuk memperbaikinya.
                </div>
                @else
                <table class="table no-border">
                    <tbody>
                        <tr>
                            <td><strong>NIK / Username</strong></td>
                            <td>:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->

    @if(!$isMember || $anggota)
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">
                Reset Password
            </h4>
            <div class="p-20">
                @php($formModel = $user)
<form method="post" action="{{ route('user.edit-password', $user->id) }}" class="form-horizontal" id="basic-form">
@csrf
@method('PUT')

                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Password Lama</label>
                        <div class="col-8">
                            <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" autocomplete="current-password" placeholder="Masukan Password Lama">
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Password Baru</label>
                        <div class="col-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Masukan Password Baru">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Konfirmasi Password Baru</label>
                        <div class="col-8">
                            <input id="confirm-password" type="password" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" autocomplete="current-password" placeholder="Konfirmasi Password Baru">
                            @error('confirm-password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>                
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')    
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/jquery.qrcode.min.js')}}"></script>
@endsection