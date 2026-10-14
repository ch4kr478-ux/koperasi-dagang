@extends('layouts.master')
@section('style')
<style>
    .admin-dashboard .dashboard-heading {
        padding: 22px 26px;
        border-radius: 8px;
        color: #fff;
        background: linear-gradient(120deg, #263b80, #4263eb);
        box-shadow: 0 8px 24px rgba(38, 59, 128, .14);
    }

    .admin-dashboard .dashboard-heading h4,
    .admin-dashboard .dashboard-heading .breadcrumb-item,
    .admin-dashboard .dashboard-heading .breadcrumb-item a {
        color: #fff;
    }

    .admin-dashboard .dashboard-heading .breadcrumb {
        background: transparent;
        margin-bottom: 4px;
        padding: 0;
    }

    .admin-dashboard .dashboard-subtitle {
        color: rgba(255, 255, 255, .78);
    }

    .admin-dashboard .dashboard-card,
    .admin-dashboard .dashboard-panel {
        height: 100%;
        border: 1px solid #edf0f5;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(28, 39, 60, .04);
    }

    .admin-dashboard .dashboard-card {
        position: relative;
        overflow: hidden;
        padding: 22px;
        background: #fff;
    }

    .admin-dashboard .dashboard-card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        margin-bottom: 16px;
        border-radius: 10px;
        font-size: 20px;
    }

    .admin-dashboard .dashboard-card-icon.debit {
        color: #2f9e44;
        background: #ebfbee;
    }

    .admin-dashboard .dashboard-card-icon.credit {
        color: #e03131;
        background: #fff5f5;
    }

    .admin-dashboard .dashboard-card-label {
        margin-bottom: 7px;
        color: #868e96;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .admin-dashboard .dashboard-card-value {
        margin-bottom: 4px;
        color: #343a40;
        font-size: 21px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .admin-dashboard .dashboard-card-note {
        margin: 0;
        color: #868e96;
        font-size: 12px;
    }

    .admin-dashboard .dashboard-panel {
        padding: 22px;
        background: #fff;
    }

    .admin-dashboard .dashboard-panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .admin-dashboard .dashboard-panel-heading h5 {
        margin-bottom: 4px;
        color: #343a40;
        font-size: 16px;
        font-weight: 700;
    }

    .admin-dashboard .dashboard-panel-heading p {
        margin: 0;
        color: #868e96;
        font-size: 12px;
    }

    .admin-dashboard .activity-table th {
        border-top: 0;
        color: #868e96;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-dashboard .activity-table td {
        vertical-align: middle;
        color: #495057;
    }

    .admin-dashboard .flow-table th {
        border-top: 0;
        color: #868e96;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-dashboard .flow-table td {
        vertical-align: middle;
    }

    .admin-dashboard .activity-badge {
        display: inline-block;
        min-width: 66px;
        padding: 5px 9px;
        border-radius: 20px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
    }

    .admin-dashboard .activity-badge.debit {
        color: #2b8a3e;
        background: #ebfbee;
    }

    .admin-dashboard .activity-badge.credit {
        color: #c92a2a;
        background: #fff5f5;
    }

    .admin-dashboard .dashboard-chart {
        height: 320px;
    }

    @media (max-width: 767.98px) {
        .admin-dashboard .dashboard-heading,
        .admin-dashboard .dashboard-panel,
        .admin-dashboard .dashboard-card {
            padding: 18px;
        }

        .admin-dashboard .dashboard-chart {
            height: 260px;
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
                <h4 class="page-title">Dashboard Admin</h4>
                <small class="dashboard-subtitle">Ringkasan koperasi dan aktivitas transaksi</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Kopkar</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <small class="dashboard-subtitle">{{ $periode->name }} &middot; {{ date('d-m-Y', strtotime($periode->open_date)) }} - {{ date('d-m-Y', strtotime($periode->close_date)) }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
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
                <div class="col-sm-6">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Total Kredit</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-down-bold-hexagon-outline text-danger"></i> <span class="text-dark">{{ Money::stringToRupiah($saldo_kredit) }}</span> </h6>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Total Debit</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> <span class="text-dark">{{ Money::stringToRupiah($saldo_debit) }}</span> </h6>
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
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="dashboard-card">
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
                    <div class="dashboard-card">
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
