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
                'email' => 'admin@exam.dev',
                'password' => 'admin',
                'avatar' => '/images/avatar.png',
            ];
            $user = Sentinel::registerAndActivate($credentials);
            $user->roles()->attach($role);
        }
    }
}
