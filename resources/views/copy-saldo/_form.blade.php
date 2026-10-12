<div>
    <section>
            <div class="form-group clearfix">
                <label class="control-label " for="from-periode">From Periode</label>
                <div class="">
                    <select name="from_periode_id" class="{{ $errors->has('from_periode_id') ? 'form-control is-invalid' : 'form-control' }}">
@foreach(([''=>'']+App\Periode::pluck('name','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('from_periode_id', data_get($formModel ?? null, 'from_periode_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
                        @error('from_periode_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label " for="to-periode">To Periode</label>
                <div class="">
                    <select name="to_periode_id" class="{{ $errors->has('to_periode_id') ? 'form-control is-invalid' : 'form-control' }}">
@foreach(([''=>'']+App\Periode::pluck('name','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('to_periode_id', data_get($formModel ?? null, 'to_periode_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
                    @error('to_periode_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label " for="divisi">Divisi</label>
                <div class="">
                    <select name="divisi_id" class="{{ $errors->has('divisi_id') ? 'form-control is-invalid' : 'form-control' }}">
@foreach(([''=>'']+App\Divisi::pluck('name','id')->all()) as $optionValue => $optionLabel)
<option value="{{ $optionValue }}" @selected((string) old('divisi_id', data_get($formModel ?? null, 'divisi_id', null)) === (string) $optionValue)>{{ $optionLabel }}</option>
@endforeach
</select>
                    @error('divisi_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
    </section>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{route('copy-saldo.index')}}" class="btn btn-success"> Kembali</a>
