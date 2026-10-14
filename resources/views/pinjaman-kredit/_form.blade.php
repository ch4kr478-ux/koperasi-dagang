<div>
    <!-- Section Page 1 -->
    <h3>Informasi Divisi & Anggota</h3>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="tgl">Tanggal Transaksi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="tgl" name="tgl" value="{{ old('tgl', data_get($formModel ?? null, 'tgl', date('d-m-Y'))) }}" class="form-control required datepicker" autocomplete="off" placeholder="Pilih tanggal transaksi">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="jenis_pembayaran">Metode Pembayaran <span class="text-danger">*</span></label>
                    <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control required">
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        @foreach((['1' => 'Cash / Tunai', '2' => 'Bank / Transfer']) as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('jenis_pembayaran', data_get($formModel ?? null, 'jenis_pembayaran', null)) === (string) $optionValue)>
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
                    <select id="divisi_id" name="divisi_id" class="form-control required">
                        @foreach(([''=>'-- Pilih Divisi --']+App\Divisi::where('id', '2')->pluck('name','id')->all()) as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id', 2)) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group anggota">
                    <label class="control-label" for="anggota_id">Pilih Anggota Koperasi <span class="text-danger">*</span></label>
                    <select id="anggota_id" name="anggota_id" class="form-control select2 required">
                        <option value="">-- Cari Nama / No Anggota --</option>
                        @foreach(App\Anggota::pluck('nama','id')->all() as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('anggota_id', data_get($formModel ?? null, 'anggota_id', null)) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Member Profile Preview Card -->
        <div class="member-info-panel">
            <div class="member-info-panel-title">
                <i class="fi-head mr-1"></i> Data Identitas Anggota
            </div>
            <div class="member-info-grid">
                <div class="member-info-item">
                    <div class="item-label">Nama Lengkap</div>
                    <div class="item-val" id="nama-anggota">-</div>
                </div>
                <div class="member-info-item">
                    <div class="item-label">Jabatan / Posisi</div>
                    <div class="item-val" id="nama-jabatan">-</div>
                </div>
                <div class="member-info-item">
                    <div class="item-label">Status Keanggotaan</div>
                    <div class="item-val"><span id="status-anggota" class="badge badge-soft-success">-</span></div>
                </div>
                <div class="member-info-item">
                    <div class="item-label">Tanggal Bergabung</div>
                    <div class="item-val" id="tanggal-daftar">-</div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section Page 1 -->

    <!-- Section Page 2 -->
    <h3>Detail Pinjaman & Tenor</h3>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="jenis_transaksi">Jenis Transaksi</label>
                    <select id="jenis_transaksi" name="jenis_transaksi" class="form-control" readonly>
                        @foreach((['2' => 'Kredit (Pencairan Pinjaman Dana)']) as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) old('jenis_transaksi', data_get($formModel ?? null, 'jenis_transaksi', '2')) === (string) $optionValue)>
                                {{ $optionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div id="pinjam-kredit">
            @include('pinjaman-kredit._product-tenor-fields')
        </div>
    </section>
    <!-- End Section Page 2 -->

    <!-- Section Page 3 -->
    <h3>Keterangan & Konfirmasi</h3>
    <section>
        <div class="form-group">
            <label class="control-label" for="keterangan">Keterangan / Catatan Transaksi <span class="text-danger">*</span></label>
            <textarea id="keterangan" name="keterangan" class="form-control required" rows="4" placeholder="Tuliskan tujuan pinjaman, nomor referensi berkas pengajuan, atau catatan penting lainnya..." autocomplete="off">{{ old('keterangan', data_get($formModel ?? null, 'keterangan')) }}</textarea>
            <small class="form-text text-muted mt-1">Catatan ini akan tercatat dalam buku transaksi keuangan koperasi.</small>
        </div>

        <div class="alert alert-info mt-3" style="border-radius: 10px;">
            <i class="mdi mdi-information-outline" style="font-size: 20px;"></i>
            <div>
                <strong>Konfirmasi Pencatatan Transaksi</strong>
                <p class="mb-0" style="font-size: 12.5px;">Pastikan data peminjam, produk, nominal cicilan, serta tenor pinjaman telah sesuai dengan persetujuan pengurus sebelum menyelesaikan transaksi.</p>
            </div>
        </div>
    </section>
    <!-- End Section Page 3 -->
</div>