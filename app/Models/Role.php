<?php

namespace App\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Support\Arr;
use stdClass;

class Role extends EloquentRole
{
    protected $guarded = [];

    public function getDetails()
    {
        $role = new stdClass();
        $role->id = $this->id;
        $role->name = $this->name;
        $role->permissions = $this->getPermissions();
        foreach (Permission::all() as $permission)
        {
            if (!array_key_exists($permission->slug, $role->permissions))
            {
                $role->permissions[$permission->slug] = false;
            }
        }

        return $role;
    }
}
