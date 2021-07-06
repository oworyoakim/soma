<?php

namespace App\Models;

use stdClass;

/**
 * Class LearningPath
 * @package App\Models
 * @property int id
 * @property string title
 * @property string slug
 */
class LearningPath extends Model
{
    protected $table = "learning_paths";

    public function levels()
    {
        return $this->hasMany(Level::class, 'learningPathId');
    }

    public function getDetails()
    {
        $learningPath = new stdClass;
        $learningPath->id = $this->id;
        $learningPath->title = $this->title;
        $learningPath->slug = $this->slug;
        return $learningPath;
    }

    public function getInfoForHomePage(){
        $learningPath = $this->getDetails();
        // fetch statistics about this learning path
        $levels = $this->levels()->get();
        // number of levels
        $learningPath->numberOfLevels = $levels->count();
        $learningPath->numberOfCourses = $levels->reduce(function ($count, Level $level){
            return $count + $level->courses()->count();
        }, 0);
        $learningPath->numberOfLessons = 0;
        return $learningPath;
    }
}
