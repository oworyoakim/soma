<?php

namespace App\Models;

use App\Models\Scopes\StudentScope;
use Exception;

class Student extends User
{
    public function __construct(array $attributes = [])
    {
        // add fillables
        $this->fillable = array_merge($this->fillable, ['enroll_number',]);
        parent::__construct($attributes);
    }

    protected static function booted()
    {
        static::addGlobalScope(new StudentScope);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function getInfo($withRelations = true)
    {
        $student = parent::getInfo($withRelations);
        $student->enrollNumber = $this->enroll_number;
        unset($student->role);
        $enrollments = $this->enrollments()->get();
        $student->numberOfEnrollments = $enrollments->count();
        $student->coursesEnrolled = $enrollments->pluck('course_id')->all();
        $student->numberOfExams = 0;
        return $student;
    }

    /**
     * @param $programId
     *
     * @return bool
     */
    public function isEligibleFor($courseId)
    {
        // Todo: Check if the student has already taken and passed the prerequisites of this course
        return true;
    }

    public function myCourses()
    {
        $enrollment = $this->enrollments()->active()->first();
        if (!$enrollment)
        {
            throw new Exception('No active enrollments!');
        }
        $courseIds = $this->enrollments()->pluck('course_id')->all();
        $courses = Course::query()
                         ->whereIn('id', $courseIds)
                         ->get()
                         ->map(function (Course $course) {
                             return $course->getDetails();
                         });
        return $courses;
    }

    /**
     * @param $courseId
     *
     * @return bool
     */
    public function hasEnrolledFor($courseId) : bool
    {
        $numEnrollments = $this->enrollments()->where(['course_id' => $courseId])->count();
        return $numEnrollments > 0;
    }

}
