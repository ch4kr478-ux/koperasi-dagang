<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="produk_pinjaman_id">Pilih Produk Pinjaman <span class="text-danger">*</span></label>
            <select id="produk_pinjaman_id" name="produk_pinjaman_id" class="form-control required" required>
                <option value="">-- Pilih Paket Produk Pinjaman --</option>
                @foreach($produkPinjaman as $product)
                    <option value="{{ $product->id }}"
                        data-tenors="{{ $product->tenors->pluck('lama_cicilan')->implode(',') }}"
                        data-nominal="{{ $product->nominal }}"
                        @selected((string) old('produk_pinjaman_id', data_get($formModel ?? null, 'produk_pinjaman_id')) === (string) $product->id)>
                        {{ $product->name }}{{ $product->nominal ? ' — Rp ' . number_format($product->nominal, 0, ',', '.') : ' (Nominal Belum Diatur)' }}{{ $product->is_active ? '' : ' [Nonaktif]' }}
                    </option>
                @endforeach
            </select>
            @error('produk_pinjaman_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="control-label" for="lama_cicilan">Jangka Waktu / Tenor <span class="text-danger">*</span></label>
            <select id="lama_cicilan" name="lama_cicilan" class="form-control required" required
                data-selected="{{ old('lama_cicilan', data_get($formModel ?? null, 'lama_cicilan')) }}">
                <option value="">-- Pilih Tenor Cicilan --</option>
            </select>
            <small class="form-text text-muted">Pilihan tenor otomatis disesuaikan dengan konfigurasi produk yang dipilih.</small>
            @error('lama_cicilan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="control-label" for="nominal_pinjaman_kredit">Nominal Pinjaman Disetujui <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" id="nominal_pinjaman_kredit" name="nominal"
                    value="{{ old('nominal', data_get($formModel ?? null, 'nominal')) }}"
                    class="form-control biaya font-weight-bold" autocomplete="off" required readonly
                    placeholder="Nominal otomatis dari produk" style="font-size: 15px; color: var(--k-text-main);">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="mdi mdi-cash-multiple"></i></span>
                </div>
            </div>
            <small class="form-text text-muted">Jumlah pokok pinjaman ditentukan berdasarkan standar produk pinjaman koperasi.</small>
            @error('nominal') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Installment Summary Calculation Widget -->
        <div class="installment-summary-card">
            <div class="installment-summary-header">
                <h5 class="installment-summary-title">
                    <i class="mdi mdi-calculator text-teal"></i> Simulasi Angsuran Bulanan
                </h5>
                <span class="badge badge-soft-primary" style="font-size: 10px;">Estimasi Real-time</span>
            </div>

            <table class="installment-table w-100">
                <tbody>
                    <tr>
                        <th class="text-muted">Cicilan Pokok</th>
                        <td class="text-right font-weight-bold text-dark" id="preview-pokok">-</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Jasa Bunga (1% Flat)</th>
                        <td class="text-right font-weight-bold text-dark" id="preview-bunga">-</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Simpanan Wajib / Tabungan (0,5%)</th>
                        <td class="text-right font-weight-bold text-dark" id="preview-tabungan">-</td>
                    </tr>
                    <tr class="total-row">
                        <th class="font-weight-bold text-dark">Total Kewajiban per Bulan</th>
                        <td class="text-right total-value" id="preview-total">-</td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex align-items-center text-muted mt-2" style="font-size: 11.5px; gap: 6px;">
                <i class="mdi mdi-information-outline text-teal"></i>
                <span>Simulasi dihitung otomatis dari nominal pokok dan tenor cicilan yang dipilih.</span>
            </div>
        </div>
    </div>
</div>
