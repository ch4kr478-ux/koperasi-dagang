@extends('layouts.master')
@section('style')
@include('shared.index-page-style')
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@php($periodeAktif = periode())
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">
                    <i class="mdi mdi-account-multiple text-teal mr-1" aria-hidden="true"></i> Data Anggota
                </h4>
                <small>Kelola informasi anggota dan status keanggotaan koperasi.</small>
            </div>
            <div class="float-right text-md-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Anggota</li>
                </ol>
                <span class="badge badge-soft-primary">
                    <i class="mdi mdi-calendar-range mr-1" aria-hidden="true"></i>
                    {{ $periodeAktif ? $periodeAktif->name : 'Belum ada periode aktif' }}
                    @if($periodeAktif)
                        ({{ \Carbon\Carbon::parse($periodeAktif->open_date)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($periodeAktif->close_date)->format('d-m-Y') }})
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

@if(session()->has('flash_notification.message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-{{ session()->get('flash_notification.level', 'success') }} alert-dismissible fade show" role="alert">
            {{ session()->get('flash_notification.message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="header-title mb-1">Daftar Anggota</h5>
                    <p class="text-muted mb-0">Cari anggota berdasarkan NIK atau nama.</p>
                </div>
            </div>
            <table id="anggota-table" class="table table-striped table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama Anggota</th>
                        <th>Nomor Telepon</th>
                        <th>Jabatan</th>
                        <th>Tanggal Daftar</th>
                        <th>Home Base</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
        $('#anggota-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('anggota.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'no_telepon', name: 'no_telepon' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'tgl_daftar', name: 'tgl_daftar' },
                { data: 'homebase', name: 'homebase' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            dom: '<"toolbar">frtip',
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                processing: 'Memuat data anggota...',
                search: '',
                searchPlaceholder: 'Cari NIK atau nama anggota',
                lengthMenu: 'Tampilkan _MENU_ anggota',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ anggota',
                infoEmpty: 'Belum ada data anggota',
                infoFiltered: '(disaring dari _MAX_ anggota)',
                zeroRecords: 'Anggota yang dicari tidak ditemukan',
                emptyTable: 'Belum ada data anggota.',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                }
            }
        });

        var actions = [];
        @permission('create-anggota')
        actions.push('<a href="{{ route('anggota.create') }}" class="btn btn-primary"><i class="mdi mdi-account-plus mr-1"></i> Tambah</a>');
        @endpermission
        @permission('download-anggota')
        actions.push('<a href="{{ route('anggota.export') }}" class="btn btn-success"><i class="mdi mdi-file-excel mr-1"></i> Unduh Excel</a>');
        @endpermission
        if (actions.length) {
            $('div.toolbar').html(actions.join(''));
        }
    });
</script>
@endsection
