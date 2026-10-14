@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Detail Pengajuan Pinjaman Kredit</h4>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <table class="table">
                <tr><th>Anggota</th><td>{{ $pengajuanPinjaman->anggota->nama }}</td></tr>
                <tr><th>Nominal</th><td>{{ Money::stringToRupiah($pengajuanPinjaman->nominal) }}</td></tr>
                <tr><th>Lama Cicilan</th><td>{{ $pengajuanPinjaman->lama_cicilan }} bulan</td></tr>
                <tr><th>Keterangan</th><td>{{ $pengajuanPinjaman->keterangan ?: '-' }}</td></tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @switch($pengajuanPinjaman->status)
                            @case('menunggu_admin') Menunggu persetujuan Admin @break
                            @case('menunggu_bendahara') Menunggu persetujuan Bendahara @break
                            @case('menunggu_ketua') Menunggu persetujuan Ketua @break
                            @case('disetujui') Disetujui dan dicairkan @break
                            @case('ditolak') Ditolak @break
                        @endswitch
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <h5>Riwayat Persetujuan</h5>
            @php
                $rejectedRole = $pengajuanPinjaman->ketua_user_id
                    ? 'Ketua'
                    : ($pengajuanPinjaman->bendahara_user_id ? 'Bendahara' : ($pengajuanPinjaman->admin_user_id ? 'Admin' : null));
            @endphp
            <ol>
                @foreach ([
                    ['Admin', $pengajuanPinjaman->adminApprover, $pengajuanPinjaman->admin_diproses_pada, $pengajuanPinjaman->admin_catatan],
                    ['Bendahara', $pengajuanPinjaman->bendaharaApprover, $pengajuanPinjaman->bendahara_diproses_pada, $pengajuanPinjaman->bendahara_catatan],
                    ['Ketua', $pengajuanPinjaman->ketuaApprover, $pengajuanPinjaman->ketua_diproses_pada, $pengajuanPinjaman->ketua_catatan],
                ] as [$roleName, $reviewer, $processedAt, $note])
                    <li>
                        {{ $roleName }}:
                        @if ($reviewer)
                            {{ $pengajuanPinjaman->status === 'ditolak' && $rejectedRole === $roleName ? 'Menolak' : 'Menyetujui' }}
                            oleh {{ $reviewer->name }} ({{ $processedAt->format('d-m-Y H:i') }}) — {{ $note ?: 'Disetujui' }}
                        @else
                            Menunggu
                        @endif
                    </li>
                @endforeach
            </ol>
            @if ($pengajuanPinjaman->status === 'disetujui' && $pengajuanPinjaman->transaksi_harian_id)
                <p>Nomor transaksi pinjaman: {{ $pengajuanPinjaman->transaksi_harian_id }}</p>
            @endif
        </div>
    </div>
</div>

@if ($canApprove)
<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <h5>Keputusan {{ $stage['role'] }}</h5>
            <form method="POST" action="{{ route('pengajuan-pinjaman.decide', $pengajuanPinjaman->id) }}">
                @csrf
                @if ($pengajuanPinjaman->status === 'menunggu_ketua')
                    <div class="form-group">
                        <label for="tgl_pencairan">Tanggal Pencairan</label>
                        <input id="tgl_pencairan" type="text" name="tgl_pencairan" value="{{ old('tgl_pencairan') }}" placeholder="dd-mm-yyyy" class="form-control @error('tgl_pencairan') is-invalid @enderror" required>
                        @error('tgl_pencairan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                        <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control @error('jenis_pembayaran') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Pembayaran</option>
                            <option value="1" {{ old('jenis_pembayaran') === '1' ? 'selected' : '' }}>Cash</option>
                            <option value="2" {{ old('jenis_pembayaran') === '2' ? 'selected' : '' }}>Bank</option>
                        </select>
                        @error('jenis_pembayaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                @endif
                <div class="form-group">
                    <label for="catatan">Catatan keputusan</label>
                    <textarea id="catatan" name="catatan" maxlength="2000" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    <small class="form-text text-muted">Wajib diisi jika pengajuan ditolak.</small>
                </div>
                <button type="submit" name="decision" value="approve" class="btn btn-success">Setujui</button>
                <button type="submit" name="decision" value="reject" formnovalidate class="btn btn-danger">Tolak</button>
            </form>
        </div>
    </div>
</div>
@endif

<a href="{{ route('pengajuan-pinjaman.index') }}" class="btn btn-secondary mb-3">Kembali</a>
@endsection
