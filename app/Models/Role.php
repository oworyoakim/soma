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
        $role->permissions = array_keys($this->getPermissions());

        return $role;
    }
}
