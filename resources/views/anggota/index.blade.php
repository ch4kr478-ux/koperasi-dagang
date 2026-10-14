@extends('layouts.master')
@section('style')
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .anggota-index {
        padding-bottom: 24px;
        color: #465166;
    }

    .anggota-index .anggota-heading {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        margin-bottom: 23px;
        padding: 24px 28px;
        border: 1px solid #e5eaf3;
        border-radius: 14px;
        background: linear-gradient(115deg, #fff 0%, #f6f8fc 68%, #eef2f8 100%);
        box-shadow: 0 7px 22px rgba(35, 47, 74, .045);
    }

    .anggota-index .anggota-heading:after {
        position: absolute;
        top: -95px;
        right: 15%;
        width: 220px;
        height: 220px;
        border: 1px solid rgba(106, 127, 177, .1);
        border-radius: 50%;
        box-shadow: 0 0 0 23px rgba(106, 127, 177, .03), 0 0 0 48px rgba(106, 127, 177, .02);
        content: "";
        pointer-events: none;
    }

    .anggota-index .heading-main,
    .anggota-index .heading-actions {
        position: relative;
        z-index: 1;
    }

    .anggota-index .heading-eyebrow {
        margin-bottom: 6px;
        color: #8792a5;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .anggota-index .anggota-heading h4 {
        margin-bottom: 5px;
        color: #344054;
        font-size: 21px;
        font-weight: 700;
    }

    .anggota-index .heading-description {
        margin: 0;
        color: #818b9c;
        font-size: 12px;
    }

    .anggota-index .heading-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 9px;
    }

    .anggota-index .heading-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .anggota-index .btn-add-member {
        border: 1px solid #5e806b;
        color: #fff;
        background: #668873;
        box-shadow: 0 3px 8px rgba(84, 131, 106, .15);
    }

    .anggota-index .btn-add-member:hover {
        border-color: #4e705b;
        color: #fff;
        background: #587a64;
    }

    .anggota-index .btn-export-member {
        border: 1px solid #dfe5ed;
        color: #596477;
        background: rgba(255, 255, 255, .82);
    }

    .anggota-index .btn-export-member:hover {
        border-color: #cbd4e0;
        color: #394458;
        background: #fff;
    }

    .anggota-index .period-card {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 14px 18px;
        border: 1px solid #e9edf3;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(35, 47, 74, .025);
    }

    .anggota-index .period-icon {
        display: inline-flex;
        flex: 0 0 36px;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin-right: 12px;
        border-radius: 10px;
        color: #7180a1;
        background: #f0f2f8;
        font-size: 16px;
    }

    .anggota-index .period-label {
        display: block;
        margin-bottom: 2px;
        color: #929aaa;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .anggota-index .period-value {
        color: #566176;
        font-size: 11px;
        font-weight: 600;
    }

    .anggota-index .period-date {
        margin-left: auto;
        padding-left: 14px;
        color: #778196;
        font-size: 11px;
        white-space: nowrap;
    }

    .anggota-index .anggota-alert {
        margin-bottom: 18px;
        border: 1px solid #e8ebf1;
        border-radius: 9px;
        font-size: 12px;
    }

    .anggota-index .table-panel {
        overflow: hidden;
        padding: 0;
        border: 1px solid #e8ecf2;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(35, 47, 74, .04);
    }

    .anggota-index .table-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 19px 22px;
        border-bottom: 1px solid #edf0f5;
    }

    .anggota-index .table-panel-heading h5 {
        margin: 0 0 4px;
        color: #394458;
        font-size: 14px;
        font-weight: 700;
    }

    .anggota-index .table-panel-heading p {
        margin: 0;
        color: #8a93a2;
        font-size: 11px;
    }

    .anggota-index .table-count-label {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border: 1px solid #e8ebf1;
        border-radius: 16px;
        color: #7b8494;
        background: #f8f9fb;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .anggota-index .table-content {
        padding: 18px 22px 14px;
    }

    .anggota-index .dataTables_wrapper {
        color: #7b8494;
        font-size: 11px;
    }

    .anggota-index .dataTables_filter {
        margin-bottom: 13px;
        text-align: right;
    }

    .anggota-index .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        margin: 0;
        color: #7b8494;
        font-weight: 500;
    }

    .anggota-index .dataTables_filter input {
        width: 230px;
        height: 36px;
        margin-left: 0 !important;
        padding: 7px 11px;
        border: 1px solid #e3e7ee;
        border-radius: 7px;
        color: #465166;
        background: #fff;
        outline: 0;
        box-shadow: none;
    }

    .anggota-index .dataTables_filter input:focus {
        border-color: #aebbd2;
        box-shadow: 0 0 0 3px rgba(106, 127, 177, .09);
    }

    .anggota-index table.dataTable {
        width: 100% !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 0;
    }

    .anggota-index table.dataTable thead th {
        padding: 12px 13px;
        border-top: 1px solid #edf0f5;
        border-bottom: 1px solid #e8ecf2;
        color: #7f8999;
        background: #f8f9fb;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .055em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .anggota-index table.dataTable thead th:first-child {
        border-left: 1px solid #edf0f5;
        border-top-left-radius: 7px;
    }

    .anggota-index table.dataTable thead th:last-child {
        border-right: 1px solid #edf0f5;
        border-top-right-radius: 7px;
        text-align: center;
    }

    .anggota-index table.dataTable tbody td {
        padding: 12px 13px;
        border-top: 0;
        border-bottom: 1px solid #f0f2f6;
        color: #596477;
        font-size: 11px;
        vertical-align: middle;
    }

    .anggota-index table.dataTable tbody tr:hover {
        background: #fafbfd;
    }

    .anggota-index table.dataTable tbody td:first-child {
        color: #929aaa;
        font-variant-numeric: tabular-nums;
    }

    .anggota-index table.dataTable tbody td:nth-child(3) {
        color: #445066;
        font-weight: 600;
    }

    .anggota-index table.dataTable tbody td:last-child {
        min-width: 140px;
        text-align: center;
        white-space: nowrap;
    }

    .anggota-index .badge {
        padding: 5px 9px;
        border-radius: 14px;
        font-size: 9px;
        font-weight: 700;
    }

    .anggota-index .badge-gradient {
        border: 1px solid #deebe2;
        color: #54836a;
        background: #edf5f0;
    }

    .anggota-index .badge-danger {
        border: 1px solid #f0dfe1;
        color: #aa6c70;
        background: #f9eff0;
    }

    .anggota-index .table-panel .btn-sm {
        margin: 2px 1px;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
    }

    .anggota-index .table-panel .btn-primary {
        border-color: #dce4f1;
        color: #657697;
        background: #f1f4f9;
    }

    .anggota-index .table-panel .btn-danger {
        border-color: #f0dfe1;
        color: #a6666b;
        background: #fbf1f2;
    }

    .anggota-index .dataTables_info {
        padding-top: 10px;
        color: #8a93a2;
    }

    .anggota-index .pagination {
        justify-content: flex-end;
        margin: 8px 0 0;
    }

    .anggota-index .page-item .page-link {
        margin-left: 3px;
        border: 1px solid #e8ebf1;
        border-radius: 6px;
        color: #68748a;
        background: #fff;
        font-size: 10px;
    }

    .anggota-index .page-item.active .page-link {
        border-color: #718c7a;
        color: #fff;
        background: #718c7a;
    }

    .anggota-index .dataTables_processing {
        padding: 12px;
        border: 1px solid #e8ecf2;
        border-radius: 8px;
        color: #68748a;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 4px 16px rgba(35, 47, 74, .07);
    }

    @media (max-width: 767.98px) {
        .anggota-index .anggota-heading {
            align-items: flex-start;
            flex-direction: column;
            padding: 21px;
        }

        .anggota-index .heading-actions {
            justify-content: flex-start;
            margin-top: 17px;
        }

        .anggota-index .period-card {
            align-items: flex-start;
        }

        .anggota-index .period-date {
            max-width: 48%;
            text-align: right;
            white-space: normal;
        }

        .anggota-index .table-panel-heading,
        .anggota-index .table-content {
            padding-right: 15px;
            padding-left: 15px;
        }

        .anggota-index .table-count-label {
            display: none;
        }

        .anggota-index .dataTables_filter {
            text-align: left;
        }

        .anggota-index .dataTables_filter label,
        .anggota-index .dataTables_filter input {
            width: 100%;
        }

        .anggota-index .pagination {
            justify-content: flex-start;
        }
    }
</style>
@endsection
@section('content')
@php($periodeAktif = periode())
<div class="anggota-index">
    <div class="anggota-heading">
        <div class="heading-main">
            <div class="heading-eyebrow">Master Data · Koperasi</div>
            <h4>Data Anggota</h4>
            <p class="heading-description">Kelola informasi anggota dan status keanggotaan koperasi.</p>
        </div>
        <div class="heading-actions">
            @permission('create-anggota')
            <a href="{{ route('anggota.create') }}" class="btn btn-add-member">
                <i class="mdi mdi-account-plus-outline mr-1" aria-hidden="true"></i> Tambah Anggota
            </a>
            @endpermission
            @permission('download-anggota')
            <a href="{{ route('anggota.export') }}" class="btn btn-export-member">
                <i class="mdi mdi-file-excel-outline mr-1" aria-hidden="true"></i> Unduh Excel
            </a>
            @endpermission
        </div>
    </div>

    @if(session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level', 'success') }} alert-dismissible fade show anggota-alert" role="alert">
            {{ session()->get('flash_notification.message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="period-card">
        <span class="period-icon"><i class="mdi mdi-calendar-range" aria-hidden="true"></i></span>
        <div>
            <span class="period-label">Periode aktif</span>
            <span class="period-value">{{ $periodeAktif ? $periodeAktif->name : 'Belum ada periode aktif' }}</span>
        </div>
        @if($periodeAktif)
            <span class="period-date">
                Tahun buku
                {{ \Carbon\Carbon::parse($periodeAktif->open_date)->format('d M Y') }}
                – {{ \Carbon\Carbon::parse($periodeAktif->close_date)->format('d M Y') }}
            </span>
        @endif
    </div>

    <div class="table-panel">
        <div class="table-panel-heading">
            <div>
                <h5>Daftar Anggota</h5>
                <p>Gunakan pencarian untuk menemukan anggota berdasarkan data yang tercatat.</p>
            </div>
            <span class="table-count-label"><i class="mdi mdi-account-multiple-outline mr-1" aria-hidden="true"></i> Direktori anggota</span>
        </div>
        <div class="table-content">
            <table id="anggota-table" class="table table-hover" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama Anggota</th>
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
                { data: 'jabatan', name: 'jabatan' },
                { data: 'tgl_daftar', name: 'tgl_daftar' },
                { data: 'homebase', name: 'homebase' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            dom: '<"row"<"col-12"f>>rt<"row align-items-center"<"col-md-5"i><"col-md-7"p>>',
            order: [[0, 'desc']],
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
    });
</script>
@endsection
