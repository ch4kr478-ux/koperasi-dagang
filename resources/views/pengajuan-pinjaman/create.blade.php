@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Ajukan Pinjaman Kredit</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <p>Pengajuan harus disetujui Admin, Bendahara, lalu Ketua sebelum pinjaman dicairkan.</p>
            <form method="POST" action="{{ route('pengajuan-pinjaman.store') }}">
                @csrf
                <div class="form-group">
                    <label for="nominal">Nominal Pinjaman</label>
                    <input id="nominal" type="number" name="nominal" min="1" step="1" value="{{ old('nominal') }}" class="form-control @error('nominal') is-invalid @enderror" required>
                    @error('nominal')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="lama_cicilan">Lama Cicilan (bulan)</label>
                    <input id="lama_cicilan" type="number" name="lama_cicilan" min="1" step="1" value="{{ old('lama_cicilan') }}" class="form-control @error('lama_cicilan') is-invalid @enderror" required>
                    @error('lama_cicilan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" maxlength="2000" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                <a href="{{ route('pengajuan-pinjaman.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
