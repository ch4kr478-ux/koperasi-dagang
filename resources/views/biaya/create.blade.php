@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Tambah Biaya</h4>
                <small>Tambahkan jenis biaya dan divisi yang terkait.</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('biaya.index') }}">Biaya</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <h4 class="header-title mb-3">Informasi Biaya</h4>
            <form method="post" action="{{ route('biaya.store') }}">
                @csrf
                @include('biaya._form')
            </form>
        </div>
    </div>
</div>
@endsection
