@extends('layouts.master')
@section('style')
@include('shared.index-page-style')
<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">
                    <i class="fi-tag text-teal mr-1"></i> Pinjaman Kredit
                </h4>
                <small>Daftar transaksi pencairan pinjaman dan jadwal angsuran anggota</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                    <li class="breadcrumb-item active">Pinjaman Kredit</li>
                </ol>
                <span class="badge badge-soft-primary">
                    <i class="mdi mdi-calendar mr-1"></i>
                    Periode: {{ periode()->name }}
                    ({{ date('d-m-Y', strtotime(periode()->open_date)) }} s/d {{ date('d-m-Y', strtotime(periode()->close_date)) }})
                </span>
            </div>
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
@if (session()->has('error'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Divisi</th>
                        <th>Transaksi</th>
                        <th>Pinjaman</th>
                        <th>Produk / Tenor</th>
                        <th>Angsuran per Bulan</th>
                        <th>Keterangan</th>
                        <th>Status Buku</th>
                        @unless($isMember)
                        <th>ACTION DEFAULT</th>
                        @endunless
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- Required datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script>
    $(document).ready(function(){
        var oTable = $('#datatable-buttons').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('pinjaman-kredit.index') }}",
                        columns: [
                            { data: 'nomor_urut', name: 'id', searchable: false },
                            { data: 'nama_anggota.anggota.nama', name: 'nama_anggota.anggota.nama', orderable: false, searchable: false },
                            { data: 'tgl', name: 'tgl' },
                            { data: 'jenis_pembayaran', name: 'jenis_pembayaran' },
                            { data: 'divisi.name', name: 'divisi.name' },
                            { data: 'jenis_transaksi', name: 'jenis_transaksi' },
                            { data: 'sumKreditPinjaman', name: 'sumKreditPinjaman', orderable: false, searchable: false },
                            { data: 'produk_tenor', name: 'produk_tenor', orderable: false, searchable: false },
                            { data: 'angsuran_per_bulan', name: 'angsuran_per_bulan', orderable: false, searchable: false },
                            { data: 'keterangan', name: 'keterangan' },
                            { data: 'is_close', name: 'is_close' },
                            @unless($isMember)
                            { data: 'action', name: 'action', orderable: false, searchable: false },
                            @endunless
                        ],
                        dom: '<"toolbar">frtip',
                        order: [[ 0, 'asc' ]],
                        pageLength: 25,
                        scrollX: true
                    });
                    $("div.toolbar").html(`@unless($isMember)@permission('create-kredit-pinjaman')<a href="{{ route('pinjaman-kredit.create') }}" class="btn btn-gradient waves-light waves-effect w-md"><i class="fa fa-plus"></i> Tambah</a>@endpermission
                    @permission('download-kredit-pinjaman')<a href="{{ route('pinjaman-kredit.template') }}" class="btn btn-success waves-light waves-effect w-md"><i class="mdi mdi-file-excel"></i>Download Template</a>@endpermission
                    @permission('upload-kredit-pinjaman')<a href="{{ route('pinjaman-kredit.upload') }}" class="btn btn-warning waves-light waves-effect w-md"><i class="mdi mdi-cloud-upload"></i> Upload</a>@endpermission
                    @if(!$isMember && Pembukuan::closeBook('2', '2', ['8']) == '1')
                        <a href="{{ route('pinjaman-kredit.close-book') }}" class="btn btn-danger waves-light waves-effect w-md"><i class="fa fa-book"></i> Tutup Buku</a>
                    @endif
                    @endunless`);
    });
</script>
@endsection
