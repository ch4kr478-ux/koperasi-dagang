@extends('layouts.app')

@section('style')
<style>
    .error-page {
        width: 100%;
        max-width: 760px;
        margin: auto;
        padding: 28px;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-xl);
        background: var(--k-surface);
        box-shadow: var(--k-shadow-lg);
        text-align: center;
    }

    .error-page-mark {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 72px;
        height: 72px;
        margin-bottom: 18px;
        border: 1px solid var(--k-primary-border);
        border-radius: var(--k-radius-lg);
        color: var(--k-primary);
        background: var(--k-primary-light);
        font-size: 30px;
    }

    .error-page-code {
        margin: 0;
        color: var(--k-primary);
        font-size: clamp(56px, 12vw, 88px);
        font-weight: 800;
        line-height: 1;
        letter-spacing: -.06em;
    }

    .error-page h1 {
        margin: 12px 0 8px;
        font-size: 22px;
        font-weight: 800;
    }

    .error-page p {
        max-width: 460px;
        margin: 0 auto 22px;
        color: var(--k-text-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    @media (max-width: 575.98px) {
        .error-page {
            padding: 26px 20px;
            border-radius: var(--k-radius-lg);
        }
    }
</style>
@endsection

@section('content')
<main class="error-page">
    <div class="error-page-mark">
        <i class="mdi mdi-map-marker" aria-hidden="true"></i>
    </div>
    <p class="error-page-code">404</p>
    <h1>Halaman tidak ditemukan</h1>
    <p>Halaman yang Anda cari mungkin telah dipindahkan atau alamatnya tidak tersedia. Kembali ke beranda untuk melanjutkan.</p>
    <a class="btn btn-primary" href="{{ url('/') }}">
        <i class="mdi mdi-home-outline" aria-hidden="true"></i> Kembali ke Beranda
    </a>
</main>
@endsection
