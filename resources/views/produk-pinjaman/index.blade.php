@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Produk Pinjaman</h4>
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
            @permission('create-produk-pinjaman')
                <a href="{{ route('produk-pinjaman.create') }}" class="btn btn-primary mb-3">Tambah Produk Pinjaman</a>
            @endpermission
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
                                    <a href="{{ route('produk-pinjaman.edit', $produk->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                                @endpermission
                                @permission('delete-produk-pinjaman')
                                    <form method="POST" action="{{ route('produk-pinjaman.destroy', $produk->id) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus produk pinjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endpermission
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada produk pinjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $produkPinjaman->links() }}
        </div>
    </div>
</div>
@endsection
