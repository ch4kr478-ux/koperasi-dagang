@extends('layouts.master')
@section('style')
@include('shared.index-page-style')
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title"><i class="mdi mdi-cloud-upload text-teal mr-1"></i> Upload Produk Pinjaman</h4>
                <small>Impor produk dan pilihan tenor dari file Excel</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('produk-pinjaman.index') }}">Produk Pinjaman</a></li>
                    <li class="breadcrumb-item active">Upload</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>File belum dapat diproses.</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="header-title mb-1">Impor Data Produk Pinjaman</h4>
            <p class="text-muted">
                Isi template dengan nama produk, nominal, keterangan, daftar tenor (pisahkan dengan koma), dan status aktif (1 atau 0).
                Nama produk harus unik; setiap tenor harus bernilai 1 sampai 600 bulan.
            </p>
            <form action="{{ route('produk-pinjaman.doupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="product-file">File Excel <span class="text-danger">*</span></label>
                    <input class="form-control-file" id="product-file" name="file" type="file" accept=".xlsx,.xls,.csv" required>
                    @error('file')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning"><i class="mdi mdi-cloud-upload" aria-hidden="true"></i> Upload</button>
                <a href="{{ route('produk-pinjaman.template') }}" class="btn btn-success"><i class="mdi mdi-file-excel" aria-hidden="true"></i> Download Template</a>
                <a href="{{ route('produk-pinjaman.index') }}" class="btn btn-light"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
