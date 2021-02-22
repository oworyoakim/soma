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
 * @property int intake_id
 * @property int program_id
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

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
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
        $enrollment->intakeId = $this->intake_id;
        $enrollment->programId = $this->program_id;
        $enrollment->enrollDate = $this->enroll_date->toDateString();
        $enrollment->active = !!$this->active;
        $enrollment->intake = null;
        $enrollment->program = null;
        $enrollment->student = null;
        if ($this->student)
        {
            $enrollment->student = $this->student->getInfo(false);
        }

        if ($this->intake)
        {
            $enrollment->intake = $this->intake->getDetails();
        }
        if ($this->program)
        {
            $enrollment->program = $this->program->getDetails();
        }
        return $enrollment;
    }
}
