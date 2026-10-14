@extends('layouts.master')
@section('style')
<style>
    .admin-dashboard {
        padding-bottom: 24px;
        color: var(--k-text-body);
    }

    .admin-dashboard .dashboard-heading {
        position: relative;
        overflow: hidden;
        padding: 26px 32px;
        border: 1px solid var(--k-border);
        border-left: 5px solid var(--k-primary);
        border-radius: var(--k-radius-lg);
        color: var(--k-text-main);
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 55%, #f0fdfa 100%);
        box-shadow: var(--k-shadow-sm);
    }

    .admin-dashboard .dashboard-heading:after {
        position: absolute;
        top: -80px;
        right: 12%;
        width: 240px;
        height: 240px;
        border: 1px solid rgba(15, 118, 110, 0.08);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(15, 118, 110, 0.02), 0 0 0 54px rgba(15, 118, 110, 0.015);
        content: "";
        pointer-events: none;
    }

    .admin-dashboard .dashboard-heading h4 {
        margin: 0 0 4px;
        font-size: 22px;
        font-weight: 800;
        color: var(--k-text-main);
        letter-spacing: -0.02em;
    }

    .admin-dashboard .dashboard-heading .float-left,
    .admin-dashboard .dashboard-heading .float-right {
        position: relative;
        z-index: 1;
    }

    .admin-dashboard .dashboard-heading .breadcrumb {
        background: transparent;
        margin-bottom: 6px;
        padding: 0;
        justify-content: flex-end;
    }

    .admin-dashboard .period-caption {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-full);
        color: var(--k-primary);
        background: rgba(255, 255, 255, 0.85);
        font-size: 11.5px;
        font-weight: 600;
        box-shadow: var(--k-shadow-xs);
    }

    .admin-dashboard .dashboard-subtitle {
        color: var(--k-text-muted);
        font-size: 13px;
    }

    .admin-dashboard .dashboard-card,
    .admin-dashboard .dashboard-panel {
        height: calc(100% - 22px);
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        box-shadow: var(--k-shadow-xs);
        transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease;
    }

    .admin-dashboard .dashboard-card:hover,
    .admin-dashboard .dashboard-panel:hover {
        transform: translateY(-2px);
        box-shadow: var(--k-shadow-md);
        border-color: #cbd5e1;
    }

    .admin-dashboard .dashboard-card {
        position: relative;
        overflow: hidden;
        min-height: 165px;
        padding: 22px;
        background: #ffffff;
    }

    .admin-dashboard .dashboard-card:before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 3.5px;
        background: var(--k-primary-gradient);
        content: "";
    }

    .admin-dashboard .dashboard-card.credit-card:before {
        background: linear-gradient(90deg, #ef4444 0%, #f43f5e 100%);
    }

    .admin-dashboard .dashboard-section-title {
        display: flex;
        align-items: center;
        margin: 6px 0 16px;
        color: var(--k-text-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .admin-dashboard .dashboard-section-title:after {
        flex: 1;
        height: 1px;
        margin-left: 14px;
        background: var(--k-border);
        content: "";
    }

    .admin-dashboard .dashboard-card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        margin-bottom: 14px;
        border-radius: var(--k-radius-md);
        font-size: 18px;
    }

    .admin-dashboard .dashboard-card-icon.debit {
        color: var(--k-primary);
        background: var(--k-primary-subtle);
        border: 1px solid var(--k-primary-border);
    }

    .admin-dashboard .dashboard-card-icon.credit {
        color: var(--k-danger);
        background: var(--k-danger-bg);
        border: 1px solid var(--k-danger-border);
    }

    .admin-dashboard .dashboard-card-label {
        margin-bottom: 6px;
        color: var(--k-text-muted);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .admin-dashboard .dashboard-card-value {
        margin-bottom: 4px;
        color: var(--k-text-main);
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.02em;
        overflow-wrap: anywhere;
    }

    .admin-dashboard .dashboard-card-note {
        margin: 0;
        color: var(--k-text-subtle);
        font-size: 11.5px;
        font-weight: 500;
    }

    .admin-dashboard .dashboard-panel {
        margin-bottom: 22px;
        padding: 24px;
        background: #ffffff;
    }

    .admin-dashboard .dashboard-panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--k-border-subtle);
    }

    .admin-dashboard .dashboard-panel-heading h5 {
        margin-bottom: 4px;
        color: var(--k-text-main);
        font-size: 15px;
        font-weight: 700;
    }

    .admin-dashboard .dashboard-panel-heading p {
        margin: 0;
        color: var(--k-text-muted);
        font-size: 12.5px;
    }

    .admin-dashboard .activity-table th {
        border-top: 0;
        color: var(--k-text-muted);
        background: var(--k-surface-alt);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
        padding: 12px 14px;
    }

    .admin-dashboard .activity-table td {
        vertical-align: middle;
        color: var(--k-text-body);
        font-size: 12.5px;
        padding: 12px 14px;
        border-bottom: 1px solid var(--k-border-subtle);
    }

    .admin-dashboard .activity-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .admin-dashboard .activity-badge {
        display: inline-block;
        min-width: 68px;
        padding: 4px 10px;
        border-radius: var(--k-radius-full);
        text-align: center;
        font-size: 11px;
        font-weight: 700;
    }

    .admin-dashboard .activity-badge.debit {
        color: var(--k-success-text);
        background: var(--k-success-bg);
        border: 1px solid var(--k-success-border);
    }

    .admin-dashboard .activity-badge.credit {
        color: var(--k-danger-text);
        background: var(--k-danger-bg);
        border: 1px solid var(--k-danger-border);
    }

    .admin-dashboard .dashboard-chart {
        height: 300px;
        padding: 8px 4px 0;
    }

    .admin-dashboard .chart-panels-row {
        margin-right: -12px;
        margin-left: -12px;
    }

    .admin-dashboard .chart-panels-row > [class*="col-"] {
        padding-right: 12px;
        padding-left: 12px;
    }

    .admin-dashboard .chart-panel {
        display: flex;
        flex-direction: column;
        height: calc(100% - 20px);
        min-height: 470px;
        padding: 24px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-lg);
        background: #ffffff;
        box-shadow: var(--k-shadow-xs);
    }

    .admin-dashboard .chart-panel:hover {
        transform: translateY(-2px);
        box-shadow: var(--k-shadow-md);
    }

    .admin-dashboard .chart-panel .dashboard-panel-heading {
        align-items: center;
        min-height: 58px;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }

    .admin-dashboard .chart-panel-title {
        display: flex;
        align-items: center;
    }

    .admin-dashboard .chart-heading-icon {
        display: inline-flex;
        flex: 0 0 40px;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin-right: 14px;
        border: 1px solid var(--k-primary-border);
        border-radius: var(--k-radius-md);
        color: var(--k-primary);
        background: var(--k-primary-subtle);
        font-size: 18px;
    }

    .admin-dashboard .chart-heading-icon.members {
        border-color: #bae6fd;
        color: var(--k-info);
        background: var(--k-info-bg);
    }

    .admin-dashboard .chart-panel .dashboard-chart {
        flex: 1;
        min-height: 300px;
        height: auto;
        padding: 10px 4px 0;
    }

    .admin-dashboard .chart-total {
        height: 100%;
        padding: 12px 16px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-md);
        background: var(--k-surface-alt);
    }

    .admin-dashboard .chart-total-label {
        display: block;
        margin-bottom: 4px;
        color: var(--k-text-muted);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .admin-dashboard .chart-total-value {
        color: var(--k-text-main);
        font-size: 16px;
        font-weight: 800;
    }

    .admin-dashboard .chart-total.debit .chart-total-value {
        color: var(--k-primary);
    }

    .admin-dashboard .chart-total.credit .chart-total-value {
        color: var(--k-danger);
    }

    .admin-dashboard .activity-table {
        margin-bottom: 0;
    }

    .admin-dashboard .badge-light {
        background: var(--k-surface-alt);
        color: var(--k-text-muted);
        border: 1px solid var(--k-border);
        font-weight: 600;
        padding: 4px 8px;
    }

    .admin-dashboard .text-success {
        color: var(--k-primary) !important;
    }

    .admin-dashboard .text-danger {
        color: var(--k-danger) !important;
    }

    @media (max-width: 767.98px) {
        .admin-dashboard .dashboard-heading {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .admin-dashboard .dashboard-heading .float-right {
            margin-top: 14px;
            align-self: flex-start;
        }

        .admin-dashboard .dashboard-heading .breadcrumb {
            justify-content: flex-start;
        }

        .admin-dashboard .chart-panel {
            min-height: 400px;
            padding: 16px;
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
        <div class="dashboard-card">
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
        <div class="dashboard-card credit-card">
            <span class="dashboard-card-icon credit"><i class="fi-layers"></i></span>
            <h6 class="dashboard-card-label">Kredit Simpanan</h6>
            <div class="dashboard-card-value">{{ Money::stringToRupiah($kredit_simpanan) }}</div>
            <p class="dashboard-card-note">Periode aktif</p>
        </div>
    </div>
</div>
<div class="dashboard-section-title">Analisis Keuangan dan Anggota</div>
<div class="row chart-panels-row">
    <div class="col-12 col-lg-6">
        <div class="dashboard-panel chart-panel">
            <div class="dashboard-panel-heading">
                <div class="chart-panel-title">
                    <span class="chart-heading-icon"><i class="mdi mdi-chart-bar"></i></span>
                    <div>
                        <h5>Tren Debet dan Kredit</h5>
                        <p>Pergerakan transaksi per bulan · {{ $periode->name }}</p>
                    </div>
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
    <div class="col-12 col-lg-6">
        <div class="dashboard-panel chart-panel">
            <div class="dashboard-panel-heading">
                <div class="chart-panel-title">
                    <span class="chart-heading-icon members"><i class="mdi mdi-account-group-outline"></i></span>
                    <div>
                        <h5>Status Anggota</h5>
                        <p>Perbandingan anggota aktif dan nonaktif</p>
                    </div>
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
                    <div class="dashboard-card">
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
<div class="row">
    <div class="col-12">
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
                    'rgba(116, 157, 132, 0.78)',
                    'rgba(196, 139, 145, 0.72)'
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 66,
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    fontColor: '#778196'
                }
            }
        }
    });

    var data = {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: "Debet",
                    backgroundColor: "rgba(116, 157, 132, 0.68)",
                    borderColor: "rgba(92, 135, 108, 0.9)",
                    borderWidth: 1,
                    data: {!! json_encode($debitAll) !!}
                },
                {
                    label: "Kredit",
                    backgroundColor: "rgba(196, 139, 145, 0.62)",
                    borderColor: "rgba(171, 111, 119, 0.9)",
                    borderWidth: 1,
                    data: {!! json_encode($kreditAll) !!}
                }
            ]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'bottom',
            labels: {
                usePointStyle: true,
                padding: 18,
                fontColor: '#778196'
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    fontColor: '#8992a1',
                    userCallback: function(value, index, values) {
                        // Convert the number to a string and splite the string every 3 charaters from the end
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);

                        // Convert the array to a string and format the output
                        value = value.join('.');
                        return 'Rp ' + value;
                    }
                },
                gridLines: {
                    color: 'rgba(115, 128, 153, 0.10)',
                    zeroLineColor: 'rgba(115, 128, 153, 0.16)'
                }
            }],
            xAxes: [{
                ticks: {
                    fontColor: '#8992a1'
                },
                gridLines: {
                    display: false
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
