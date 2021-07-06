<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Enrollment
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int student_id
 * @property int course_id
 * @property string|integer enroll_number
 * @property Carbon enroll_date
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $dates = ['enroll_date', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive(Builder $query)
    {
        return $query->where('active', false);
    }

    public function getDetails()
    {
        $enrollment = new stdClass();
        $enrollment->id = $this->id;
        $enrollment->userId = $this->user_id;
        $enrollment->studentId = $this->student_id;
        $enrollment->courseId = $this->course_id;
        $enrollment->enrollNumber = $this->enroll_number;
        $enrollment->enrollDate = $this->enroll_date->toDateString();
        $enrollment->active = !!$this->active;
        $enrollment->course = null;
        $enrollment->student = null;
        if ($this->student)
        {
            $enrollment->student = $this->student->getInfo(false);
        }

        if ($this->course)
        {
            $enrollment->course = $this->course->getDetails();
        }
        return $enrollment;
    }
}
