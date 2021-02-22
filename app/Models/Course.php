<?php

namespace App\Models;

use stdClass;

/**
 * Class Course
 * @package App\Models
 * @property int id
 * @property string code
 * @property string title
 * @property string slug
 * @property string description
 * @property int weight
 * @property int duration
 * @property string thumbnail
 * @property int level_id
 */
class Course extends Model
{
    protected $table = 'courses';

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_courses', 'course_id', 'program_id')->withTimestamps();
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    /**
     * @param bool $withRelations
     *
     * @return stdClass
     */
    public function getDetails($withRelations = false)
    {
        $course = new stdClass();
        $course->id = $this->id;
        $course->code = $this->code;
        $course->slug = $this->slug;
        $course->title = $this->title;
        $course->description = $this->description;
        $course->duration = $this->duration;
        $course->weight = $this->weight;
        $course->thumbnail = $this->thumbnail;
        $course->levelId = $this->level_id;
        $course->level = !empty($this->level) ? $this->level->getDetails() : null;

        $course->canTakeExam = false;

        if ($withRelations)
        {
            $course->programs = $this->programs()
                                     ->get()
                                     ->map(function (Program $program) {
                                         return $program->getDetails();
                                     });
            $course->programIds = $course->programs->pluck('id')->all();

            $course->modules = $this->modules()
                                    ->get()
                                    ->map(function (Module $module) {
                                        return $module->getDetails();
                                    });
            $course->numModules = $course->modules->count();
        } else
        {
            $course->programIds = $this->programs()->get()->pluck('id')->all();
            $course->programs = [];
            $course->modules = [];
            $course->numModules = $this->modules()->count();
        }

        return $course;
    }
}
