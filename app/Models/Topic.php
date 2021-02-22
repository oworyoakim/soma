<?php

namespace App\Models;

use stdClass;

/**
 * Class Topic
 * @package App\Models
 * @property int id
 * @property int module_id
 * @property string title
 * @property string description
 * @property string body
 * @property int created_by
 */
class Topic extends Model
{
    protected $table = 'topics';

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'topic_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'topic_id');
    }

    /**
     * @param bool $withRelations
     *
     * @return stdClass
     */
    public function getDetails($withRelations = false)
    {
        $topic = new stdClass();
        $topic->id = $this->id;
        $topic->title = $this->title;
        $topic->description = $this->description;
        $topic->body = $this->body;
        $topic->moduleId = $this->module_id;
        if ($withRelations)
        {
            $topic->questions = $this->questions()
                                     ->get()
                                     ->map(function (Question $question) {
                                         return $question->getDetails();
                                     });
            $topic->numQuestions = $topic->questions->count();
        } else
        {
            $topic->questions = [];
            $topic->numQuestions = $this->questions()->count();
        }


        $topic->classroom = null;

        return $topic;
    }
}
