<?php

use App\Models\Course;
use App\Models\Module;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Course::query()->truncate();
        Module::query()->truncate();
        Topic::query()->truncate();
        Question::query()->truncate();
        factory(Course::class, 2)->create()->each(function (Course $course) {
            $course->modules()->saveMany(factory(Module::class, random_int(4, 10))->make());
            $course->modules()->get()->each(function (Module $module) {
                $module->topics()->saveMany(factory(Topic::class, random_int(4, 15))->make());
                $module->topics()->get()->each(function (Topic $topic) {
                    $topic->questions()->saveMany(factory(Question::class, random_int(4, 10))->make(['module_id' => $topic->module_id]));
                });
            });
        });
    }
}
