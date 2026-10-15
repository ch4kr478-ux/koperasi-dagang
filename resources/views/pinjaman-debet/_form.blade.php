<div>
    <h3>Informasi Anggota</h3>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="tgl">Tanggal Transaksi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="tgl" name="tgl" value="{{ old('tgl', data_get($formModel ?? null, 'tgl', date('d-m-Y'))) }}" class="form-control required datepicker" autocomplete="off" placeholder="Pilih tanggal transaksi">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-calendar" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="jenis_pembayaran">Metode Pembayaran <span class="text-danger">*</span></label>
                    <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control">
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        @foreach((['1' => 'Cash / Tunai', '2' => 'Bank / Transfer']) as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('jenis_pembayaran', data_get($formModel ?? null, 'jenis_pembayaran')) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="divisi_id">Divisi Operasional <span class="text-danger">*</span></label>
                    <select id="divisi_id" name="divisi_id" class="form-control">
                        <option value="">-- Pilih Divisi --</option>
                        @foreach(App\Divisi::where('id', '2')->pluck('name', 'id') as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id')) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group anggota">
                    <label class="control-label" for="anggota_id">Pilih Anggota Koperasi <span class="text-danger">*</span></label>
                    @if(!empty($installmentPayment))
                        <input type="hidden" name="anggota_id" value="{{ $transaksiHarian->anggota_id }}">
                        <input id="anggota_id" type="text" class="form-control" value="{{ $transaksiHarian->nama_anggota }}" readonly>
                    @else
                        <select id="anggota_id" name="anggota_id" class="form-control select2">
                            <option value="">-- Cari Nama / No Anggota --</option>
                            @foreach(App\Anggota::pluck('nama', 'id') as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" @selected((string) old('anggota_id', data_get($formModel ?? null, 'anggota_id')) === (string) $optionValue)>
                                    {{ $optionLabel }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-box mb-0">
            <h5 class="header-title"><i class="fi-head mr-1 text-teal" aria-hidden="true"></i> Data Identitas Anggota</h5>
            <div class="row">
                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted d-block">Nama Lengkap</small>
                    <strong id="nama-anggota">-</strong>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted d-block">Jabatan / Posisi</small>
                    <strong id="nama-jabatan">-</strong>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted d-block">Status Keanggotaan</small>
                    <strong id="status-anggota">-</strong>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted d-block">Tanggal Bergabung</small>
                    <strong id="tanggal-daftar">-</strong>
                </div>
            </div>
        </div>
    </section>

    <h3>Detail Pembayaran</h3>
    <section>
        <div class="form-group">
            <label class="control-label" for="jenis_transaksi">Jenis Transaksi</label>
            <select id="jenis_transaksi" name="jenis_transaksi" class="form-control">
                <option value="">-- Pilih Jenis Transaksi --</option>
                @foreach((['1' => 'Debet']) as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected((string) old('jenis_transaksi', data_get($formModel ?? null, 'jenis_transaksi')) === (string) $optionValue)>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="pinjam-debet">
            @if(isset($cicilanTersedia))
                <div class="form-group">
                    <label for="transaksi_pinjaman_id">Angsuran Pinjaman (opsional)</label>
                    <select id="transaksi_pinjaman_id" name="transaksi_pinjaman_id" class="form-control">
                        <option value="">Pembayaran biasa / tanpa tautan cicilan</option>
                        @foreach($cicilanTersedia as $installment)
                            <option value="{{ $installment['transaksi_pinjaman_id'] }}"
                                data-anggota="{{ $installment['anggota_id'] }}"
                                data-angsuran="{{ $installment['bulan'] }}"
                                data-total-angsuran="{{ $installment['total_angsuran'] }}"
                                data-jatuh-tempo="{{ $installment['jatuh_tempo']->format('d-m-Y') }}"
                                data-pokok="{{ $installment['pokok'] }}"
                                data-bunga="{{ $installment['bunga'] }}"
                                @selected((string) old('transaksi_pinjaman_id') === (string) $installment['transaksi_pinjaman_id'])>
                                {{ $installment['anggota_nama'] }} - {{ $installment['produk'] }}
                                Rp. {{ number_format($installment['nominal_pinjaman'], 0, ',', '.') }} (pinjaman {{ $installment['tgl_pinjaman'] }})
                                - Angsuran ke-{{ $installment['bulan'] }} dari {{ $installment['total_angsuran'] }} (jatuh tempo {{ $installment['jatuh_tempo']->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('transaksi_pinjaman_id') <small class="text-danger">{{ $message }}</small> @enderror
                    @error('angsuran_ke') <small class="text-danger">{{ $message }}</small> @enderror
                    <input type="hidden" name="angsuran_ke" id="angsuran_ke" value="{{ old('angsuran_ke') }}">
                    <small class="form-text text-muted">Pilih pinjaman untuk mencatat pelunasan angsuran. Nominal pokok dan bunga harus sesuai jadwal; nominal simpanan diisi manual.</small>
                </div>
                <div id="cicilan-kredit-summary" class="alert alert-info" style="display: none;"></div>
            @elseif(!empty($installmentPayment))
                <div class="alert alert-info">
                    <strong>Angsuran ke-{{ $installmentPayment->angsuran_ke }} dari {{ $installmentPayment->pinjaman->lama_cicilan }} - Lunas</strong>,
                    jatuh tempo {{ $installmentPayment->jatuh_tempo->format('d-m-Y') }}.
                </div>
                <input type="hidden" name="transaksi_pinjaman_id" value="{{ $installmentPayment->transaksi_pinjaman_id }}">
                <input type="hidden" name="angsuran_ke" value="{{ $installmentPayment->angsuran_ke }}">
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nominal_pinjaman" class="control-label">Nominal Pokok</label>
                        <input type="hidden" name="id_biaya_pinjaman" value="6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input id="nominal_pinjaman" type="text" class="form-control biaya" name="nominal_pinjaman" value="{{ old('nominal_pinjaman', !empty($installmentPayment) ? 'Rp. ' . number_format($installmentPayment->pokok, 0, ',', '.') : ($nominal_pinjaman ?? null)) }}" @required(!empty($installmentPayment))>
                        </div>
                        @error('nominal_pinjaman') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nominal_bunga" class="control-label">Bunga</label>
                        <input type="hidden" name="id_biaya_bunga_pinjaman" value="7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input id="nominal_bunga" type="text" class="form-control biaya" name="nominal_bunga" value="{{ old('nominal_bunga', !empty($installmentPayment) ? 'Rp. ' . number_format($installmentPayment->bunga, 0, ',', '.') : ($nominal_bunga ?? null)) }}" @required(!empty($installmentPayment))>
                        </div>
                        @error('nominal_bunga') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            <div id="simpanan-angsuran" class="card-box mt-2 mb-0" @if(empty($installmentPayment)) style="display: none;" @endif>
                <h5 class="header-title">Simpanan Bersamaan dengan Angsuran</h5>
                <p class="text-muted">Isi nominal setoran untuk masing-masing jenis simpanan. Masukkan 0 jika tidak ada setoran.</p>
                <div class="row">
                    @foreach([
                        'pokok' => ['Simpanan Pokok', 1],
                        'wajib' => ['Simpanan Wajib', 2],
                        'sukarela' => ['Simpanan Sukarela', 3],
                    ] as $jenisSimpanan => $simpanan)
                        @php
                            $fieldName = 'nominal_simpanan_' . $jenisSimpanan;
                            $savedAmount = data_get($savingAmounts ?? [], (string) $simpanan[1], 0);
                        @endphp
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="{{ $fieldName }}">{{ $simpanan[0] }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                    <input
                                        id="{{ $fieldName }}"
                                        type="text"
                                        name="{{ $fieldName }}"
                                        class="form-control biaya simpanan-angsuran-input"
                                        value="{{ old($fieldName, !empty($installmentPayment) ? 'Rp. ' . number_format($savedAmount, 0, ',', '.') : null) }}"
                                        @required(!empty($installmentPayment))
                                        @disabled(empty($installmentPayment))
                                    >
                                </div>
                                @error($fieldName) <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <h3>Keterangan & Konfirmasi</h3>
    <section>
        <div class="form-group">
            <label class="control-label" for="keterangan">Keterangan / Catatan Transaksi <span class="text-danger">*</span></label>
            <textarea id="keterangan" name="keterangan" class="form-control required" rows="4" autocomplete="off" placeholder="Tuliskan keterangan pembayaran atau catatan penting lainnya...">{{ old('keterangan', data_get($formModel ?? null, 'keterangan')) }}</textarea>
            <small class="form-text text-muted mt-1">Catatan ini akan tercatat dalam buku transaksi keuangan koperasi.</small>
        </div>
        <div class="transaction-note">
            <strong><i class="mdi mdi-information-outline mr-1" aria-hidden="true"></i> Konfirmasi Transaksi</strong>
            <p class="mb-0 mt-1">Pastikan anggota, nominal pokok, bunga, dan setoran simpanan sudah benar. Pembayaran angsuran harus sesuai jadwal agar tercatat Lunas.</p>
        </div>
    </section>
</div>
