<?php

namespace App\Models;

use stdClass;

/**
 * Class Module
 * @package App\Models
 * @property int id
 * @property int course_id
 * @property string title
 * @property string description
 * @property int duration
 * @property int weight
 * @property string outline
 * @property int created_by
 */
class Module extends Model
{
    protected $table = 'modules';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'module_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'module_id');
    }

    /**
     * @return stdClass
     */
    public function getDetails()
    {
        $module = new stdClass();
        $module->id = $this->id;
        $module->title = $this->title;
        $module->description = $this->description;
        $module->outline = $this->outline;
        $module->duration = $this->duration;
        $module->weight = $this->weight;
        $module->courseId = $this->course_id;

        $module->topics = $this->topics()
                               ->get()
                               ->map(function (Topic $topic) {
                                   return $topic->getDetails();
                               });

        $module->numTopics = $module->topics->count();

        $module->questions = $this->questions()
                                 ->get()
                                 ->map(function (Question $question) {
                                     return $question->getDetails();
                                 });
        $module->numQuestions = $module->questions->count();

        return $module;
    }
}
