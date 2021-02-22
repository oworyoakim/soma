<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class ProgramCourse
 * @package App\Models
 * @property int id
 * @property int program_id
 * @property int course_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class ProgramCourse extends Model
{

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
