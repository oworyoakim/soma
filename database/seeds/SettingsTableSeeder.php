<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       Setting::set('company_name', 'SOMA');
       Setting::set('company_email', 'admin@soma.kim');
       Setting::set('maximum_classroom_duration', 30);
    }
}
