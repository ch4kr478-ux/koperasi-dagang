<div class="form-group">
    <label for="name">Nama Produk *</label>
    <input type="text" id="name" name="name" class="form-control" required maxlength="255"
        value="{{ old('name', data_get($produkPinjaman ?? null, 'name')) }}">
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="nominal">Jumlah Pinjaman *</label>
    <input type="number" id="nominal" name="nominal" class="form-control" required min="1" step="1"
        value="{{ old('nominal', data_get($produkPinjaman ?? null, 'nominal')) }}">
    <small class="form-text text-muted">Nominal ini menjadi jumlah tetap untuk setiap transaksi yang memakai produk ini.</small>
    @error('nominal') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="description">Keterangan</label>
    <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', data_get($produkPinjaman ?? null, 'description')) }}</textarea>
</div>

<div class="form-group">
    <label for="tenors">Pilihan tenor (bulan) *</label>
    <input type="text" id="tenors" name="tenor_list" class="form-control" required
        placeholder="Masukkan tenor bulan, pisahkan dengan koma, contoh: 6, 12, 24"
        value="{{ old('tenor_list', isset($produkPinjaman) ? $produkPinjaman->tenors->pluck('lama_cicilan')->implode(', ') : '') }}">
    <small class="form-text text-muted">Isikan satu atau lebih tenor dalam bulan, angka bulat positif dan tidak boleh berulang.</small>
    @error('tenors') <small class="text-danger d-block">{{ $message }}</small> @enderror
    @error('tenors.0') <small class="text-danger d-block">{{ $message }}</small> @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1"
        @checked((string) old('is_active', data_get($produkPinjaman ?? null, 'is_active', true)) === '1')>
    <label class="form-check-label" for="is_active">Aktif dan dapat dipilih pada transaksi</label>
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('produk-pinjaman.index') }}" class="btn btn-secondary">Batal</a>
