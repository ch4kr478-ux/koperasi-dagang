@extends('layouts.master')
@section('style')
@include('shared.index-page-style')
<style>
    .product-list-toolbar {
        gap: 12px;
    }

    .product-search-form {
        width: min(100%, 360px);
    }

    .product-search-form .form-control {
        min-height: 38px;
    }

    @media (max-width: 575.98px) {
        .product-list-toolbar {
            align-items: stretch !important;
        }

        .product-search-form {
            width: 100%;
        }
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Produk Pinjaman</h4>
                <small>Impor produk dan pilihan tenor dari file Excel</small>
            </div>
            <div class="float-right text-md-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('produk-pinjaman.index') }}">Produk Pinjaman</a></li>
                    <li class="breadcrumb-item active">Upload</li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
        </div>
    </div>
</div>

@if(session('success') || session('error'))
    <div class="alert alert-{{ session('error') ? 'danger' : 'success' }} alert-dismissible fade show" role="alert">
        {{ session('error', session('success')) }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <div class="product-list-toolbar d-flex flex-wrap align-items-center justify-content-start mb-3">
                <div class="d-flex flex-wrap align-items-center mb-2 mb-sm-0">
                    @permission('create-produk-pinjaman')
                        <a href="{{ route('produk-pinjaman.create') }}" class="btn btn-gradient mr-2 mb-2"><i class="mdi mdi-plus" aria-hidden="true"></i> Tambah</a>
                    @endpermission
                    @permission('download-produk-pinjaman')
                        <a href="{{ route('produk-pinjaman.template') }}" class="btn btn-success mr-2 mb-2"><i class="mdi mdi-file-excel" aria-hidden="true"></i> Download Template</a>
                    @endpermission
                    @permission('upload-produk-pinjaman')
                        <a href="{{ route('produk-pinjaman.upload') }}" class="btn btn-warning mb-2"><i class="mdi mdi-cloud-upload" aria-hidden="true"></i> Upload</a>
                    @endpermission
                </div>

                <form method="GET" action="{{ route('produk-pinjaman.index') }}" class="product-search-form mb-2">
                    <label class="sr-only" for="product-search">Cari produk pinjaman</label>
                    <div class="input-group">
                        <input type="search" id="product-search" name="search" value="{{ $search }}" class="form-control" placeholder="Cari nama, keterangan, tenor..." maxlength="100">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" aria-label="Cari">
                                <i class="mdi mdi-magnify" aria-hidden="true"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Keterangan</th>
                        <th>Pilihan Tenor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkPinjaman as $produk)
                        <tr>
                            <td>{{ $produk->name }}</td>
                            <td>{{ $produk->nominal ? 'Rp. ' . number_format($produk->nominal, 0, ',', '.') : 'Belum diatur' }}</td>
                            <td>{{ $produk->description ?: '-' }}</td>
                            <td>{{ $produk->tenors->pluck('lama_cicilan')->sort()->map(function ($months) { return $months . ' bulan'; })->implode(', ') }}</td>
                            <td>
                                <span class="badge badge-{{ $produk->is_active ? 'success' : 'secondary' }}">
                                    {{ $produk->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-nowrap">
                                @permission('edit-produk-pinjaman')
                                    <a href="{{ route('produk-pinjaman.edit', $produk->id) }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil" aria-hidden="true"></i> Ubah</a>
                                @endpermission
                                @permission('delete-produk-pinjaman')
                                    <form method="POST" action="{{ route('produk-pinjaman.destroy', $produk->id) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus produk pinjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i> Hapus</button>
                                    </form>
                                @endpermission
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                {{ $search ? 'Tidak ada produk pinjaman yang cocok dengan pencarian.' : 'Belum ada produk pinjaman.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $produkPinjaman->links() }}
        </div>
    </div>
</div>
@endsection
