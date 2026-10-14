

<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Awal Periode</label>
    <div class="col-8">
        <input type="text" name="open_date" value="{{ old('open_date', data_get($formModel ?? null, 'open_date')) }}" class="{{ $errors->has('open_date') ? 'form-control datepicker is-invalid' : 'form-control datepicker' }}" placeholder="Tanggal Awal Periode" autocomplete="off">
        @error('open_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Akhir Periode</label>
    <div class="col-8">
        <input type="text" name="close_date" value="{{ old('close_date', data_get($formModel ?? null, 'close_date')) }}" class="{{ $errors->has('close_date') ? 'form-control datepicker is-invalid' : 'form-control datepicker' }}" placeholder="Tanggal Akhir Periode" autocomplete="off">
        @error('close_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Periode</label>
    <div class="col-8">
        <input type="text" name="name" value="{{ old('name', data_get($formModel ?? null, 'name')) }}" class="{{ $errors->has('name') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Nama Periode">
        @error('name')
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
<option value="">{{ 'Select Status' }}</option>
@foreach((['1' => 'Aktif', '0' => 'None Aktif']) as $optionValue => $optionLabel)
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
<button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save" aria-hidden="true"></i> Simpan</button>
<a href="{{ route('periode.index') }}" class="btn btn-danger"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali</a>
