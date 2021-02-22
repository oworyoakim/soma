<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Program
 * The program of study of a given learner
 * Examples: BA, MBA, CPL, FPO, PPL, ATPL, FI, MSc Computer Science, MSc Software Engineering, etc
 * @package App\Models
 * @property int id
 * @property string title
 * @property string slug
 * @property string description
 * @property string requirements
 * @property int duration
 * @property int age_limit
 * @property int pass_mark
 * @property string prerequisites
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Program extends Model
{
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'program_courses', 'program_id', 'course_id')->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'program_id');
    }

    /**
     * @return stdClass
     */
    public function getDetails()
    {
        $program = new stdClass();
        $program->id = $this->id;
        $program->title = $this->title;
        $program->slug = $this->slug;
        $program->description = $this->description;
        $program->requirements = $this->requirements;
        $program->duration = $this->duration;
        $program->ageLimit = $this->age_limit;
        $program->passMark = $this->pass_mark;
        $program->numCourses = $this->courses()->count();
        $program->numberEnrolled = $this->enrollments()->count();
        $program->courseIds = $this->courses()->pluck('course_id')->all();
        $program->prerequisiteIds = !empty($this->prerequisites) ? unserialize($this->prerequisites) : [];
        $program->prerequisites = $this->newQuery()
                                       ->whereIn('id', $program->prerequisiteIds)
                                       ->get()
                                       ->map(function (Program $program) {
                                           return $program->getDetails();
                                       });
        return $program;
    }
}
