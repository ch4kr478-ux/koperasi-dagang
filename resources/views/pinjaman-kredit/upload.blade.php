@extends('layouts.master')
@section('style')
@include('shared.index-page-style')
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">
                    <i class="mdi mdi-cloud-upload text-teal mr-1"></i> Upload Pinjaman Kredit
                </h4>
                <small>Impor transaksi pinjaman dari file Excel</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pinjaman-kredit.index') }}">Pinjaman Kredit</a></li>
                    <li class="breadcrumb-item active">Upload</li>
                </ol>
                <span class="badge badge-soft-primary">
                    <i class="mdi mdi-calendar mr-1"></i> Periode: {{ periode()->name }}
                </span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>File belum dapat diproses.</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="mb-4">
                <h4 class="header-title mb-1">Impor Data Pinjaman</h4>
                <p class="text-muted mb-0">
                    Unggah file Excel dengan kolom Produk Pinjaman pada kolom terakhir. Nama produk dan tenor harus aktif, dan nominal dalam file harus sama dengan nominal tetap produk.
                </p>
            </div>
            <form id="basic-form" action="{{ route('pinjaman-kredit.doupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label" for="transaction-file">File Excel <span class="text-danger">*</span></label>
                    <input class="form-control-file" id="transaction-file" name="file" type="file" required autocomplete="off">
                    @error('file')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                    <small class="form-text text-muted">Pilih file template transaksi pinjaman yang telah diisi.</small>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="mdi mdi-cloud-upload mr-1"></i> Upload dan                     <i class="mdi mdi-content-save" aria-hidden="true"></i> Simpan
                </button>
                <a href="{{ route('pinjaman-kredit.index') }}" class="btn btn-light"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
