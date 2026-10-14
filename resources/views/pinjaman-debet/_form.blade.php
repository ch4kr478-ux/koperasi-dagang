<div>
    <!-- Section Page 1 -->
    <h3>Divisi</h3>
    <section>
        <div class="form-group clearfix">
            <label class="control-label " for="userName">Tanggal Transaksi</label>
            <div class="">
                <input type="text" name="tgl" value="{{ old('tgl', data_get($formModel ?? null, 'tgl')) }}" class="form-control required datepicker" autocomplete="off">
            </div>
        </div>
        <div class="form-group clearfix">
            <label class="control-label " for="password"> Jenis Pembayaran *</label>
            <div class="">
                <select name="jenis_pembayaran" class="form-control">
<option value="">{{ '<---Jenis Transaksi -->' }}</option>
@foreach((['1' => 'Cash', '2' => 'Bank']) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('jenis_pembayaran', data_get($formModel ?? null, 'jenis_pembayaran', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
            </div>
        </div>
        <div class="form-group clearfix">
            <label class="control-label " for="confirm">Divisi *</label>
            <div class="">
                <select name="divisi_id" class="form-control">
@foreach(([''=>'']+App\Divisi::where('id', '2')->pluck('name','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
            </div>
        </div>
        <div class="form-group clearfix anggota">
            <label class="control-label " for="confirm">No Anggota *</label>
            @if(!empty($installmentPayment))
                <input type="hidden" name="anggota_id" value="{{ $transaksiHarian->anggota_id }}">
                <input type="text" class="form-control" value="{{ $transaksiHarian->nama_anggota }}" readonly>
            @else
            <select name="anggota_id" class="form-control select2">
@foreach(([''=>'Pilih Anggota']+App\Anggota::pluck('nama','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('anggota_id', data_get($formModel ?? null, 'anggota_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
            @endif
        </div>
        <div class="form-group clearfix anggota col-8">
            <table class="table">
                <tr>
                    <td><strong>Nama Anggota</strong></td>
                    <td>:</td>
                    <td id="nama-anggota"></td>
                </tr>
                <tr>
                    <td><strong>Jabatan</strong></td>
                    <td>:</td>
                    <td id="nama-jabatan"></td>
                </tr>
                <tr>
                    <td><strong>Status Anggota</strong></td>
                    <td>:</td>
                    <td id="status-anggota"></td>
                </tr>
                <tr>
                    <td><strong>Tanggal Daftar</strong></td>
                    <td>:</td>
                    <td id="tanggal-daftar"></td>
                </tr>
            </table>
        </div>
    </section>
    <!-- End Section Page 1 -->
    <!-- Section Page 2 -->
    <h3>Transaksi</h3>
    <section>
        <div class="form-group clearfix">
            <label class="control-label" for="name"> Transaksi</label>
            <div class="">
                <select name="jenis_transaksi" class="form-control">
<option value="">{{ '<---Jenis Transaksi -->' }}</option>
@foreach((['1' => 'Debet']) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('jenis_transaksi', data_get($formModel ?? null, 'jenis_transaksi', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
            </div>
        </div>
        <!-- End Show Jenis Transaksi == 1 -->
        <!-- Show If Divisi ID == 2 AND JENIS TRANSAKSI == 1 -->
        <div id="pinjam-debet">
            @if(isset($cicilanTersedia))
                <div class="form-group">
                    <label for="transaksi_pinjaman_id">Cicilan Pinjaman Kredit (opsional)</label>
                    <select id="transaksi_pinjaman_id" name="transaksi_pinjaman_id" class="form-control">
                        <option value="">Pembayaran biasa / tanpa tautan cicilan</option>
                        @foreach($cicilanTersedia as $installment)
                            <option value="{{ $installment['transaksi_pinjaman_id'] }}"
                                data-anggota="{{ $installment['anggota_id'] }}"
                                data-angsuran="{{ $installment['bulan'] }}"
                                data-jatuh-tempo="{{ $installment['jatuh_tempo']->format('d-m-Y') }}"
                                data-pokok="{{ $installment['pokok'] }}"
                                data-bunga="{{ $installment['bunga'] }}"
                                data-tabungan="{{ $installment['tabungan'] }}"
                                data-total="{{ $installment['total'] }}"
                                @selected((string) old('transaksi_pinjaman_id') === (string) $installment['transaksi_pinjaman_id'])>
                                {{ $installment['anggota_nama'] }} - {{ $installment['produk'] }}
                                Rp. {{ number_format($installment['nominal_pinjaman'], 0, ',', '.') }} (pinjaman {{ $installment['tgl_pinjaman'] }})
                                - Angsuran ke-{{ $installment['bulan'] }} (jatuh tempo {{ $installment['jatuh_tempo']->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('transaksi_pinjaman_id') <small class="text-danger">{{ $message }}</small> @enderror
                    @error('angsuran_ke') <small class="text-danger">{{ $message }}</small> @enderror
                    <input type="hidden" name="angsuran_ke" id="angsuran_ke" value="{{ old('angsuran_ke') }}">
                    <small class="form-text text-muted">Jika dipilih, nilai cicilan harus dibayar penuh. Simpanan wajib 0,5% dicatat otomatis.</small>
                </div>
                <div id="cicilan-kredit-summary" class="alert alert-info" style="display: none;"></div>
            @elseif(!empty($installmentPayment))
                <div class="alert alert-info">
                    Pembayaran angsuran ke-{{ $installmentPayment->angsuran_ke }},
                    jatuh tempo {{ $installmentPayment->jatuh_tempo->format('d-m-Y') }}.
                    Tabungan wajib yang tercatat: Rp. {{ number_format($installmentPayment->tabungan, 0, ',', '.') }}.
                </div>
                <input type="hidden" name="transaksi_pinjaman_id" value="{{ $installmentPayment->transaksi_pinjaman_id }}">
                <input type="hidden" name="angsuran_ke" value="{{ $installmentPayment->angsuran_ke }}">
            @endif
            <div class="form-group clearfix">
                <label for="Pokok" class="control-label">Nominal</label>
                <div class="">
                    <input type="hidden" class="form-control" name="id_biaya_pinjaman" value="6">
                    <input type="text" class="form-control biaya" name="nominal_pinjaman" value="{{ old('nominal_pinjaman', !empty($installmentPayment) ? 'Rp. ' . number_format($installmentPayment->pokok, 0, ',', '.') : ($nominal_pinjaman ?? null)) }}" @readonly(!empty($installmentPayment))>
                </div>
            </div>
            <div class="form-group clearfix">
                <label for="Pokok" class="control-label">Bunga</label>
                <div class="">
                    <input type="hidden" class="form-control" name="id_biaya_bunga_pinjaman" value="7">
                    <input type="text" class="form-control biaya" name="nominal_bunga" value="{{ old('nominal_bunga', !empty($installmentPayment) ? 'Rp. ' . number_format($installmentPayment->bunga, 0, ',', '.') : ($nominal_bunga ?? null)) }}" @readonly(!empty($installmentPayment))>
                </div>
            </div>
        </div>
        <!-- End Show If Divisi ID == 2 AND JENIS TRANSAKSI == 1 -->
    </section>
    <!-- end Section Page 2 -->
    <!-- Section Page 3 -->
    <h3>Keterangan</h3>
    <section>
        <div class="form-group clearfix">
            <label class="control-label " for="surname"> Keterangan </label>
            <div class="">
                <textarea name="keterangan" class="form-control required" autocomplete="off">{{ old('keterangan', data_get($formModel ?? null, 'keterangan')) }}</textarea>
            </div>
        </div>
    </section>
    <!-- End Section Page 3 -->
</div>