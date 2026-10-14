<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukPinjamanTables extends Migration
{
    public function up()
    {
        Schema::create('produk_pinjaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('produk_pinjaman_tenors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produk_pinjaman_id');
            $table->unsignedInteger('lama_cicilan');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('produk_pinjaman_id')
                ->references('id')
                ->on('produk_pinjaman')
                ->onDelete('cascade');
            $table->unique(['produk_pinjaman_id', 'lama_cicilan']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk_pinjaman_tenors');
        Schema::dropIfExists('produk_pinjaman');
    }
}
