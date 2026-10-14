<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RemovePengajuanPinjamanKreditPermissions extends Migration
{
    private $permissionNames = [
        'view-pengajuan-pinjaman-kredit',
        'create-pengajuan-pinjaman-kredit',
        'approve-pengajuan-pinjaman-admin',
        'approve-pengajuan-pinjaman-bendahara',
        'approve-pengajuan-pinjaman-ketua',
    ];

    public function up()
    {
        $permissionIds = DB::table('permissions')
            ->whereIn('name', $this->permissionNames)
            ->pluck('id');

        $roleIds = DB::table('permission_role')
            ->whereIn('permission_id', $permissionIds)
            ->distinct()
            ->pluck('role_id');

        DB::table('permission_role')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('permissions')->whereIn('id', $permissionIds)->delete();

        $moduleId = DB::table('modules')
            ->where('name', 'Module Pengajuan Pinjaman Kredit')
            ->value('id');
        if ($moduleId && !DB::table('permissions')->where('module_id', $moduleId)->exists()) {
            DB::table('modules')->where('id', $moduleId)->delete();
        }

        foreach ($roleIds as $roleId) {
            Cache::forget('laratrust_permissions_for_role_' . $roleId);
        }
    }

    public function down()
    {
        $now = now();
        $moduleId = DB::table('modules')
            ->where('name', 'Module Pengajuan Pinjaman Kredit')
            ->value('id');
        if (!$moduleId) {
            $moduleId = DB::table('modules')->insertGetId([
                'name' => 'Module Pengajuan Pinjaman Kredit',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($this->permissionNames as $permissionName) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permissionName],
                [
                    'display_name' => $permissionName,
                    'description' => $permissionName,
                    'module_id' => $moduleId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $rolePermissions = [
            'admin' => [
                'view-pengajuan-pinjaman-kredit',
                'approve-pengajuan-pinjaman-admin',
            ],
            'member' => [
                'view-pengajuan-pinjaman-kredit',
                'create-pengajuan-pinjaman-kredit',
            ],
            'bendahara' => [
                'view-pengajuan-pinjaman-kredit',
                'approve-pengajuan-pinjaman-bendahara',
            ],
            'ketua' => [
                'view-pengajuan-pinjaman-kredit',
                'approve-pengajuan-pinjaman-ketua',
            ],
            'ketua koperasi' => [
                'view-pengajuan-pinjaman-kredit',
                'approve-pengajuan-pinjaman-ketua',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = DB::table('roles')->whereRaw('LOWER(name) = ?', [$roleName])->first();
            if (!$role) {
                continue;
            }

            foreach ($permissionNames as $permissionName) {
                $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');
                DB::table('permission_role')->insertOrIgnore([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }

            Cache::forget('laratrust_permissions_for_role_' . $role->id);
        }
    }
}
