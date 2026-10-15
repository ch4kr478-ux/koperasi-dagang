@extends('layouts.app')

@section('style')
<style>
    .welcome-portal {
        width: 100%;
        max-width: 940px;
        margin: auto;
    }

    .welcome-portal-card {
        display: grid;
        grid-template-columns: minmax(280px, .9fr) minmax(340px, 1.1fr);
        overflow: hidden;
        border: 1px solid var(--k-border);
        border-radius: var(--k-radius-xl);
        background: var(--k-surface);
        box-shadow: var(--k-shadow-xl);
    }

    .welcome-portal-brand {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 390px;
        padding: 38px;
        color: #ffffff;
        background: var(--k-navy-gradient);
    }

    .welcome-portal-brand img {
        width: 58px;
        height: 58px;
        margin-bottom: 28px;
        padding: 8px;
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: var(--k-radius-md);
        background: rgba(255, 255, 255, .12);
        object-fit: contain;
    }

    .welcome-portal-brand small {
        color: rgba(255, 255, 255, .7);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .welcome-portal-brand h1 {
        margin: 10px 0;
        color: #ffffff;
        font-size: 26px;
        font-weight: 800;
        line-height: 1.3;
    }

    .welcome-portal-brand p {
        margin: 0;
        color: rgba(255, 255, 255, .76);
        font-size: 13px;
        line-height: 1.7;
    }

    .welcome-portal-copy {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        padding: 48px;
    }

    .welcome-portal-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 16px;
        padding: 5px 11px;
        border: 1px solid var(--k-primary-border);
        border-radius: var(--k-radius-full);
        color: var(--k-primary);
        background: var(--k-primary-light);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .welcome-portal-copy h2 {
        margin: 0 0 10px;
        color: var(--k-text-main);
        font-size: 23px;
        font-weight: 800;
    }

    .welcome-portal-copy p {
        margin: 0 0 24px;
        color: var(--k-text-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .welcome-portal-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    @media (max-width: 767.98px) {
        .welcome-portal-card {
            grid-template-columns: 1fr;
        }

        .welcome-portal-brand {
            min-height: 0;
            padding: 28px;
        }

        .welcome-portal-brand img {
            width: 48px;
            height: 48px;
            margin-bottom: 20px;
        }

        .welcome-portal-brand h1 {
            font-size: 22px;
        }

        .welcome-portal-copy {
            padding: 30px 28px;
        }
    }
</style>
@endsection

@section('content')
<main class="welcome-portal">
    <div class="welcome-portal-card">
        <section class="welcome-portal-brand">
            <div>
                <img src="{{ asset('images/logo-kopkar.png') }}" alt="Logo Koperasi">
                <small>Sistem Informasi Koperasi</small>
                <h1>KOPERASI PRIMKOPPOL MITRA MAJU JAYA</h1>
                <p>Portal terpadu untuk layanan dan pengelolaan koperasi yang aman, transparan, dan mudah diakses.</p>
            </div>
            <small>&copy; {{ date('Y') }} Koperasi Karyawan</small>
        </section>

        <section class="welcome-portal-copy">
            <span class="welcome-portal-badge">
                <i class="mdi mdi-shield" aria-hidden="true"></i>
                Portal Koperasi Terpadu
            </span>
            <h2>Selamat datang</h2>
            <p>Masuk ke portal untuk mengakses informasi anggota, transaksi simpan pinjam, dan layanan koperasi.</p>
            <div class="welcome-portal-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="mdi mdi-login" aria-hidden="true"></i> Masuk ke Portal
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-account-plus" aria-hidden="true"></i> Daftar Anggota
                    </a>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection
