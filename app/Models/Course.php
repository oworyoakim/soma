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

    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id');
    }

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'course_instructors', 'course_id', 'instructor_id');
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
        $course->thumbnail = $this->thumbnail;
        $course->duration = $this->duration;
        $course->weight = $this->weight;
        $course->levelId = $this->level_id;
        $course->level = !empty($this->level) ? $this->level->getDetails() : null;

        $course->canTakeExam = false;

        if ($withRelations)
        {
            $course->modules = $this->modules()
                                    ->get()
                                    ->map(function (Module $module) {
                                        return $module->getDetails();
                                    });
            $course->numberOfModules = $course->modules->count();
        } else
        {
            $course->modules = [];
            $course->numberOfModules = $this->modules()->count();
        }

        return $course;
    }

    public function getInfoForHomePage(){

        $course = new stdClass();
        $course->id = $this->id;
        $course->code = $this->code;
        $course->slug = $this->slug;
        $course->title = $this->title;
        $course->description = $this->description;
        $course->thumbnail = $this->thumbnail;
        $course->level = !empty($this->level) ? $this->level->getDetails() : null;
        // fetch statistics about this learning path
        $modules = $this->modules()->get();
        $course->numberOfModules = $modules->count();
        // number of topics
        $course->numberOfTopics = $modules->reduce(function ($count, Module $module) {
            return $count + $module->topics()->count();
        }, 0);
        $course->numberOfEnrollments = $this->enrollments()->count();
        return $course;
    }
}
