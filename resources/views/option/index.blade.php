@extends('layouts.master')

@php
    $logo=asset(Storage::url('logo/'));
@endphp
@section('content')
<div class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Options</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Management</a></li>
                            <li class="breadcrumb-item active">Options</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Options</h4>
                            <p class="sub-title">Silahkan Atur Sesuaikan Dengan Perusahaan Anda</p>

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#company" role="tab">
                                        <span class="d-none d-md-block">Logo</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                        <span class="d-none d-md-block">Profil Perusahaan</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#email-option" role="tab">
                                        <span class="d-none d-md-block">Email Perusahaan</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#social-media" role="tab">
                                        <span class="d-none d-md-block">Sosial Media</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="company" role="tabpanel">
                                    @php($formModel = $option)
<form method="post" action="{{ url('option') }}" enctype="multipart/form-data">
@csrf

                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <h5>{{__('Logo')}}</h5>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="height: 150px;">
                                                            <img src="{{$logo.'/logo.png'}}" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Pilih Gambar')}} </span>
                                                                <span class="fileinput-exists"> {{__('Ubah')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="logo" id="logo">
                                                            </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Hapus')}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h5>{{__('Small Logo')}}</h5>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="height: 150px;">
                                                            <img src="{{$logo.'/small_logo.png'}}" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Pilih Gambar')}} </span>
                                                                <span class="fileinput-exists"> {{__('Ubah')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="small_logo" id="small_logo">
                                                            </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Hapus')}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h5>{{__('Favicon')}}</h5>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="height: 150px;">
                                                            <img src="{{$logo.'/favicon.png'}}" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Pilih Gambar')}} </span>
                                                                <span class="fileinput-exists"> {{__('Ubah')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="favicon" id="favicon">
                                                            </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Hapus')}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @error('logo')
                                                <span class="invalid-logo" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="row mt-20">
                                                <div class="form-group col-md-6">
                                                    <label for="title_text">{{ __('Title Text') }}</label>
                                                    <input type="text" name="title_text" value="{{ old('title_text', data_get($formModel ?? null, 'title_text')) }}" class="form-control" placeholder="{{ __('Title Text') }}">
                                                    @error('title_text')
                                                    <span class="invalid-title_text" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="footer_text">{{ __('Footer Text') }}</label>
                                                    <input type="text" name="footer_text" value="{{ old('footer_text', data_get($formModel ?? null, 'footer_text')) }}" class="form-control" placeholder="{{ __('Footer Text') }}">
                                                    @error('footer_text')
                                                    <span class="invalid-footer_text" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" value="{{ __('Simpan') }}" class="btn btn-primary">
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                                    <div class="row">
                                        @php($formModel = $option)
<form method="post" action="{{ route('company.option') }}">
@csrf

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="company_name">{{ __('Nama Perusahaan *') }}</label>
                                                    <input type="text" name="company_name" value="{{ old('company_name', data_get($formModel ?? null, 'company_name')) }}" class="form-control font-style">
                                                    @error('company_name')
                                                    <span class="invalid-company_name" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company_address">{{ __('Alamat') }}</label>
                                                    <textarea name="company_address" class="form-control font-style" rows="3">{{ old('company_address', data_get($formModel ?? null, 'company_address')) }}</textarea>
                                                    @error('company_address')
                                                    <span class="invalid-company_address" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company_phone">{{ __('Telepon') }}</label>
                                                    <input type="text" name="company_phone" value="{{ old('company_phone', data_get($formModel ?? null, 'company_phone')) }}" class="form-control font-style">
                                                    @error('company_phone')
                                                    <span class="invalid-company_phone" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company_email">{{ __('Email') }}</label>
                                                    <input type="text" name="company_email" value="{{ old('company_email', data_get($formModel ?? null, 'company_email')) }}" class="form-control font-style">
                                                    @error('company_email')
                                                    <span class="invalid-company_email" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="postal_code">{{ __('Kode Pos') }}</label>
                                                    <input type="text" name="postal_code" value="{{ old('postal_code', data_get($formModel ?? null, 'postal_code')) }}" class="form-control font-style">
                                                    @error('postal_code')
                                                    <span class="invalid-postal_code" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="phone_wa">{{ __('No Handphone (WA)') }}</label>
                                                    <input type="text" name="phone_wa" value="{{ old('phone_wa', data_get($formModel ?? null, 'phone_wa')) }}" class="form-control font-style">
                                                    @error('phone_wa')
                                                        <span class="invalid-phone_wa" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="text_wa">{{ __('Default Text (WA)') }}</label>
                                                    <textarea name="text_wa" class="form-control font-style" rows="3">{{ old('text_wa', data_get($formModel ?? null, 'text_wa')) }}</textarea>
                                                    @error('text_wa')
                                                        <span class="invalid-text_wa" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <input type="submit" value="{{ __('Simpan') }}" class="btn btn-primary">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="email-option" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="email-option-wrap">
                                        @php($formModel = null)
<form method="post" action="{{ route('email.option') }}">
@csrf

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="mail_driver">{{ __('Mail Driver') }}</label>
                                                <input type="text" name="mail_driver" value="{{ old('mail_driver', env('MAIL_MAILER', env('MAIL_DRIVER'))) }}" class="form-control" placeholder="{{ __('Enter Mail Driver') }}">
                                                @error('mail_driver')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_host">{{ __('Mail Host') }}</label>
                                                <input type="text" name="mail_host" value="{{ old('mail_host', env('MAIL_HOST')) }}" class="form-control " placeholder="{{ __('Enter Mail Driver') }}">
                                                @error('mail_host')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_port">{{ __('Mail Port') }}</label>
                                                <input type="text" name="mail_port" value="{{ old('mail_port', env('MAIL_PORT')) }}" class="form-control" placeholder="{{ __('Enter Mail Port') }}">
                                                @error('mail_port')
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_username">{{ __('Mail Username') }}</label>
                                                <input type="text" name="mail_username" value="{{ old('mail_username', env('MAIL_USERNAME')) }}" class="form-control" placeholder="{{ __('Enter Mail Username') }}">
                                                @error('mail_username')
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_password">{{ __('Mail Password') }}</label>
                                                <input type="text" name="mail_password" value="{{ old('mail_password', env('MAIL_PASSWORD')) }}" class="form-control" placeholder="{{ __('Enter Mail Password') }}">
                                                @error('mail_password')
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_encryption">{{ __('Mail Encryption') }}</label>
                                                <input type="text" name="mail_encryption" value="{{ old('mail_encryption', env('MAIL_SCHEME', env('MAIL_ENCRYPTION'))) }}" class="form-control" placeholder="{{ __('Enter Mail Encryption') }}">
                                                @error('mail_encryption')
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_from_address">{{ __('Mail From Address') }}</label>
                                                <input type="text" name="mail_from_address" value="{{ old('mail_from_address', env('MAIL_FROM_ADDRESS')) }}" class="form-control" placeholder="{{ __('Enter Mail From Address') }}">
                                                @error('mail_from_address')
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mail_from_name">{{ __('Mail From Name') }}</label>
                                                <input type="text" name="mail_from_name" value="{{ old('mail_from_name', env('MAIL_FROM_NAME')) }}" class="form-control" placeholder="{{ __('Enter Mail Encryption') }}">
                                                @error('mail_from_name')
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @permission('create-email')
                                        <div class="text-right">
                                            <input type="submit" value="{{ __('Simpan') }}" class="btn btn-primary">
                                        </div>
                                        @endpermission
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="social-media" role="tabpanel">
                                    <div class="row">
                                        @php($formModel = $option)
<form method="post" action="{{ route('social-media') }}">
@csrf

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="company_fb">{{ __('Facebook') }}</label>
                                                    <input type="text" name="company_fb" value="{{ old('company_fb', data_get($formModel ?? null, 'company_fb')) }}" class="form-control font-style">
                                                    @error('company_fb')
                                                    <span class="invalid-company_fb" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company_ig">{{ __('Instagram') }}</label>
                                                    <input type="text" name="company_ig" value="{{ old('company_ig', data_get($formModel ?? null, 'company_ig')) }}" class="form-control font-style">
                                                    @error('company_ig')
                                                    <span class="invalid-company_ig" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company_twitter">{{ __('Twitter') }}</label>
                                                    <input type="text" name="company_twitter" value="{{ old('company_twitter', data_get($formModel ?? null, 'company_twitter')) }}" class="form-control font-style">
                                                    @error('company_twitter')
                                                    <span class="invalid-company_twitter" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company_yt">{{ __('Youtube') }}</label>
                                                    <input type="text" name="company_yt" value="{{ old('company_yt', data_get($formModel ?? null, 'company_yt')) }}" class="form-control font-style">
                                                    @error('company_yt')
                                                    <span class="invalid-company_yt" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <input type="submit" value="{{ __('Simpan') }}" class="btn btn-primary">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
