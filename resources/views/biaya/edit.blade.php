@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Edit Biaya</h4>
                <small>Perbarui nama, jenis, atau divisi biaya.</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('biaya.index') }}">Biaya</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <h4 class="header-title mb-3">Perbarui Informasi Biaya</h4>
            <form method="post" action="{{ route('biaya.update', $biaya->id) }}">
                @csrf
                @method('PUT')
                @php($formModel = $biaya)
                @include('biaya._form')
            </form>
        </div>
    </div>
</div>
@endsection
