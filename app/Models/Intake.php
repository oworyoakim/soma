<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Intake
 * The intake for a given level of study of a given learner
 * Examples: Term 1, Term 2, Term 3, Semester 1, Semester 2, Recess 1, Recess 2, etc
 * @package App\Models
 * @property int id
 * @property string title
 * @property string slug
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

    public function getDetails($expanded = false)
    {
        $intake = new stdClass();

        $intake->id = $this->id;
        $intake->title = $this->title;
        $intake->slug = $this->slug;
        $intake->numberOfEnrollments = $this->enrollments()->count();
        return $intake;
    }
}
