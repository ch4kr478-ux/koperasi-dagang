<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_pinjaman_cicilans', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_pokok')) {
                $table->unsignedBigInteger('simpanan_pokok')->default(0);
            }

            if (!Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_sukarela')) {
                $table->unsignedBigInteger('simpanan_sukarela')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_pinjaman_cicilans', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_pokok')) {
                $columns[] = 'simpanan_pokok';
            }
            if (Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_sukarela')) {
                $columns[] = 'simpanan_sukarela';
            }
            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
