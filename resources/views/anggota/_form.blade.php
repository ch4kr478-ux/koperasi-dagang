<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">NO Anggota</label>
    <div class="col-8">
        <input type="text" name="nik" value="{{ old('nik', data_get($formModel ?? null, 'nik')) }}" class="{{ $errors->has('nik') ? 'form-control is-invalid' : 'form-control' }}" placeholder="NIK">
        @error('nik')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
    <div class="col-8">
        <input type="text" name="nama" value="{{ old('nama', data_get($formModel ?? null, 'nama')) }}" class="{{ $errors->has('nama') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Nama Anggota">
        @error('nama')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Jabatan</label>
    <div class="col-8">
        <input type="text" name="jabatan" value="{{ old('jabatan', data_get($formModel ?? null, 'jabatan')) }}" class="{{ $errors->has('jabatan') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Jabatan">
        @error('jabatan')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Daftar</label>
    <div class="col-8">
        <input type="text" name="tgl_daftar" value="{{ old('tgl_daftar', data_get($formModel ?? null, 'tgl_daftar')) }}" class="{{ $errors->has('tgl_daftar') ? 'form-control datepicker is-invalid' : 'form-control datepicker' }}" placeholder="Tanggal Daftar">
        @error('tgl_daftar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Status</label>
    <div class="col-8">
        <select name="status" class="{{ $errors->has('status') ? 'form-control is-invalid' : 'form-control' }}">
<option value="">{{ 'Pilih Status' }}</option>
@foreach((['1' => 'Aktif', '0' => 'Non Aktif']) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('status', data_get($formModel ?? null, 'status', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Home Base</label>
    <div class="col-8">
        <input type="text" name="homebase" value="{{ old('homebase', data_get($formModel ?? null, 'homebase')) }}" class="{{ $errors->has('homebase') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Home Base">
        @error('homebase')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('anggota.index') }}" class="btn btn-help-block">Kembali</a>
