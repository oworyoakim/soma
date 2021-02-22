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

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'student_id');
    }

    public function getInfo($withRelations = true)
    {
        $student = parent::getInfo($withRelations);
        $student->enrollNumber = $this->enroll_number;
        unset($student->role);
        $enrollments = $this->enrollments()->get();
        $student->numberOfEnrollments = $enrollments->count();
        $student->programsEnrolled = $enrollments->pluck('program_id')->all();
        $student->numberOfExams = 0;
        return $student;
    }

    /**
     * @param $programId
     *
     * @return bool
     */
    public function isEligibleFor($programId)
    {
        // Todo: Check if the student has already taken and passed the prerequisites of this program
        return true;
    }

    public function myPrograms()
    {
        $programIds = $this->enrollments()->pluck('program_id')->all();
        $programs = Program::query()
                         ->whereIn('id', $programIds)
                         ->get()
                         ->map(function (Program $program) {
                             return $program->getDetails();
                         });
        return $programs;
    }

    public function myCourses()
    {
        $enrollment = $this->enrollments()->active()->first();
        if (!$enrollment)
        {
            throw new Exception('No active enrollments!');
        }
        $courseIds = ProgramCourse::query()
                                  ->where('program_id', $enrollment->program_id)
                                  ->pluck('course_id')
                                  ->all();
        $courses = Course::query()
                         ->whereIn('id', $courseIds)
                         ->get()
                         ->map(function (Course $course) {
                             return $course->getDetails();
                         });
        return $courses;
    }

}
