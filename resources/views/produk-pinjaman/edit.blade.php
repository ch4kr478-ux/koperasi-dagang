@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Ubah Produk Pinjaman</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card-box">
            <form method="POST" action="{{ route('produk-pinjaman.update', $produkPinjaman->id) }}">
                @csrf
                @method('PUT')
                @include('produk-pinjaman._form')
            </form>
        </div>
    </div>
</div>
@endsection
