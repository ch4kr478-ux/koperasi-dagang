<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Option</label>
    <div class="col-8">
        <input type="text" name="option_name" value="{{ old('option_name', data_get($formModel ?? null, 'option_name')) }}" class="{{ $errors->has('option_name') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Nama Option">
        @error('option_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Option Value</label>
    <div class="col-8">
        <input type="text" name="option_value" value="{{ old('option_value', data_get($formModel ?? null, 'option_value')) }}" class="{{ $errors->has('option_value') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Option Value">
        @error('option_value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save" aria-hidden="true"></i> Simpan</button>
