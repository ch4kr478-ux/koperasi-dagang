<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPinjamanCicilanTable extends Migration
{
    private $tableName = 'transaksi_pinjaman_cicilans';

    public function up()
    {
        if (Schema::hasTable($this->tableName)) {
            $this->addMissingUniqueIndexes();

            return;
        }

        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaksi_pinjaman_id');
            $table->unsignedBigInteger('transaksi_harian_id');
            $table->unsignedBigInteger('simpanan_transaksi_harian_id');
            $table->unsignedInteger('angsuran_ke');
            $table->date('jatuh_tempo');
            $table->unsignedBigInteger('pokok');
            $table->unsignedBigInteger('bunga');
            $table->unsignedBigInteger('tabungan');
            $table->timestamps();

            $table->foreign('transaksi_pinjaman_id', 'tpc_loan_fk')
                ->references('id')->on('transaksi_pinjamen')->onDelete('restrict');
            $table->foreign('transaksi_harian_id', 'tpc_payment_fk')
                ->references('id')->on('transaksi_harians')->onDelete('cascade');
            $table->foreign('simpanan_transaksi_harian_id', 'tpc_saving_fk')
                ->references('id')->on('transaksi_harians')->onDelete('restrict');
            $table->unique(['transaksi_pinjaman_id', 'angsuran_ke'], 'tpc_loan_installment_uq');
            $table->unique('transaksi_harian_id', 'tpc_payment_uq');
            $table->unique('simpanan_transaksi_harian_id', 'tpc_saving_uq');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }

    private function addMissingUniqueIndexes()
    {
        $indexes = [
            'tpc_loan_installment_uq' => ['transaksi_pinjaman_id', 'angsuran_ke'],
            'tpc_payment_uq' => ['transaksi_harian_id'],
            'tpc_saving_uq' => ['simpanan_transaksi_harian_id'],
        ];

        foreach ($indexes as $name => $columns) {
            if (!Schema::hasIndex($this->tableName, $name)) {
                Schema::table($this->tableName, function (Blueprint $table) use ($columns, $name) {
                    $table->unique($columns, $name);
                });
            }
        }
    }
}
