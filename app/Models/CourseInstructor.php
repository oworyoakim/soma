<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseInstructor
 * @package App\Models
 * @property int course_id
 * @property int instructor_id
 */
class CourseInstructor extends Model
{
    protected $table = "course_instructors";

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
}
