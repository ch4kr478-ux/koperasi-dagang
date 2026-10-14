<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AddProdukPinjamanImportPermissions extends Migration
{
    private $permissions = [
        'download-produk-pinjaman' => ['Mengunduh Template Produk Pinjaman', 'Bisa mengunduh template produk pinjaman'],
        'upload-produk-pinjaman' => ['Mengunggah Produk Pinjaman', 'Bisa mengunggah produk pinjaman dari file Excel'],
    ];

    public function up()
    {
        $now = now();
        $moduleId = DB::table('modules')->where('name', 'Module Produk Pinjaman')->value('id');

        if (!$moduleId) {
            $moduleId = DB::table('modules')->insertGetId([
                'name' => 'Module Produk Pinjaman',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($this->permissions as $name => $labels) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                [
                    'display_name' => $labels[0],
                    'description' => $labels[1],
                    'module_id' => $moduleId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $adminRoleId = DB::table('roles')->whereRaw('LOWER(name) = ?', ['admin'])->value('id');
        if (!$adminRoleId) {
            return;
        }

        foreach (array_keys($this->permissions) as $name) {
            $permissionId = DB::table('permissions')->where('name', $name)->value('id');
            DB::table('permission_role')->insertOrIgnore([
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
            ]);
        }

        Cache::forget('laratrust_permissions_for_role_' . $adminRoleId);
    }

    public function down()
    {
        $permissionIds = DB::table('permissions')
            ->whereIn('name', array_keys($this->permissions))
            ->pluck('id');
        $roleIds = DB::table('permission_role')
            ->whereIn('permission_id', $permissionIds)
            ->distinct()
            ->pluck('role_id');

        DB::table('permission_role')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permission_user')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permissions')->whereIn('id', $permissionIds)->delete();

        foreach ($roleIds as $roleId) {
            Cache::forget('laratrust_permissions_for_role_' . $roleId);
        }
    }
}
