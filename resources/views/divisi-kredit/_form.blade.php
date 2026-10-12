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
@foreach(([''=>'']+App\Divisi::whereNotIn('id', ['1', '2'])->pluck('name','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
            </div>
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
@foreach((['2' => 'Kredit']) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('jenis_transaksi', data_get($formModel ?? null, 'jenis_transaksi', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
            </div>
        </div>
        <!-- Show If ALl Divisi Not Equeal -->
        <div id="all-divisi">
            <div class="form-group clearfix">
                <label for="Pokok" class="control-label">Nominal</label>
                <div class="">
                    <input type="hidden" name="biaya_id" value="{{ old('biaya_id', data_get($formModel ?? null, 'biaya_id')) }}">
                    <input type="text" name="nominal" value="{{ old('nominal', data_get($formModel ?? null, 'nominal')) }}" class="form-control biaya" autocomplete="off">
                </div>
            </div>
        </div>
        <!-- End Show -->
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