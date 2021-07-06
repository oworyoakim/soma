<?php

namespace App\Models;

use App\Models\Scopes\InstructorScope;

class Instructor extends User
{

    protected static function booted()
    {
        static::addGlobalScope(new InstructorScope);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_instructors', 'instructor_id', 'course_id');
    }

    public function getInfo($withRelations = true)
    {
        $instructor = parent::getInfo($withRelations);
        unset($instructor->role);
        return $instructor;
    }

}
