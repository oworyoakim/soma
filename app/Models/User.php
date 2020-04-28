<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use stdClass;

class User extends EloquentUser
{
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'last_login',
        'avatar',
    ];

    protected $loginNames = ['email', 'username'];

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getInfo()
    {
        $user = new stdClass();
        $user->id = $this->id;
        $user->firstName = $this->first_name;
        $user->lastName = $this->last_name;
        $user->email = $this->email;
        $user->username = $this->username;
        $user->avatar = $this->avatar;
        $user->role = null;
        if ($role = $this->roles()->first())
        {
            $user->role = new stdClass();
            $user->role->id = $role->id;
            $user->role->name = $role->name;
            $user->role->slug = $role->slug;
            $user->role->permissions = $role->permissions;
        }
        return $user;
    }

}
