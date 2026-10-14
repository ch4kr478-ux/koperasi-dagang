<div class="form-group row">
    <label class="col-md-4 col-form-label" for="name">Nama Biaya</label>
    <div class="col-md-8">
        <input id="name" type="text" name="name" value="{{ old('name', data_get($formModel ?? null, 'name')) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama biaya" required>
        @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label class="col-md-4 col-form-label" for="jenis_biaya">Jenis Biaya</label>
    <div class="col-md-8">
        <select id="jenis_biaya" name="jenis_biaya" class="form-control @error('jenis_biaya') is-invalid @enderror" required>
            <option value="">Pilih jenis biaya</option>
            @foreach(['1' => 'Debet', '2' => 'Kredit'] as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) old('jenis_biaya', data_get($formModel ?? null, 'jenis_biaya')) === (string) $optionValue)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
        @error('jenis_biaya')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label class="col-md-4 col-form-label" for="divisi_id">Divisi</label>
    <div class="col-md-8">
        <select id="divisi_id" name="divisi_id" class="form-control @error('divisi_id') is-invalid @enderror" required>
            <option value="">Pilih divisi</option>
            @foreach(App\Divisi::orderBy('name')->pluck('name', 'id') as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id')) === (string) $optionValue)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
        @error('divisi_id')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="d-flex flex-wrap" style="gap: 10px;">
    <button type="submit" class="btn btn-primary">
        <i class="mdi mdi-content-save-outline" aria-hidden="true"></i> Simpan Biaya
    </button>
    <a href="{{ route('biaya.index') }}" class="btn btn-outline-secondary">
        <i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali
    </a>
</div>
