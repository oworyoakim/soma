<?php

namespace App\Models;

use App\Models\Scopes\InstructorScope;

class Instructor extends User
{

    protected static function booted()
    {
        static::addGlobalScope(new InstructorScope);
    }

    public function getInfo($withRelations = true)
    {
        $instructor = parent::getInfo($withRelations);
        unset($instructor->role);
        return $instructor;
    }

}
