@extends('layouts.master')
@section('style')
@include('shared.index-page-style')
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
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
            <table id="produk-pinjaman-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Keterangan</th>
                        <th>Pilihan Tenor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produkPinjaman as $produk)
                        <tr>
                            <td>{{ $produk->id }}</td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#produk-pinjaman-table').DataTable({
            responsive: true,
            pageLength: 15,
            columnDefs: [
                { targets: 0, visible: false, searchable: false }
            ],
            order: [[0, 'asc']],
            dom: '<"toolbar">frtip',
            language: {
                emptyTable: 'Belum ada produk pinjaman.',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ produk',
                infoEmpty: 'Tidak ada produk untuk ditampilkan',
                infoFiltered: '(disaring dari _MAX_ produk)',
                lengthMenu: 'Tampilkan _MENU_ produk',
                loadingRecords: 'Memuat...',
                processing: 'Memproses...',
                search: '',
                searchPlaceholder: 'Cari nama produk pinjaman',
                zeroRecords: 'Produk pinjaman tidak ditemukan',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });

        const actions = [];
        @permission('create-produk-pinjaman')
            actions.push('<a href="{{ route('produk-pinjaman.create') }}" class="btn btn-gradient"><i class="mdi mdi-plus" aria-hidden="true"></i> Tambah</a>');
        @endpermission
        @permission('download-produk-pinjaman')
            actions.push('<a href="{{ route('produk-pinjaman.template') }}" class="btn btn-success"><i class="mdi mdi-file-excel" aria-hidden="true"></i> Download Template</a>');
        @endpermission
        @permission('upload-produk-pinjaman')
            actions.push('<a href="{{ route('produk-pinjaman.upload') }}" class="btn btn-warning"><i class="mdi mdi-cloud-upload" aria-hidden="true"></i> Upload</a>');
        @endpermission

        $('.dataTables_wrapper .toolbar').html(actions.join(''));
    });
</script>
@endsection
