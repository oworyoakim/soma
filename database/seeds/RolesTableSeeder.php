<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [],
        ]);
        Role::query()->create([
            'name' => 'Instructor',
            'slug' => 'instructor',
            'permissions' => [],
        ]);
        Role::query()->create([
            'name' => 'Student',
            'slug' => 'student',
            'permissions' => [],
        ]);
    }
}
