@extends('layouts.master')
@section('style')
<style>
    .member-dashboard {
        padding-bottom: 24px;
        color: #465166;
    }

    .member-dashboard .member-welcome {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        margin-bottom: 24px;
        padding: 26px 30px;
        border: 1px solid #e5eaf3;
        border-radius: 14px;
        background: linear-gradient(115deg, #fff 0%, #f5f7fc 68%, #edf2f8 100%);
        box-shadow: 0 8px 24px rgba(35, 47, 74, .05);
    }

    .member-dashboard .member-welcome:after {
        position: absolute;
        top: -90px;
        right: 12%;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(106, 127, 177, .1);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(106, 127, 177, .03), 0 0 0 50px rgba(106, 127, 177, .02);
        content: "";
        pointer-events: none;
    }

    .member-dashboard .welcome-content,
    .member-dashboard .welcome-period {
        position: relative;
        z-index: 1;
    }

    .member-dashboard .welcome-eyebrow {
        margin-bottom: 7px;
        color: #7f8ba0;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .member-dashboard .member-welcome h4 {
        margin-bottom: 5px;
        color: #344054;
        font-size: 22px;
        font-weight: 700;
    }

    .member-dashboard .welcome-description {
        margin: 0;
        color: #7d8798;
        font-size: 13px;
    }

    .member-dashboard .welcome-period {
        padding: 8px 13px;
        border: 1px solid #e5e9f1;
        border-radius: 20px;
        color: #68748a;
        background: rgba(255, 255, 255, .78);
        font-size: 11px;
        white-space: nowrap;
    }

    .member-dashboard .member-identity,
    .member-dashboard .member-stat-card,
    .member-dashboard .member-activity-panel {
        height: calc(100% - 20px);
        margin-bottom: 20px;
        border: 1px solid #e9edf3;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 16px rgba(35, 47, 74, .04);
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .member-dashboard .member-identity:hover,
    .member-dashboard .member-stat-card:hover,
    .member-dashboard .member-activity-panel:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 22px rgba(35, 47, 74, .07);
    }

    .member-dashboard .member-identity {
        display: flex;
        align-items: center;
        min-height: 112px;
        padding: 20px 22px;
    }

    .member-dashboard .member-avatar {
        display: inline-flex;
        flex: 0 0 54px;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        margin-right: 16px;
        border: 1px solid #e5eaf3;
        border-radius: 16px;
        color: #687ba8;
        background: #f0f3f9;
        font-size: 20px;
        font-weight: 700;
    }

    .member-dashboard .member-identity-name {
        margin: 0 0 4px;
        color: #3c475b;
        font-size: 15px;
        font-weight: 700;
    }

    .member-dashboard .member-identity-meta {
        margin: 0;
        color: #8992a1;
        font-size: 12px;
    }

    .member-dashboard .member-status {
        margin-left: auto;
        padding: 5px 10px;
        border-radius: 16px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .member-dashboard .member-status.active {
        color: #54836a;
        background: #edf5f0;
    }

    .member-dashboard .member-status.inactive {
        color: #aa6c70;
        background: #f9eff0;
    }

    .member-dashboard .member-stat-card {
        position: relative;
        overflow: hidden;
        min-height: 164px;
        padding: 20px;
    }

    .member-dashboard .member-stat-card:before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #a7b5d4, #e5eaf4);
        content: "";
    }

    .member-dashboard .member-stat-card.credit:before {
        background: linear-gradient(90deg, #d5b2b6, #f1e5e7);
    }

    .member-dashboard .member-stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 37px;
        height: 37px;
        margin-bottom: 12px;
        border-radius: 12px;
        color: #54836a;
        background: #edf5f0;
        font-size: 17px;
    }

    .member-dashboard .member-stat-card.credit .member-stat-icon {
        color: #aa6c70;
        background: #f9eff0;
    }

    .member-dashboard .member-stat-label {
        margin-bottom: 6px;
        color: #7b8494;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .member-dashboard .member-stat-value {
        margin: 0;
        color: #344054;
        font-size: 18px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .member-dashboard .member-section-title {
        display: flex;
        align-items: center;
        margin: 7px 0 15px;
        color: #667085;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .member-dashboard .member-section-title:after {
        flex: 1;
        height: 1px;
        margin-left: 12px;
        background: #e9edf3;
        content: "";
    }

    .member-dashboard .member-activity-panel {
        overflow: hidden;
    }

    .member-dashboard .activity-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 22px 15px;
        border-bottom: 1px solid #f0f2f6;
    }

    .member-dashboard .activity-heading h5 {
        margin: 0 0 4px;
        color: #394458;
        font-size: 15px;
        font-weight: 700;
    }

    .member-dashboard .activity-heading p {
        margin: 0;
        color: #8a93a2;
        font-size: 12px;
    }

    .member-dashboard .member-activity-table {
        margin: 0;
    }

    .member-dashboard .member-activity-table th {
        padding: 12px 16px;
        border-top: 0;
        color: #858e9d;
        background: #fafbfc;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .member-dashboard .member-activity-table td {
        padding: 13px 16px;
        vertical-align: middle;
        color: #596477;
        font-size: 12px;
    }

    .member-dashboard .member-activity-table tbody tr:hover {
        background: #f8f9fc;
    }

    .member-dashboard .activity-category {
        color: #465166;
        font-weight: 600;
    }

    .member-dashboard .activity-direction {
        display: inline-block;
        min-width: 58px;
        padding: 4px 8px;
        border-radius: 14px;
        text-align: center;
        font-size: 10px;
        font-weight: 700;
    }

    .member-dashboard .activity-direction.debit {
        color: #54836a;
        background: #edf5f0;
    }

    .member-dashboard .activity-direction.credit {
        color: #aa6c70;
        background: #f9eff0;
    }

    .member-dashboard .member-empty-state {
        padding: 44px 20px;
        text-align: center;
    }

    .member-dashboard .member-empty-state i {
        display: block;
        margin-bottom: 10px;
        color: #aab3c2;
        font-size: 30px;
    }

    .member-dashboard .member-empty-state h5 {
        margin-bottom: 6px;
        color: #4b566b;
        font-size: 14px;
        font-weight: 700;
    }

    .member-dashboard .member-empty-state p {
        margin: 0;
        color: #8992a1;
        font-size: 12px;
    }

    @media (max-width: 767.98px) {
        .member-dashboard .member-welcome {
            align-items: flex-start;
            flex-direction: column;
            padding: 21px;
        }

        .member-dashboard .welcome-period {
            margin-top: 15px;
        }

        .member-dashboard .member-status {
            margin-left: 10px;
        }

        .member-dashboard .member-activity-table th,
        .member-dashboard .member-activity-table td {
            padding-right: 10px;
            padding-left: 10px;
        }
    }
</style>
@endsection
@section('content')
<div class="member-dashboard">
    <div class="member-welcome">
        <div class="welcome-content">
            <div class="welcome-eyebrow">Dashboard Member</div>
            <h4>Selamat datang, {{ $anggota ? $anggota->nama : Auth::user()->name }}</h4>
            <p class="welcome-description">Pantau ringkasan simpanan, pinjaman, dan aktivitas transaksi Anda.</p>
        </div>
        <div class="welcome-period">
            <i class="mdi mdi-calendar-blank-outline mr-1" aria-hidden="true"></i>
            {{ $periode ? 'Periode ' . $periode->name : 'Akumulasi seluruh periode' }}
        </div>
    </div>

    @if($anggota)
        <div class="member-identity">
            <div class="member-avatar" aria-hidden="true">{{ strtoupper(substr($anggota->nama ?: 'M', 0, 1)) }}</div>
            <div>
                <h5 class="member-identity-name">{{ $anggota->nama }}</h5>
                <p class="member-identity-meta">
                    NIK {{ $anggota->nik }}
                    @if($anggota->jabatan)
                        <span class="mx-1">·</span>{{ $anggota->jabatan }}
                    @endif
                </p>
            </div>
            <span class="member-status {{ (string) $anggota->status === '1' ? 'active' : 'inactive' }}">
                {{ (string) $anggota->status === '1' ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div class="member-section-title">Ringkasan Keuangan</div>
        <div class="row">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="member-stat-card">
                    <span class="member-stat-icon"><i class="mdi mdi-piggy-bank-outline" aria-hidden="true"></i></span>
                    <div class="member-stat-label">Setoran Simpanan</div>
                    <p class="member-stat-value">{{ Money::stringToRupiah($totalSetoranSimpanan) }}</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="member-stat-card credit">
                    <span class="member-stat-icon"><i class="mdi mdi-cash-minus" aria-hidden="true"></i></span>
                    <div class="member-stat-label">Penarikan Simpanan</div>
                    <p class="member-stat-value">{{ Money::stringToRupiah($totalPenarikanSimpanan) }}</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="member-stat-card">
                    <span class="member-stat-icon"><i class="mdi mdi-hand-coin-outline" aria-hidden="true"></i></span>
                    <div class="member-stat-label">Pinjaman Diterima</div>
                    <p class="member-stat-value">{{ Money::stringToRupiah($totalPinjamanDiterima) }}</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="member-stat-card credit">
                    <span class="member-stat-icon"><i class="mdi mdi-cash-check" aria-hidden="true"></i></span>
                    <div class="member-stat-label">Pembayaran Pinjaman</div>
                    <p class="member-stat-value">{{ Money::stringToRupiah($totalPembayaranPinjaman) }}</p>
                </div>
            </div>
        </div>

        <div class="member-section-title">Aktivitas Transaksi</div>
        <div class="member-activity-panel">
            <div class="activity-heading">
                <div>
                    <h5>Transaksi Terbaru</h5>
                    <p>Riwayat transaksi yang tercatat atas nama Anda</p>
                </div>
                <i class="mdi mdi-history text-muted" aria-hidden="true"></i>
            </div>
            @if($memberActivity->isNotEmpty())
                <div class="table-responsive">
                    <table class="table member-activity-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Rincian</th>
                                <th>Keterangan</th>
                                <th class="text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($memberActivity as $activity)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($activity->tgl)->format('d M Y') }}</td>
                                    <td>
                                        <span class="activity-direction {{ (int) $activity->jenis_transaksi === 1 ? 'debit' : 'credit' }}">
                                            {{ (int) $activity->jenis_transaksi === 1 ? 'Debet' : 'Kredit' }}
                                        </span>
                                        <span class="text-muted ml-1">{{ $activity->nama_divisi ?: '-' }}</span>
                                    </td>
                                    <td class="activity-category">{{ $activity->nama_biaya ?: '-' }}</td>
                                    <td>{{ $activity->keterangan ?: '-' }}</td>
                                    <td class="text-right font-weight-bold">{{ Money::stringToRupiah($activity->nominal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="member-empty-state">
                    <i class="mdi mdi-text-box-search-outline" aria-hidden="true"></i>
                    <h5>Belum ada transaksi</h5>
                    <p>Transaksi simpanan atau pinjaman Anda akan muncul di sini.</p>
                </div>
            @endif
        </div>
    @else
        <div class="member-activity-panel">
            <div class="member-empty-state">
                <i class="mdi mdi-account-alert-outline" aria-hidden="true"></i>
                <h5>Data anggota belum terhubung</h5>
                <p>Hubungi administrator agar akun Anda dapat ditautkan ke data anggota koperasi.</p>
            </div>
        </div>
    @endif
</div>
@endsection
