@extends('layouts.master')
@section('style')
<!--Form Wizard-->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.steps/css/jquery.steps.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    /* Page specific refinement */
    .create-loan-page .page-title-box {
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

    .create-loan-page .page-title-box:after {
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

    .create-loan-page .page-title-box h4.page-title {
        margin: 0 0 4px;
        color: var(--k-text-main);
        font-size: 21px;
        font-weight: 800;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .create-loan-page .page-title-sub {
        color: var(--k-text-muted);
        font-size: 12.5px;
    }

    .create-loan-page .breadcrumb {
        justify-content: flex-end;
        margin: 0 0 6px;
        padding: 0;
        background: transparent;
    }

    .create-loan-page .breadcrumb-item,
    .create-loan-page .breadcrumb-item a {
        color: var(--k-text-muted);
        font-size: 11.5px;
    }

    .create-loan-card {
        background: #ffffff;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        padding: 28px;
        box-shadow: var(--k-shadow-xs);
        margin-bottom: 24px;
    }

    .create-loan-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--k-border-subtle);
    }

    .create-loan-header h4 {
        margin: 0 0 4px;
        font-size: 17px;
        font-weight: 750;
        color: var(--k-text-main);
    }

    .create-loan-header p {
        margin: 0;
        color: var(--k-text-muted);
        font-size: 13px;
    }

    /* Member Card Detail */
    .member-info-panel {
        background: var(--k-surface-alt);
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-md);
        padding: 20px;
        margin-top: 16px;
        transition: all 0.2s ease;
    }

    .member-info-panel-title {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--k-primary);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .member-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .member-info-item .item-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--k-text-muted);
        margin-bottom: 4px;
    }

    .member-info-item .item-val {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--k-text-main);
    }

    /* Installment Preview Box */
    .installment-summary-card {
        background: linear-gradient(145deg, #ffffff 0%, #f0fdfa 100%);
        border: 1.5px solid var(--k-primary-border);
        border-radius: var(--k-radius-lg);
        padding: 22px;
        margin-top: 20px;
        box-shadow: 0 4px 16px rgba(15, 118, 110, 0.06);
    }

    .installment-summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(15, 118, 110, 0.15);
    }

    .installment-summary-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--k-primary-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .installment-table {
        margin-bottom: 12px;
    }

    .installment-table tr td,
    .installment-table tr th {
        padding: 10px 0;
        border-top: 1px solid rgba(15, 118, 110, 0.1);
        font-size: 13px;
    }

    .installment-table tr:first-child td,
    .installment-table tr:first-child th {
        border-top: none;
    }

    .installment-table .total-row th,
    .installment-table .total-row td {
        border-top: 2px solid var(--k-primary-border);
        padding-top: 14px;
        font-size: 15px;
    }

    .installment-table .total-value {
        color: var(--k-primary);
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    @media (max-width: 767.98px) {
        .create-loan-page .page-title-box {
            flex-direction: column;
            align-items: flex-start;
            padding: 18px 20px;
        }

        .create-loan-page .page-title-box .float-right {
            margin-top: 12px;
            align-self: flex-start;
        }

        .create-loan-page .breadcrumb {
            justify-content: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="create-loan-page">
    <!-- Corporate Header Banner -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="float-left">
                    <h4 class="page-title">
                        <i class="fi-tag text-teal mr-1"></i> Perbarui Pinjaman Kredit
                    </h4>
                    <div class="page-title-sub">Pembaruan data transaksi kredit pinjaman dan jadwal tenor cicilan</div>
                </div>
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pinjaman-kredit.index') }}">Pinjaman Kredit</a></li>
                        <li class="breadcrumb-item active">Perbarui Pinjaman</li>
                    </ol>
                    <span class="badge badge-soft-primary">
                        <i class="mdi mdi-calendar mr-1"></i> Periode: {{ periode()->name }} ({{ date('d-m-Y', strtotime(periode()->open_date)) }} s/d {{ date('d-m-Y', strtotime(periode()->close_date)) }})
                    </span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Main Wizard Card -->
    <div class="row">
        <div class="col-12">
            <div class="create-loan-card">
                <div class="create-loan-header">
                    <h4>Formulir Perubahan Transaksi Pinjaman</h4>
                    <p>Sesuaikan data transaksi pinjaman kredit di bawah ini dengan benar.</p>
                </div>

                @php($formModel = $transaksiHarian)
                <form method="post" action="{{ route('pinjaman-kredit.update', $transaksiHarian->id) }}" class="form-horizontal" id="basic-form">
                    @csrf
                    @method('PUT')
                    @include('pinjaman-kredit._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!--Form Wizard-->
<script src="{{ asset('plugins/jquery.steps/js/jquery.steps.min.js') }}" type="text/javascript"></script>

<!--wizard initialization-->
<script src="{{ asset('pages/jquery.wizard-init.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.maskMoney.js')}}" type="text/javascript"></script>
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>

<script>
    $(function(){
        $(".select2").select2({
            width: '100%',
            placeholder: 'Pilih opsi...'
        });

        $('.biaya').maskMoney({prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0});

        $('select[name=anggota_id]').on('change', function(){
            var anggotaId = $(this).children("option:selected").val();
            if (!anggotaId) {
                $('#nama-anggota').text('-');
                $('#nama-jabatan').text('-');
                $('#status-anggota').text('-');
                $('#tanggal-daftar').text('-');
                return;
            }

            $.ajax({
                url: '{{ route('transaksi-harian.chek-anggota')}}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    anggota_id: anggotaId
                },
                success: function(data)
                {
                    $('#nama-anggota').text(data.nama || '-');
                    $('#nama-jabatan').text(data.jabatan || '-');
                    $('#status-anggota').text(data.status || 'Aktif');
                    $('#tanggal-daftar').text(data.tgl_daftar || '-');
                }
            });
        });

        // Trigger on initial load if editing
        if ($('select[name=anggota_id]').val()) {
            $('select[name=anggota_id]').trigger('change');
        }

        var start = new Date('{{ periode()->open_date }}');
        var end = new Date('{{ periode()->close_date }}');

        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: start,
            endDate   : end,
            orientation: 'bottom'
        });
    });
</script>
@include('pinjaman-kredit._product-tenor-script')
@endsection
