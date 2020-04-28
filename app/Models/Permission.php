<?php

namespace App\Models;

use stdClass;

class Permission extends Model
{
    protected $table = 'permissions';

    public function getDetails()
    {
        $permission = new stdClass();
        $permission->id = $this->id;
        $permission->name = $this->name;
        $permission->slug = $this->slug;
        $permission->description = $this->description;
        $permission->parentId = $this->parent_id;

        return $permission;
    }
}
