<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductSnapshotsToTransaksiPinjaman extends Migration
{
    public function up()
    {
        Schema::table('transaksi_pinjamen', function (Blueprint $table) {
            $table->unsignedBigInteger('produk_pinjaman_id')->nullable()->after('lama_cicilan');
            $table->string('produk_pinjaman_nama')->nullable()->after('produk_pinjaman_id');
            $table->decimal('bunga_persen', 5, 2)->default(1)->after('produk_pinjaman_nama');
            $table->decimal('tabungan_persen', 5, 2)->default(0.5)->after('bunga_persen');
            $table->foreign('produk_pinjaman_id')
                ->references('id')
                ->on('produk_pinjaman')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transaksi_pinjamen', function (Blueprint $table) {
            $table->dropForeign(['produk_pinjaman_id']);
            $table->dropColumn([
                'produk_pinjaman_id',
                'produk_pinjaman_nama',
                'bunga_persen',
                'tabungan_persen',
            ]);
        });
    }
}
