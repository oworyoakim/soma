<?php

use App\Models\FlightType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        //$this->call(FlightTypesTableSeeder::class);
        //$this->call(RolesTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        //$this->call(CoursesTableSeeder::class);
        //$this->call(SettingsTableSeeder::class);
    }
}
