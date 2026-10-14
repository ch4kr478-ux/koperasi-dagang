<div class="form-group">
    <label for="produk_pinjaman_id">Produk Pinjaman *</label>
    <select id="produk_pinjaman_id" name="produk_pinjaman_id" class="form-control" required>
        <option value="">Pilih produk</option>
        @foreach($produkPinjaman as $product)
            <option value="{{ $product->id }}"
                data-tenors="{{ $product->tenors->pluck('lama_cicilan')->implode(',') }}"
                data-nominal="{{ $product->nominal }}"
                @selected((string) old('produk_pinjaman_id', data_get($formModel ?? null, 'produk_pinjaman_id')) === (string) $product->id)>
                {{ $product->name }}{{ $product->nominal ? ' - Rp. ' . number_format($product->nominal, 0, ',', '.') : ' (Nominal belum diatur)' }}{{ $product->is_active ? '' : ' (Nonaktif)' }}
            </option>
        @endforeach
    </select>
    @error('produk_pinjaman_id') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="lama_cicilan">Tenor *</label>
    <select id="lama_cicilan" name="lama_cicilan" class="form-control" required
        data-selected="{{ old('lama_cicilan', data_get($formModel ?? null, 'lama_cicilan')) }}">
        <option value="">Pilih tenor</option>
    </select>
    @error('lama_cicilan') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="nominal_pinjaman_kredit">Jumlah Pinjaman *</label>
    <input type="text" id="nominal_pinjaman_kredit" name="nominal"
        value="{{ old('nominal', data_get($formModel ?? null, 'nominal')) }}"
        class="form-control biaya" autocomplete="off" required readonly>
    <small class="form-text text-muted">Jumlah pinjaman ditentukan oleh produk yang dipilih.</small>
    @error('nominal') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="card border border-info mt-3">
    <div class="card-body">
        <h5 class="card-title">Perkiraan Angsuran per Bulan</h5>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <tbody>
                    <tr><th>Angsuran Pokok</th><td class="text-right" id="preview-pokok">-</td></tr>
                    <tr><th>Bunga (1% flat)</th><td class="text-right" id="preview-bunga">-</td></tr>
                    <tr><th>Tabungan (0,5%)</th><td class="text-right" id="preview-tabungan">-</td></tr>
                    <tr class="font-weight-bold"><th>Total per Bulan</th><td class="text-right text-primary" id="preview-total">-</td></tr>
                </tbody>
            </table>
        </div>
        <small class="text-muted">Bunga dan tabungan dihitung per bulan dari nominal awal pinjaman.</small>
    </div>
</div>
