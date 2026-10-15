<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AddSavingAmountsToTransaksiPinjamanCicilansTest extends TestCase
{
    public function test_it_adds_new_saving_amounts_without_changing_existing_rows(): void
    {
        $originalConnection = config('database.default');
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        try {
            Schema::create('transaksi_pinjaman_cicilans', function ($table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tabungan')->default(0);
            });
            DB::table('transaksi_pinjaman_cicilans')->insert(['tabungan' => 25000]);

            $migration = require database_path(
                'migrations/2026_10_15_000003_add_saving_amounts_to_transaksi_pinjaman_cicilans.php'
            );
            $migration->up();

            $this->assertTrue(Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_pokok'));
            $this->assertTrue(Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_sukarela'));
            $this->assertSame(25000, (int) DB::table('transaksi_pinjaman_cicilans')->value('tabungan'));
            $this->assertSame(0, (int) DB::table('transaksi_pinjaman_cicilans')->value('simpanan_pokok'));
            $this->assertSame(0, (int) DB::table('transaksi_pinjaman_cicilans')->value('simpanan_sukarela'));

            $migration->down();
            $this->assertFalse(Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_pokok'));
            $this->assertFalse(Schema::hasColumn('transaksi_pinjaman_cicilans', 'simpanan_sukarela'));
        } finally {
            Schema::dropIfExists('transaksi_pinjaman_cicilans');
            DB::purge('sqlite');
            config(['database.default' => $originalConnection]);
        }
    }
}
