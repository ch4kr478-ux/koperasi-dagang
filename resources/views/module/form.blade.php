<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Module</label>
    <div class="col-8">
        <input type="text" name="name" value="{{ old('name', data_get($formModel ?? null, 'name')) }}" class="{{ $errors->has('name') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Nama Module">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save" aria-hidden="true"></i> Simpan</button>
<a href="{{route('module.index')}}" class="btn btn-warning" ><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali</a>
