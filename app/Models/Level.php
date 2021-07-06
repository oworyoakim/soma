<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Level
 * The level of study of a given learner
 * Examples: S.1, S.2, S.3, S.4, Year 1, Year 2, Year 3, Year 4, etc
 * @package App\Models
 * @property int id
 * @property string title
 * @property string slug
 * @property int learningPathId
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Level extends Model
{

    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class, 'learningPathId');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'level_id');
    }

    /**
     * @return stdClass
     */
    public function getDetails()
    {
        $level = new stdClass();
        $level->id = $this->id;
        $level->title = $this->title;
        $level->slug = $this->slug;
        $level->learningPathId = $this->learningPathId;
        $level->numberOfCourses = $this->courses()->count();
        $level->learningPath = null;
        if ($this->learningPath)
        {
            $level->learningPath = $this->learningPath->getDetails();
        }
        return $level;
    }
}
