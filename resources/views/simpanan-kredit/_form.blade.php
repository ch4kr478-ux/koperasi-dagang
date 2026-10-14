<div>
    <h3>Informasi Anggota</h3>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="tgl">Tanggal Transaksi</label>
                    <div class="input-group">
                        <input type="text" id="tgl" name="tgl" value="{{ old('tgl', data_get($formModel ?? null, 'tgl')) }}" class="form-control required datepicker" autocomplete="off" placeholder="Pilih tanggal transaksi">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-calendar" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="jenis_pembayaran">Metode Pembayaran</label>
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
                    <label class="control-label" for="divisi_id">Divisi Operasional</label>
                    <select id="divisi_id" name="divisi_id" class="form-control">
                        <option value="">-- Pilih Divisi --</option>
                        @foreach(App\Divisi::where('id', '1')->pluck('name', 'id') as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id')) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 anggota">
                <div class="form-group">
                    <label class="control-label" for="anggota_id">Pilih Anggota Koperasi</label>
                    <select id="anggota_id" name="anggota_id" class="form-control select2">
                        <option value="">-- Cari Nama / No Anggota --</option>
                        @foreach(App\Anggota::pluck('nama', 'id') as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('anggota_id', data_get($formModel ?? null, 'anggota_id')) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card-box mb-0 anggota">
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

    <h3>Detail Penarikan</h3>
    <section>
        <div class="form-group">
            <label class="control-label" for="jenis_transaksi">Jenis Transaksi</label>
            <select id="jenis_transaksi" name="jenis_transaksi" class="form-control">
                <option value="">-- Pilih Jenis Transaksi --</option>
                @foreach((['2' => 'Kredit']) as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected((string) old('jenis_transaksi', data_get($formModel ?? null, 'jenis_transaksi')) === (string) $optionValue)>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="transaksi-kredit">
            <div class="form-group">
                <label for="nominal" class="control-label">Nominal Penarikan</label>
                <input type="hidden" name="biaya_id" value="4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input id="nominal" type="text" name="nominal" value="{{ old('nominal', data_get($formModel ?? null, 'nominal')) }}" class="form-control biaya" autocomplete="off" placeholder="Masukkan nominal penarikan">
                </div>
            </div>
        </div>
    </section>

    <h3>Keterangan & Konfirmasi</h3>
    <section>
        <div class="form-group">
            <label class="control-label" for="keterangan">Keterangan Transaksi</label>
            <textarea id="keterangan" name="keterangan" class="form-control required" rows="4" autocomplete="off" placeholder="Tuliskan keterangan penarikan atau catatan penting lainnya...">{{ old('keterangan', data_get($formModel ?? null, 'keterangan')) }}</textarea>
            <small class="form-text text-muted mt-1">Catatan ini akan tercatat dalam buku transaksi simpanan koperasi.</small>
        </div>
        <div class="transaction-note">
            <strong><i class="mdi mdi-information-outline mr-1" aria-hidden="true"></i> Konfirmasi Transaksi</strong>
            <p class="mb-0 mt-1">Pastikan anggota, metode pembayaran, dan nominal penarikan sudah sesuai sebelum menyimpan transaksi.</p>
        </div>
    </section>
</div>
