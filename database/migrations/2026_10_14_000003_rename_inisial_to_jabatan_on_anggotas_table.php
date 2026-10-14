<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
        });

        DB::table('anggotas')->update(['jabatan' => DB::raw('inisial')]);

        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn('inisial');
        });
    }

    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('inisial')->nullable();
        });

        DB::table('anggotas')->update(['inisial' => DB::raw('jabatan')]);

        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });
    }
};
