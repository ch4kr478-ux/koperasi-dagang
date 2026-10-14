<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RefreshPengajuanPinjamanKreditRolePermissions extends Migration
{
    public function up()
    {
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
                if (!$permissionId) {
                    throw new RuntimeException('Pengajuan Pinjaman Kredit permission is missing: ' . $permissionName);
                }

                DB::table('permission_role')->insertOrIgnore([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }

            Cache::forget('laratrust_permissions_for_role_' . $role->id);
        }
    }

    public function down()
    {
        // Keep grants in place so rolling back this cache refresh cannot revoke access.
    }
}
