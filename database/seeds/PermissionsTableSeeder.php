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

        // instructors management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Instructors',
            'slug' => 'instructors',
            'description' => 'Manage Instructors',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create instructors',
                'slug' => 'instructors.create',
                'description' => 'Create instructors',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update instructors',
                'slug' => 'instructors.update',
                'description' => 'Update instructors',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View instructors',
                'slug' => 'instructors.view',
                'description' => 'View instructors',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete instructors',
                'slug' => 'instructors.delete',
                'description' => 'Delete instructors',
            ]);
        }

        // students management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Students',
            'slug' => 'students',
            'description' => 'Manage Students',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create students',
                'slug' => 'students.create',
                'description' => 'Create students',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update students',
                'slug' => 'students.update',
                'description' => 'Update students',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View students',
                'slug' => 'students.view',
                'description' => 'View students',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete students',
                'slug' => 'students.delete',
                'description' => 'Delete students',
            ]);
        }

        // levels management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Levels',
            'slug' => 'levels',
            'description' => 'Manage Levels',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create levels',
                'slug' => 'levels.create',
                'description' => 'Create levels',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update levels',
                'slug' => 'levels.update',
                'description' => 'Update levels',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View levels',
                'slug' => 'levels.view',
                'description' => 'View levels',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete levels',
                'slug' => 'levels.delete',
                'description' => 'Delete levels',
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

        // module topics management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Module Topics',
            'slug' => 'topics',
            'description' => 'Manage Module Topics',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create module topics',
                'slug' => 'topics.create',
                'description' => 'Create module topics',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update module topics',
                'slug' => 'topics.update',
                'description' => 'Update module topics',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View module topics',
                'slug' => 'topics.view',
                'description' => 'View module topics',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete module topics',
                'slug' => 'topics.delete',
                'description' => 'Delete module topics',
            ]);
        }

        // course live-classes management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Live Classes',
            'slug' => 'live-classes',
            'description' => 'Manage Live Classes',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create live classes',
                'slug' => 'live-classes.create',
                'description' => 'Create live classes',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update live classes',
                'slug' => 'live-classes.update',
                'description' => 'Update live classes',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View live classes',
                'slug' => 'live-classes.view',
                'description' => 'View live classes',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete live classes',
                'slug' => 'live-classes.delete',
                'description' => 'Delete live classes',
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

        // enrollments management permissions
        if ($perm = Permission::query()->create([
            'name' => 'Manage Enrollments',
            'slug' => 'enrollments',
            'description' => 'Manage Enrollments',
        ]))
        {
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Create enrollments',
                'slug' => 'enrollments.create',
                'description' => 'Create enrollments',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Update enrollments',
                'slug' => 'enrollments.update',
                'description' => 'Update enrollments',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'View enrollments',
                'slug' => 'enrollments.view',
                'description' => 'View enrollments',
            ]);
            Permission::query()->create([
                'parent_id' => $perm->id,
                'name' => 'Delete enrollments',
                'slug' => 'enrollments.delete',
                'description' => 'Delete enrollments',
            ]);
        }

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
    }
}
