<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * Class Intake
 * @package App\Models
 * @property int id
 * @property string title
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Intake extends Model
{
    protected $table = 'intakes';

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'intake_id');
    }
}
