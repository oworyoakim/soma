<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($role = Sentinel::getRoleRepository()->findBySlug('admin')){
            $credentials = [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@soma.kim',
                'password' => 'admin',
                'avatar' => '/images/avatar.png',
                'permissions' => [
                    'dashboard' => true,
                    'settings' => true,
                    'users' => true,
                    'users.view' => true,
                    'users.create' => true,
                    'users.update' => true,
                    'users.delete' => true,
                    'users.roles' => true,
                ],
            ];
            $user = Sentinel::registerAndActivate($credentials);
            $user->roles()->attach($role);
        }
    }
}
