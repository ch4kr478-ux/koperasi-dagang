<div class="row">
    <div class="col-lg-8">
        <h5 class="mb-3">Informasi Anggota</h5>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="nik">No. Anggota</label>
            <div class="col-sm-9">
                <input id="nik" type="text" name="nik" value="{{ old('nik', data_get($formModel ?? null, 'nik')) }}" class="{{ $errors->has('nik') ? 'form-control is-invalid' : 'form-control' }}" placeholder="NIK">
                @error('nik')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="nama">Nama</label>
            <div class="col-sm-9">
                <input id="nama" type="text" name="nama" value="{{ old('nama', data_get($formModel ?? null, 'nama')) }}" class="{{ $errors->has('nama') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Nama Anggota">
                @error('nama')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="jabatan">Jabatan</label>
            <div class="col-sm-9">
                <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan', data_get($formModel ?? null, 'jabatan')) }}" class="{{ $errors->has('jabatan') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Jabatan">
                @error('jabatan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="tgl_daftar">Tanggal Daftar</label>
            <div class="col-sm-9">
                <input id="tgl_daftar" type="text" name="tgl_daftar" value="{{ old('tgl_daftar', data_get($formModel ?? null, 'tgl_daftar')) }}" class="{{ $errors->has('tgl_daftar') ? 'form-control datepicker is-invalid' : 'form-control datepicker' }}" placeholder="Tanggal Daftar">
                @error('tgl_daftar')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="status">Status</label>
            <div class="col-sm-9">
                <select id="status" name="status" class="{{ $errors->has('status') ? 'form-control is-invalid' : 'form-control' }}">
                    <option value="">Pilih Status</option>
                    @foreach((['1' => 'Aktif', '0' => 'Non Aktif']) as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" @selected((string) old('status', data_get($formModel ?? null, 'status', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="homebase">Home Base</label>
            <div class="col-sm-9">
                <input id="homebase" type="text" name="homebase" value="{{ old('homebase', data_get($formModel ?? null, 'homebase')) }}" class="{{ $errors->has('homebase') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Home Base">
                @error('homebase')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-lg-0">
            <label class="col-sm-3 col-form-label" for="no_telepon">Nomor Telepon</label>
            <div class="col-sm-9">
                <input id="no_telepon" type="tel" name="no_telepon" value="{{ old('no_telepon', data_get($formModel ?? null, 'no_telepon')) }}" class="{{ $errors->has('no_telepon') ? 'form-control is-invalid' : 'form-control' }}" placeholder="Contoh: 081234567890">
                @error('no_telepon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="border rounded bg-light p-3 h-100 text-center">
            <h5 class="mb-1">Pas Foto</h5>
            <p class="small text-muted mb-3">Gunakan foto formal dengan posisi tegak.</p>
            <div class="d-flex justify-content-center mb-3">
                <div
                    id="pas-foto-placeholder"
                    class="border rounded bg-white text-muted flex-column align-items-center justify-content-center"
                    style="display: {{ $formModel && $formModel->pas_foto ? 'none' : 'flex' }}; width: 225px; height: 300px; border-style: dashed !important;"
                >
                    <i class="mdi mdi-camera-outline mb-2" style="font-size: 32px;" aria-hidden="true"></i>
                    <span class="small">Pratinjau 3:4</span>
                </div>
                <img
                    id="pas-foto-preview"
                    src="{{ $formModel && $formModel->pas_foto ? url('storage/' . $formModel->pas_foto) : '' }}"
                    alt="Pratinjau pas foto anggota"
                    class="border rounded bg-white shadow-sm"
                    style="width: 225px; height: 300px; object-fit: cover; {{ $formModel && $formModel->pas_foto ? '' : 'display: none;' }}"
                >
            </div>
            <div class="text-left">
                <label for="pas_foto">Pilih foto</label>
                <input id="pas_foto" type="file" name="pas_foto" accept=".jpg,.jpeg,.png" class="{{ $errors->has('pas_foto') ? 'form-control is-invalid' : 'form-control' }}">
                <small class="form-text text-muted">JPG atau PNG, maksimal 2 MB. Foto akan dipotong ke rasio 3:4 dan disimpan sebagai JPG 300 × 400 piksel.</small>
                @error('pas_foto')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="mt-4">
    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save" aria-hidden="true"></i> Simpan</button>
    <a href="{{ route('anggota.index') }}" class="btn btn-help-block"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali</a>
</div>
<script>
    (function () {
        var input = document.getElementById('pas_foto');
        var preview = document.getElementById('pas-foto-preview');
        var placeholder = document.getElementById('pas-foto-placeholder');
        var savedPhoto = preview.getAttribute('src');
        var previewUrl;

        input.addEventListener('change', function () {
            var file = input.files[0];

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }

            if (file) {
                previewUrl = URL.createObjectURL(file);
                preview.src = previewUrl;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else if (savedPhoto) {
                preview.src = savedPhoto;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                preview.style.display = 'none';
                placeholder.style.display = 'flex';
            }
        });
    })();
</script>
