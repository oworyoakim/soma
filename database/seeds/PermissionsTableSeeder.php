<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()->truncate();
        Permission::query()->create([
            'name' => 'Manage Settings',
            'slug' => 'settings',
            'description' => 'Manage Settings',
        ]);
        Permission::query()->create([
            'name' => 'Dashboard',
            'slug' => 'dashboard',
            'description' => 'Dashboard',
        ]);

        // user management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Users',
            'slug' => 'users',
            'description' => 'Manage Users',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create Users',
                'slug' => 'users.create',
                'description' => 'Create Users',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update Users',
                'slug' => 'users.update',
                'description' => 'Update Users',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View Users',
                'slug' => 'users.view',
                'description' => 'View Users',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete Users',
                'slug' => 'users.delete',
                'description' => 'Delete Users',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Manage Roles',
                'slug' => 'users.roles',
                'description' => 'Manage Roles',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Manage Role Permissions',
                'slug' => 'users.roles.permissions',
                'description' => 'Manage Role Permissions',
            ]);
        }

        // courses management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Courses',
            'slug' => 'courses',
            'description' => 'Manage Courses',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create courses',
                'slug' => 'courses.create',
                'description' => 'Create courses',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update courses',
                'slug' => 'courses.update',
                'description' => 'Update courses',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View courses',
                'slug' => 'courses.view',
                'description' => 'View courses',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete courses',
                'slug' => 'courses.delete',
                'description' => 'Delete courses',
            ]);
        }

        // course modules management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Course Modules',
            'slug' => 'modules',
            'description' => 'Manage Course Modules',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create course modules',
                'slug' => 'modules.create',
                'description' => 'Create course modules',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update course modules',
                'slug' => 'modules.update',
                'description' => 'Update course modules',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View course modules',
                'slug' => 'modules.view',
                'description' => 'View course modules',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete course modules',
                'slug' => 'modules.delete',
                'description' => 'Delete course modules',
            ]);
        }

        // exams management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage exams',
            'slug' => 'exams',
            'description' => 'Manage exams',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create exams',
                'slug' => 'exams.create',
                'description' => 'Create exams',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update exams',
                'slug' => 'exams.update',
                'description' => 'Update exams',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View exams',
                'slug' => 'exams.view',
                'description' => 'View exams',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete exams',
                'slug' => 'exams.delete',
                'description' => 'Delete exams',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Take exams',
                'slug' => 'exams.take',
                'description' => 'Take exams',
            ]);
        }
    }
}
