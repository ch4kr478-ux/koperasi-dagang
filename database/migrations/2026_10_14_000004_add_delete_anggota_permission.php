<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDeleteAnggotaPermission extends Migration
{
    public function up()
    {
        $now = now();
        $moduleId = DB::table('modules')->where('name', 'Module Anggota')->value('id');

        if (!$moduleId) {
            $moduleId = DB::table('modules')->insertGetId([
                'name' => 'Module Anggota',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('permissions')->updateOrInsert(
            ['name' => 'delete-anggota'],
            [
                'display_name' => 'Hapus Anggota',
                'description' => 'Bisa Menghapus Anggota',
                'module_id' => $moduleId,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $adminRoleId = DB::table('roles')->whereRaw('LOWER(name) = ?', ['admin'])->value('id');
        $permissionId = DB::table('permissions')->where('name', 'delete-anggota')->value('id');

        if ($adminRoleId) {
            DB::table('permission_role')->insertOrIgnore([
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
            ]);
        }
    }

    public function down()
    {
        $permissionId = DB::table('permissions')->where('name', 'delete-anggota')->value('id');

        if ($permissionId) {
            DB::table('permission_role')->where('permission_id', $permissionId)->delete();
            DB::table('permission_user')->where('permission_id', $permissionId)->delete();
            DB::table('permissions')->where('id', $permissionId)->delete();
        }
    }
}
