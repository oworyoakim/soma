<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class User extends EloquentUser
{
    const ACCOUNT_TYPE_ADMINS = 'admins';
    const ACCOUNT_TYPE_INSTRUCTORS = 'instructors';
    const ACCOUNT_TYPE_LEARNERS = 'learners';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'last_login',
        'avatar',
        'group',
    ];

    protected $loginNames = ['email', 'username'];

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeLearners(Builder $query)
    {
        return $query->where('group', self::ACCOUNT_TYPE_LEARNERS);
    }

    public function scopeInstructors(Builder $query)
    {
        return $query->where('group', self::ACCOUNT_TYPE_INSTRUCTORS);
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->where('group', self::ACCOUNT_TYPE_ADMINS);
    }

    public function getInfo($withRelations = true)
    {
        $user = new stdClass();
        $user->id = $this->id;
        $user->firstName = $this->first_name;
        $user->lastName = $this->last_name;
        $user->fullName = $this->fullName();
        $user->email = $this->email;
        $user->username = $this->username;
        $user->avatar = $this->avatar;
        $user->role = null;
        $user->roleId = null;
        if($withRelations){
            if ($role = $this->roles()->first())
            {
                $user->role = new stdClass();
                $user->role->id = $role->id;
                $user->roleId = $role->id;
                $user->role->name = $role->name;
                $user->role->slug = $role->slug;
                $user->role->permissions = $role->permissions;
            }
        }
        return $user;
    }

}
