Aplikasi Koperasi Karyawan

## Instalasi

Persyaratan: PHP 8.2 atau lebih baru dalam rentang yang didukung Composer, serta Composer.

```sh
composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di `.env`, lalu jalankan migrasi dengan `php artisan migrate`.
