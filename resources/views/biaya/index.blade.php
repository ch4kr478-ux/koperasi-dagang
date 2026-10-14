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
                <h4 class="page-title">Biaya </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active">Biaya</li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->

<!-- end row -->
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nama Biaya</th>
                        <th>Jenis Biaya</th>
                        <th>Divisi</th>
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
    $(document).ready(function () {
        $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('biaya.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'jenis_biaya', name: 'jenis_biaya' },
                { data: 'divisi.name', name: 'divisi.name' },
                { data: 'action', name: 'action', searchable: false, orderable: false }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            dom: '<"toolbar">frtip',
            language: {
                search: '',
                searchPlaceholder: 'Cari nama biaya',
                lengthMenu: 'Tampilkan _MENU_ biaya',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ biaya',
                infoEmpty: 'Belum ada data biaya',
                infoFiltered: '(disaring dari _MAX_ biaya)',
                zeroRecords: 'Biaya yang dicari tidak ditemukan',
                emptyTable: 'Belum ada data biaya.',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                }
            }
        });

        var actions = [];
        @permission('create-biaya')
        actions.push('<a href="{{ route('biaya.create') }}" class="btn btn-primary"><i class="mdi mdi-plus mr-1"></i> Tambah Biaya</a>');
        @endpermission
        @permission('manage-biaya')
        actions.push('<a href="{{ route('biaya.template') }}" class="btn btn-success"><i class="mdi mdi-file-excel-outline mr-1"></i> Unduh Template Excel</a>');
        @endpermission
        if (actions.length) {
            $('div.toolbar').html(actions.join(''));
        }
    });
</script>
@endsection
