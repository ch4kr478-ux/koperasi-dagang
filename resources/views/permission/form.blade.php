<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Display Name</label>
    <div class="col-8">
        <input type="text" name="display_name" value="{{ old('display_name', data_get($formModel ?? null, 'display_name')) }}" class="{{ $errors->has('display_name') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Display Name">
        @error('display_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Divisi</label>
    <div class="col-8">
        <input type="text" name="description" value="{{ old('description', data_get($formModel ?? null, 'description')) }}" class="{{ $errors->has('description') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Deskripsi">
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save" aria-hidden="true"></i> Simpan</button>
<a href="{{ route ('permission.index')}}" class="btn btn-warning"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali</a>
