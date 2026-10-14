<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNominalToProdukPinjaman extends Migration
{
    public function up()
    {
        Schema::table('produk_pinjaman', function (Blueprint $table) {
            $table->unsignedBigInteger('nominal')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('produk_pinjaman', function (Blueprint $table) {
            $table->dropColumn('nominal');
        });
    }
}
