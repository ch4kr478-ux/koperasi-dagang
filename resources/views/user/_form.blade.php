<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
    <div class="col-8">
        <input type="text" name="name" value="{{ old('name', data_get($formModel ?? null, 'name')) }}" class="form-control" placeholder="Nama Pengguna">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Email Pengguna</label>
    <div class="col-8">
        <input type="text" name="email" value="{{ old('email', data_get($formModel ?? null, 'email')) }}" class="form-control" placeholder="Email">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Hak Akses</label>
    <div class="col-8">
            <select name="role_id" class="form-control select2">
@foreach(([''=>'Hak Akses']+App\Role::whereNotIn('name', ['member'])->pluck('name','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('role_id', data_get($formModel ?? null, 'role_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Password</label>
    <div class="col-8">
        <input type="password" name="password" class="form-control" placeholder="Password">
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Konfirmasi Password</label>
    <div class="col-8">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
