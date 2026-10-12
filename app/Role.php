<?php

namespace App;

use Laratrust\Models\Role as LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    public function permission_role()
    {
        return $this->hasMany('App\PermissionRole');
    }
}
