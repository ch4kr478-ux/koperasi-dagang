@extends('layouts.master')
@section('style')
<style>
    .admin-dashboard {
        padding-bottom: 24px;
        color: #465166;
    }

    .admin-dashboard .dashboard-heading {
        position: relative;
        overflow: hidden;
        padding: 26px 30px;
        border: 1px solid #e5eaf3;
        border-radius: 12px;
        color: #344054;
        background: linear-gradient(115deg, #fff 0%, #f5f7fc 66%, #eef2fa 100%);
        box-shadow: 0 8px 24px rgba(35, 47, 74, .055);
    }

    .admin-dashboard .dashboard-heading:after {
        position: absolute;
        top: -80px;
        right: 16%;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(106, 127, 177, .11);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(106, 127, 177, .035), 0 0 0 50px rgba(106, 127, 177, .025);
        content: "";
        pointer-events: none;
    }

    .admin-dashboard .dashboard-heading h4,
    .admin-dashboard .dashboard-heading .breadcrumb-item,
    .admin-dashboard .dashboard-heading .breadcrumb-item a {
        color: #465166;
    }

    .admin-dashboard .dashboard-heading h4 {
        margin-bottom: 5px;
        font-size: 21px;
        font-weight: 700;
    }

    .admin-dashboard .dashboard-heading .float-left,
    .admin-dashboard .dashboard-heading .float-right {
        position: relative;
        z-index: 1;
    }

    .admin-dashboard .dashboard-heading .breadcrumb {
        background: transparent;
        margin-bottom: 7px;
        padding: 0;
    }

    .admin-dashboard .period-caption {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border: 1px solid #e5e9f1;
        border-radius: 20px;
        color: #68748a;
        background: rgba(255, 255, 255, .72);
        font-size: 11px;
    }

    .admin-dashboard .dashboard-subtitle {
        color: #7d8798;
    }

    .admin-dashboard .dashboard-card,
    .admin-dashboard .dashboard-panel {
        height: calc(100% - 22px);
        border: 1px solid #e9edf3;
        border-radius: 11px;
        box-shadow: 0 4px 14px rgba(35, 47, 74, .04);
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .admin-dashboard .dashboard-card:hover,
    .admin-dashboard .dashboard-panel:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 22px rgba(35, 47, 74, .075);
    }

    .admin-dashboard .dashboard-card {
        position: relative;
        overflow: hidden;
        min-height: 178px;
        padding: 21px 22px;
        background: #fff;
    }

    .admin-dashboard .dashboard-card:before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #a7b5d4, #e5eaf4);
        content: "";
    }

    .admin-dashboard .dashboard-card.credit-card:before {
        background: linear-gradient(90deg, #d5b2b6, #f1e5e7);
    }

    .admin-dashboard .dashboard-section-title {
        display: flex;
        align-items: center;
        margin: 2px 0 14px;
        color: #667085;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .admin-dashboard .dashboard-section-title:after {
        flex: 1;
        height: 1px;
        margin-left: 12px;
        background: #e9edf3;
        content: "";
    }

    .admin-dashboard .dashboard-card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        margin-bottom: 13px;
        border: 1px solid rgba(84, 131, 106, .06);
        border-radius: 12px;
        font-size: 17px;
    }

    .admin-dashboard .dashboard-card-icon.debit {
        color: #54836a;
        background: #edf5f0;
    }

    .admin-dashboard .dashboard-card-icon.credit {
        color: #aa6c70;
        background: #f9eff0;
    }

    .admin-dashboard .dashboard-card-label {
        margin-bottom: 7px;
        color: #7b8494;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .055em;
        text-transform: uppercase;
    }

    .admin-dashboard .dashboard-card-value {
        margin-bottom: 4px;
        color: #344054;
        font-size: 19px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .admin-dashboard .dashboard-card-note {
        margin: 0;
        color: #929aaa;
        font-size: 12px;
    }

    .admin-dashboard .dashboard-panel {
        margin-bottom: 20px;
        padding: 23px 25px;
        background: #fff;
    }

    .admin-dashboard .dashboard-panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f2f6;
    }

    .admin-dashboard .dashboard-panel-heading h5 {
        margin-bottom: 4px;
        color: #394458;
        font-size: 15px;
        font-weight: 650;
    }

    .admin-dashboard .dashboard-panel-heading p {
        margin: 0;
        color: #8a93a2;
        font-size: 12px;
    }

    .admin-dashboard .activity-table th {
        border-top: 0;
        color: #858e9d;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-dashboard .activity-table td {
        vertical-align: middle;
        color: #596477;
        font-size: 12px;
    }

    .admin-dashboard .activity-table tbody tr:hover,
    .admin-dashboard .flow-table tbody tr:hover {
        background-color: #f8f9fc;
    }

    .admin-dashboard .flow-table th {
        border-top: 0;
        color: #858e9d;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-dashboard .flow-table td {
        vertical-align: middle;
        color: #596477;
        font-size: 12px;
    }

    .admin-dashboard .activity-badge {
        display: inline-block;
        min-width: 62px;
        padding: 4px 9px;
        border-radius: 16px;
        text-align: center;
        font-size: 11px;
        font-weight: 600;
    }

    .admin-dashboard .activity-badge.debit {
        color: #54836a;
        background: #edf5f0;
    }

    .admin-dashboard .activity-badge.credit {
        color: #aa6c70;
        background: #f9eff0;
    }

    .admin-dashboard .dashboard-chart {
        height: 300px;
        padding: 8px 4px 0;
    }

    .admin-dashboard .chart-total {
        margin-top: 2px;
        padding: 12px 14px;
        border: 1px solid #eff1f5;
        border-radius: 9px;
        background: #fafbfc;
    }

    .admin-dashboard .chart-total-label {
        display: block;
        margin-bottom: 4px;
        color: #8992a1;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .admin-dashboard .chart-total-value {
        color: #455168;
        font-size: 15px;
        font-weight: 700;
    }

    .admin-dashboard .chart-total.debit .chart-total-value {
        color: #54836a;
    }

    .admin-dashboard .chart-total.credit .chart-total-value {
        color: #aa6c70;
    }

    .admin-dashboard .activity-table,
    .admin-dashboard .flow-table {
        margin-bottom: 0;
    }

    .admin-dashboard .activity-table thead th,
    .admin-dashboard .flow-table thead th {
        padding-top: 12px;
        padding-bottom: 12px;
        background: #fafbfc;
    }

    .admin-dashboard .activity-table tbody td,
    .admin-dashboard .flow-table tbody td {
        padding-top: 13px;
        padding-bottom: 13px;
    }

    .admin-dashboard .activity-person {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .admin-dashboard .activity-person:last-child {
        margin-bottom: 0;
    }

    .admin-dashboard .activity-initial {
        display: inline-flex;
        flex: 0 0 36px;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin-right: 11px;
        border-radius: 50%;
        color: #687ba8;
        background: #eef1f8;
        font-size: 13px;
        font-weight: 700;
    }

    .admin-dashboard .activity-person-name {
        margin-bottom: 2px;
        color: #4b566b;
        font-size: 12px;
        font-weight: 600;
    }

    .admin-dashboard .activity-person-description {
        margin-bottom: 0;
        color: #8992a1;
        font-size: 11px;
    }

    .admin-dashboard .activity-person-time {
        margin-left: auto;
        padding-left: 10px;
        color: #9aa2af;
        font-size: 11px;
        white-space: nowrap;
    }

    .admin-dashboard .badge-light {
        border: 1px solid #e8ebf1;
        border-radius: 14px;
        color: #7b8494;
        background: #f7f8fb;
        font-size: 10px;
        font-weight: 600;
    }

    .admin-dashboard .text-success {
        color: #54836a !important;
    }

    .admin-dashboard .text-danger {
        color: #aa6c70 !important;
    }

    @media (max-width: 767.98px) {
        .admin-dashboard .dashboard-heading,
        .admin-dashboard .dashboard-panel,
        .admin-dashboard .dashboard-card {
            padding: 18px;
        }

        .admin-dashboard .dashboard-heading:after {
            right: -120px;
        }

        .admin-dashboard .dashboard-heading .float-left,
        .admin-dashboard .dashboard-heading .float-right {
            float: none !important;
        }

        .admin-dashboard .dashboard-heading .float-right {
            margin-top: 14px;
        }

        .admin-dashboard .dashboard-chart {
            height: 260px;
        }

        .admin-dashboard .activity-person-time {
            font-size: 10px;
        }
    }
</style>
@endsection
@section('content')
<div class="admin-dashboard">
<div class="row">
    <div class="col-12">
        <div class="page-title-box dashboard-heading mb-4">
            <div class="float-left">
                <h4 class="page-title">Dashboard Administrator</h4>
                <small class="dashboard-subtitle">Ringkasan koperasi dan aktivitas transaksi</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Kopkar</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <span class="period-caption">
                    <i class="mdi mdi-calendar-blank mr-1"></i>
                    {{ $periode->name }} &middot; {{ date('d-m-Y', strtotime($periode->open_date)) }} - {{ date('d-m-Y', strtotime($periode->close_date)) }}
                </span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="dashboard-section-title">Simpanan · Periode Aktif</div>
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card credit-card">
            <span class="dashboard-card-icon debit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Saldo Pokok</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($sum_pokok) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card">
            <span class="dashboard-card-icon debit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Saldo Wajib</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($sum_wajib) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card">
            <span class="dashboard-card-icon debit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Saldo Sukarela</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($sum_sukarela) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card">
            <span class="dashboard-card-icon credit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Kredit Simpanan</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($kredit_simpanan) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6">
        <div class="dashboard-panel">
            <div class="dashboard-panel-heading">
                <div>
                    <h5>Tren Debet dan Kredit</h5>
                    <p>Pergerakan transaksi per bulan pada periode aktif: {{ $periode->name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-2">
                    <div class="chart-total credit">
                        <span class="chart-total-label"><i class="mdi mdi-arrow-down mr-1"></i>Total Kredit</span>
                        <span class="chart-total-value">{{ Money::stringToRupiah($saldo_kredit) }}</span>
                    </div>
                </div>
                <div class="col-sm-6 mb-2">
                    <div class="chart-total debit">
                        <span class="chart-total-label"><i class="mdi mdi-arrow-up mr-1"></i>Total Debet</span>
                        <span class="chart-total-value">{{ Money::stringToRupiah($saldo_debit) }}</span>
                    </div>
                </div>
            </div>
            <div class="dashboard-chart"><canvas id="chartPeriode"></canvas></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="dashboard-panel">
            <div class="dashboard-panel-heading">
                <div>
                    <h5>Status Anggota</h5>
                    <p>Perbandingan anggota aktif dan nonaktif</p>
                </div>
            </div>
            <div class="dashboard-chart"><canvas id="chartAnggota"></canvas></div>
        </div>
    </div>
</div>
<!-- end row -->
<!-- end row -->
<div class="dashboard-section-title">Pinjaman · Periode Aktif</div>
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card credit-card">
            <span class="dashboard-card-icon credit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Kredit Pinjaman</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($kredit_pinjaman) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card">
            <span class="dashboard-card-icon debit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Debet Bunga</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($bunga_pinjaman) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card">
            <span class="dashboard-card-icon debit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Debet Pinjaman</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($debet_pinjaman) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
</div>
<div class="dashboard-section-title">Ringkasan Keseluruhan</div>
<div class="row mb-4">
    <div class="col-12">
        <div class="dashboard-panel">
            <div class="dashboard-panel-heading">
                <div>
                    <h5>Ringkasan Transaksi Keseluruhan</h5>
                    <p>Akumulasi seluruh transaksi dari semua periode dan anggota</p>
                </div>
                <span class="badge badge-light">Semua Periode</span>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
                    <div class="dashboard-card credit-card">
                        <span class="dashboard-card-icon debit"><i class="dripicons-arrow-up"></i></span>
                        <h6 class="dashboard-card-label">Arus Debet</h6>
                        <div class="dashboard-card-value">{{ Money::stringToRupiah($total_debet_semua) }}</div>
                        <p class="dashboard-card-note">{{ number_format($jumlah_debet_semua) }} transaksi</p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
                    <div class="dashboard-card credit-card">
                        <span class="dashboard-card-icon credit"><i class="dripicons-arrow-down"></i></span>
                        <h6 class="dashboard-card-label">Arus Kredit</h6>
                        <div class="dashboard-card-value">{{ Money::stringToRupiah($total_kredit_semua) }}</div>
                        <p class="dashboard-card-note">{{ number_format($jumlah_kredit_semua) }} transaksi</p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="dashboard-card">
                        <span class="dashboard-card-icon debit"><i class="fi-users"></i></span>
                        <h6 class="dashboard-card-label">Jumlah Anggota</h6>
                        <div class="dashboard-card-value">{{ number_format($countAnggota) }}</div>
                        <p class="dashboard-card-note">{{ number_format($countDivisi) }} divisi terdaftar</p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="dashboard-card">
                        <span class="dashboard-card-icon credit"><i class="fi-layers"></i></span>
                        <h6 class="dashboard-card-label">Selisih Debet - Kredit</h6>
                        <div class="dashboard-card-value">{{ Money::stringToRupiah($total_debet_semua - $total_kredit_semua) }}</div>
                        <p class="dashboard-card-note">Selisih pencatatan seluruh periode</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
        <div class="dashboard-panel">
            <div class="dashboard-panel-heading">
                <div>
                    <h5>Alur Pencatatan Debet dan Kredit</h5>
                    <p>Rincian nominal dan jumlah transaksi menurut divisi serta akun biaya, seluruh periode</p>
                </div>
                <span class="badge badge-light">Semua Periode</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover flow-table mb-0">
                    <thead>
                        <tr>
                            <th>Arah Transaksi</th>
                            <th>Divisi</th>
                            <th>Akun Pencatatan</th>
                            <th class="text-right">Jumlah Transaksi</th>
                            <th class="text-right">Total Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arus_transaksi as $arus)
                        <tr>
                            <td>
                                <span class="activity-badge {{ (int) $arus->jenis_transaksi === 1 ? 'debit' : 'credit' }}">
                                    {{ (int) $arus->jenis_transaksi === 1 ? 'Debet' : 'Kredit' }}
                                </span>
                            </td>
                            <td>{{ $arus->nama_divisi }}</td>
                            <td>{{ $arus->nama_biaya }}</td>
                            <td class="text-right">{{ number_format($arus->jumlah_transaksi) }}</td>
                            <td class="text-right font-weight-bold {{ (int) $arus->jenis_transaksi === 1 ? 'text-success' : 'text-danger' }}">
                                {{ Money::stringToRupiah($arus->total_nominal) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data transaksi Debet atau Kredit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-muted small">
                Nilai mengikuti jenis transaksi yang tercatat di sistem. Debet dan Kredit ditampilkan terpisah, bukan sebagai saldo kas bersih.
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="dashboard-panel">
            <div class="dashboard-panel-heading">
                <div>
                    <h5>Aktivitas Pengguna</h5>
                    <p>Aktivitas terbaru di aplikasi</p>
                </div>
            </div>

            <div class="inbox-widget slimscroll" style="max-height: 370px;">
                @forelse ($activity_log as $item)
                    <a href="javascript:void(0);">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('images/users/avatar-1.jpg') }}" class="rounded-circle bx-shadow-lg" alt=""></div>
                            <p class="inbox-item-author">{{ optional($item->user)->name ?? 'Pengguna sistem' }}</p>
                            <p class="inbox-item-text">{{ $item->description}}</p>
                            <p class="inbox-item-date">{{ Carbon\Carbon::parse($item->created_at)->format('g:i A') }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-muted mb-0">Belum ada aktivitas pengguna.</p>
                @endforelse
            </div>

        </div>
    </div>
    <div class="col-lg-6">
        <div class="dashboard-panel">
            <div class="dashboard-panel-heading">
                <div>
                    <h5>Aktivitas Transaksi Terbaru</h5>
                    <p>Debet dan kredit dari seluruh anggota dan periode</p>
                </div>
                <span class="badge badge-light">15 terakhir</span>
            </div>
            <div class="table-responsive">
            <table class="table table-hover activity-table mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Divisi</th>
                        <th>Anggota</th>
                        <th>Keterangan</th>
                        <th class="text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($transaksi_harian as $item)
                    @if ($item->jenis_transaksi == '1')
                    <tr>
                        <td class="text-nowrap">{{ Tanggal::tanggal_id($item->tgl) }}</td>
                        <td><span class="activity-badge debit">Debet</span></td>
                        <td>{{ optional($item->divisi)->name ?? '-' }}</td>
                        <td>{{ optional(optional($item->nama_anggota)->anggota)->nama ?? '-' }}</td>
                        <td>{{ $item->keterangan ?: '-' }}</td>
                        <td class="text-right text-success font-weight-bold">+{{ Money::stringToRupiah($item->sumDebitAll->sum('nominal')) }}</td>
                    </tr>
                    @else
                    <tr>
                        <td class="text-nowrap">{{ Tanggal::tanggal_id($item->tgl) }}</td>
                        <td><span class="activity-badge credit">Kredit</span></td>
                        <td>{{ optional($item->divisi)->name ?? '-' }}</td>
                        <td>{{ optional(optional($item->nama_anggota)->anggota)->nama ?? '-' }}</td>
                        <td>{{ $item->keterangan ?: '-' }}</td>
                        <td class="text-right text-danger font-weight-bold">-{{ Money::stringToRupiah($item->sumKreditAll->sum('nominal')) }}</td>
                    </tr>
                    @endif
                @endforeach
                @if($transaksi_harian->isEmpty())
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada aktivitas transaksi.</td></tr>
                @endif
                </tbody>
            </table>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
@section('script')
<!-- Chart JS -->
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
    var ctx = document.getElementById('chartAnggota').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Non Aktif'],
            datasets: [{
                label: '# of Votes',
                data: {{ json_encode($status_anggota) }},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        }
    });

    var data = {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: "Debit",
                    backgroundColor: "blue",
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    data: {!! json_encode($debitAll) !!}
                },
                {
                    label: "Kredit",
                    backgroundColor: "red",
                    data: {!! json_encode($kreditAll) !!}
                }
            ]
    };

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    userCallback: function(value, index, values) {
                        // Convert the number to a string and splite the string every 3 charaters from the end
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);

                        // Convert the array to a string and format the output
                        value = value.join('.');
                        return 'Rp ' + value;
                    }
                }
            }] 
        }
    };

    var ctz = document.getElementById("chartPeriode").getContext("2d");
    var chartAnggota = new Chart(ctz, {
        type: 'bar',
        data: data,
        options: options
    });
</script>
@endsection
