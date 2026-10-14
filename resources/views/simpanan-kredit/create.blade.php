@extends('layouts.master')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.steps/css/jquery.steps.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .create-savings-page .page-title-box {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        min-height: 96px;
        margin-bottom: 24px;
        padding: 22px 28px;
        border: 1px solid var(--k-border);
        border-left: 5px solid var(--k-primary);
        border-radius: var(--k-radius-lg);
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 55%, #f0fdfa 100%);
        box-shadow: var(--k-shadow-sm);
    }

    .create-savings-page .page-title-box:after {
        position: absolute;
        top: -90px;
        right: 10%;
        width: 220px;
        height: 220px;
        border: 1px solid rgba(15, 118, 110, 0.08);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(15, 118, 110, 0.02), 0 0 0 52px rgba(15, 118, 110, 0.015);
        content: "";
        pointer-events: none;
    }

    .create-savings-page .page-title-box > .float-left,
    .create-savings-page .page-title-box > .float-right {
        position: relative;
        z-index: 1;
        float: none !important;
    }

    .create-savings-page .page-title-box h4.page-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 4px;
        color: var(--k-text-main);
        font-size: 21px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .create-savings-page .page-title-sub {
        color: var(--k-text-muted);
        font-size: 12.5px;
    }

    .create-savings-page .breadcrumb {
        justify-content: flex-end;
        margin: 0 0 6px;
        padding: 0;
        background: transparent;
    }

    .create-savings-page .breadcrumb-item,
    .create-savings-page .breadcrumb-item a {
        color: var(--k-text-muted);
        font-size: 11.5px;
    }

    .create-savings-card {
        margin-bottom: 24px;
        padding: 28px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        background: #ffffff;
        box-shadow: var(--k-shadow-xs);
    }

    .create-savings-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--k-border-subtle);
    }

    .create-savings-header h4 {
        margin: 0 0 4px;
        color: var(--k-text-main);
        font-size: 17px;
        font-weight: 750;
    }

    .create-savings-header p {
        margin: 0;
        color: var(--k-text-muted);
        font-size: 13px;
    }

    .transaction-note {
        padding: 16px;
        border: 1px solid var(--k-info-border);
        border-radius: var(--k-radius-md);
        color: var(--k-info-text);
        background: var(--k-info-bg);
    }

    @media (max-width: 767.98px) {
        .create-savings-page .page-title-box {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px 20px;
        }

        .create-savings-page .page-title-box .float-right {
            align-self: flex-start;
            margin-top: 12px;
        }

        .create-savings-page .breadcrumb {
            justify-content: flex-start;
        }

        .create-savings-card {
            padding: 18px;
        }
    }
</style>
@endsection

@section('content')
<div class="create-savings-page">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="float-left">
                    <h4 class="page-title">
                        <i class="mdi mdi-bank text-teal mr-1" aria-hidden="true"></i> Penarikan Simpanan
                    </h4>
                    <div class="page-title-sub">Pencatatan transaksi kredit simpanan anggota koperasi</div>
                </div>
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('simpanan-kredit.index') }}">Simpanan Kredit</a></li>
                        <li class="breadcrumb-item active">Tambah Transaksi</li>
                    </ol>
                    <span class="badge badge-soft-primary">
                        <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i>
                        Periode: {{ periode()->name }}
                        ({{ date('d-m-Y', strtotime(periode()->open_date)) }} s/d {{ date('d-m-Y', strtotime(periode()->close_date)) }})
                    </span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="create-savings-card">
                <div class="create-savings-header">
                    <h4>Formulir Transaksi Simpanan Kredit</h4>
                    <p>Lengkapi informasi anggota, penarikan simpanan, dan keterangan transaksi.</p>
                </div>

                <form id="basic-form" action="{{ route('simpanan-kredit.store') }}" method="POST">
                    @csrf
                    @include('simpanan-kredit._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/jquery.steps/js/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('pages/jquery.wizard-init.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script>
    $(function () {
        $(".select2").select2({
            width: '100%',
            placeholder: 'Pilih opsi...'
        });

        $('.biaya').maskMoney({prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0});

        $('select[name=anggota_id]').on('change', function () {
            var anggotaId = $(this).children("option:selected").val();
            if (!anggotaId) {
                $('#nama-anggota, #nama-jabatan, #status-anggota, #tanggal-daftar').text('-');
                return;
            }

            $.ajax({
                url: '{{ route('transaksi-harian.chek-anggota') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    anggota_id: anggotaId
                },
                success: function (data) {
                    $('#nama-anggota').text(data.nama || '-');
                    $('#nama-jabatan').text(data.jabatan || '-');
                    $('#status-anggota').text(data.status || '-');
                    $('#tanggal-daftar').text(data.tgl_daftar || '-');
                },
                error: function (xhr) {
                    console.error('Gagal memuat data anggota.', xhr.responseText);
                    $.toast({
                        heading: 'Error !',
                        text: 'Data anggota tidak dapat dimuat.',
                        position: 'top-right',
                        loaderBg: '#bf441d',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 1
                    });
                }
            });
        });

        var start = new Date('{{ periode()->open_date }}');
        var end = new Date('{{ periode()->close_date }}');

        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: start,
            endDate: end,
            orientation: 'bottom'
        });
    });
</script>
@endsection
