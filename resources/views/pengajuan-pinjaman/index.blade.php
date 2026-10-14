@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Pengajuan Pinjaman Kredit</h4>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (Auth::user()->hasMemberRole() && Auth::user()->can('create-pengajuan-pinjaman-kredit'))
<div class="mb-3">
    <a href="{{ route('pengajuan-pinjaman.create') }}" class="btn btn-primary">Ajukan Pinjaman</a>
</div>
@endif

<div class="card-box table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                @unless (Auth::user()->hasMemberRole())
                    <th>Anggota</th>
                @endunless
                <th>Nominal</th>
                <th>Lama Cicilan</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @unless (Auth::user()->hasMemberRole())
                        <td>{{ $application->anggota->nama }}</td>
                    @endunless
                    <td>{{ Money::stringToRupiah($application->nominal) }}</td>
                    <td>{{ $application->lama_cicilan }} bulan</td>
                    <td>{{ $application->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        @switch($application->status)
                            @case('menunggu_admin') Menunggu persetujuan Admin @break
                            @case('menunggu_bendahara') Menunggu persetujuan Bendahara @break
                            @case('menunggu_ketua') Menunggu persetujuan Ketua @break
                            @case('disetujui') Disetujui dan dicairkan @break
                            @case('ditolak') Ditolak @break
                        @endswitch
                    </td>
                    <td><a href="{{ route('pengajuan-pinjaman.show', $application->id) }}" class="btn btn-sm btn-info">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ Auth::user()->hasMemberRole() ? 6 : 7 }}" class="text-center">Belum ada pengajuan pinjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
