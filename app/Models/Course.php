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
 * @property string outline
 * @property string outcome
 * @property int weight
 * @property int duration
 * @property string thumbnail
 */
class Course extends Model
{
    protected $table = 'courses';

    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return stdClass
     */
    public function getDetails()
    {
        $course = new stdClass();
        $course->id = $this->id;
        $course->code = $this->code;
        $course->slug = $this->slug;
        $course->title = $this->title;
        $course->description = $this->description;
        $course->outline = $this->outline;
        $course->outcome = $this->outcome;
        $course->duration = $this->duration;
        $course->weight = $this->weight;
        $course->thumbnail = $this->thumbnail;
        $course->canTakeExam = true;

        $course->modules = $this->modules()
                                ->get()
                                ->map(function (Module $module) {
                                    return $module->getDetails();
                                });
        $course->numModules = $course->modules->count();

        return $course;
    }
}
