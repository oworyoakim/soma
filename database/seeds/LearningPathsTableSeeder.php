<?php

use App\Models\LearningPath;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LearningPathsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $paths = [
            "Primary",
            "Lower Secondary",
            "Upper Secondary"
        ];
        foreach ($paths as $title)
        {
            LearningPath::query()->updateOrCreate([
                'title' => $title,
                'slug' => Str::slug($title),
            ]);
        }
    }
}
