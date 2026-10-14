@extends('layouts.master')
@section('style')
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
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
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">Profile Pengguna</h4>
            <div class="p-20">
                @if ($anggota)
                    <form method="post" action="{{ route('user.update-member-profile', $user->id) }}" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-4 col-form-label">NIK / Username</label>
                            <div class="col-8">
                                <input type="text" class="form-control" value="{{ $anggota->nik }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Nama</label>
                            <div class="col-8">
                                <input type="text" class="form-control" value="{{ $anggota->nama }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label" for="profile-inisial">Nama Inisial</label>
                            <div class="col-8">
                                <input id="profile-inisial" type="text" name="inisial" value="{{ old('inisial', $anggota->inisial) }}" class="form-control @error('inisial') is-invalid @enderror" required maxlength="255">
                                @error('inisial')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label" for="profile-tgl-daftar">Tanggal Daftar</label>
                            <div class="col-8">
                                <input id="profile-tgl-daftar" type="text" name="tgl_daftar" value="{{ old('tgl_daftar', $anggota->tgl_daftar ? date('d-m-Y', strtotime($anggota->tgl_daftar)) : '') }}" class="form-control datepicker @error('tgl_daftar') is-invalid @enderror" autocomplete="off" required>
                                @error('tgl_daftar')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label" for="profile-status">Status</label>
                            <div class="col-8">
                                <input id="profile-status" type="text" class="form-control" value="{{ (string) $anggota->status === '1' ? 'Aktif' : 'Non Aktif' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label" for="profile-homebase">Alamat Rumah</label>
                            <div class="col-8">
                                <input id="profile-homebase" type="text" name="homebase" value="{{ old('homebase', $anggota->homebase) }}" class="form-control @error('homebase') is-invalid @enderror" maxlength="255">
                                @error('homebase')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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
    </div>
</div>
@endsection
@section('script')    
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery.qrcode.min.js')}}"></script>
<script>
    $(function () {
        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: 'bottom'
        });
    });
</script>
@endsection