<?php

use App\Models\FlightType;
use Illuminate\Database\Seeder;

class FlightTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FlightType::query()->create([
            'title' => 'Gyrocopter',
        ]);

        FlightType::query()->create([
            'title' => 'Helicopter',
        ]);

        FlightType::query()->create([
            'title' => 'Landplane',
        ]);
    }
}
