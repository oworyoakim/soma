<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Enrollment
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int intake_id
 * @property int student_number
 * @property Carbon enroll_date
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $dates = ['enroll_date','deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive(Builder $query)
    {
        return $query->where('active', false);
    }
}
