<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Exam
 * @package App\Models
 * @property int id
 * @property int code
 * @property int intake_id
 * @property int course_id
 * @property int duration
 * @property int num_questions
 * @property float pass_score
 * @property string instructions
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Exam extends Model
{
    protected $table = 'exams';

    public function scopeActive(Builder $query)
{
    return $query->where('active', true);
}

    public function scopeInactive(Builder $query)
    {
        return $query->where('active', false);
    }
}
