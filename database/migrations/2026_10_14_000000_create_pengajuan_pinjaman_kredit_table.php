<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanPinjamanKreditTable extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_pinjaman_kredit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('anggota_id');
            $table->decimal('nominal', 10, 0);
            $table->unsignedInteger('lama_cicilan');
            $table->text('keterangan')->nullable();
            $table->string('status', 32)->default('menunggu_admin');
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->text('admin_catatan')->nullable();
            $table->timestamp('admin_diproses_pada')->nullable();
            $table->unsignedBigInteger('bendahara_user_id')->nullable();
            $table->text('bendahara_catatan')->nullable();
            $table->timestamp('bendahara_diproses_pada')->nullable();
            $table->unsignedBigInteger('ketua_user_id')->nullable();
            $table->text('ketua_catatan')->nullable();
            $table->timestamp('ketua_diproses_pada')->nullable();
            $table->unsignedInteger('jenis_pembayaran')->nullable();
            $table->date('tgl_pencairan')->nullable();
            $table->unsignedBigInteger('transaksi_harian_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('anggota_id')->references('id')->on('anggotas');
            $table->foreign('admin_user_id')->references('id')->on('users');
            $table->foreign('bendahara_user_id')->references('id')->on('users');
            $table->foreign('ketua_user_id')->references('id')->on('users');
            $table->foreign('transaksi_harian_id')->references('id')->on('transaksi_harians');
            $table->index(['status', 'created_at']);
        });

        $now = now();
        $moduleId = DB::table('modules')->where('name', 'Module Pengajuan Pinjaman Kredit')->value('id');
        if (!$moduleId) {
            $moduleId = DB::table('modules')->insertGetId([
                'name' => 'Module Pengajuan Pinjaman Kredit',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $permissions = [
            'view-pengajuan-pinjaman-kredit' => 'Melihat Pengajuan Pinjaman Kredit',
            'create-pengajuan-pinjaman-kredit' => 'Membuat Pengajuan Pinjaman Kredit',
            'approve-pengajuan-pinjaman-admin' => 'Menyetujui Pengajuan Pinjaman Kredit (Admin)',
            'approve-pengajuan-pinjaman-bendahara' => 'Menyetujui Pengajuan Pinjaman Kredit (Bendahara)',
            'approve-pengajuan-pinjaman-ketua' => 'Menyetujui Pengajuan Pinjaman Kredit (Ketua)',
        ];

        foreach ($permissions as $name => $displayName) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                [
                    'display_name' => $displayName,
                    'description' => $displayName,
                    'module_id' => $moduleId,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        $rolePermissions = [
            'member' => ['view-pengajuan-pinjaman-kredit', 'create-pengajuan-pinjaman-kredit'],
            'admin' => ['view-pengajuan-pinjaman-kredit', 'approve-pengajuan-pinjaman-admin'],
            'bendahara' => ['view-pengajuan-pinjaman-kredit', 'approve-pengajuan-pinjaman-bendahara'],
            'ketua' => ['view-pengajuan-pinjaman-kredit', 'approve-pengajuan-pinjaman-ketua'],
        ];

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = DB::table('roles')->whereRaw('LOWER(name) = ?', [$roleName])->first();
            if (!$role && $roleName === 'ketua') {
                $roleId = DB::table('roles')->insertGetId([
                    'name' => 'ketua',
                    'display_name' => 'Ketua',
                    'description' => 'Role Ketua',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } elseif ($role) {
                $roleId = $role->id;
            } else {
                continue;
            }

            foreach ($permissionNames as $permissionName) {
                $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');
                DB::table('permission_role')->insertOrIgnore([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_pinjaman_kredit');

        $permissionNames = [
            'view-pengajuan-pinjaman-kredit',
            'create-pengajuan-pinjaman-kredit',
            'approve-pengajuan-pinjaman-admin',
            'approve-pengajuan-pinjaman-bendahara',
            'approve-pengajuan-pinjaman-ketua',
        ];

        $permissionIds = DB::table('permissions')->whereIn('name', $permissionNames)->pluck('id');
        DB::table('permission_role')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permissions')->whereIn('id', $permissionIds)->delete();
        DB::table('modules')->where('name', 'Module Pengajuan Pinjaman Kredit')->delete();
    }
}
