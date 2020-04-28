<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use stdClass;

/**
 * Class Question
 * @package App\Models
 * @property int id
 * @property int topic_id
 * @property string title
 * @property string description
 * @property int weight
 * @property string type
 * @property bool active
 * @property int created_by
 */
class Question extends Model
{
    protected $table = 'questions';

    const TYPE_REVISION = 'revision';
    const TYPE_EXAM = 'exam';
    const TYPE_BOTH = 'both';

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function scopeExaminable(Builder $builder)
    {
        return $builder->whereIn('type', [self::TYPE_EXAM, self::TYPE_BOTH]);
    }

    public function scopeRevisable(Builder $builder)
    {
        return $builder->whereIn('type', [self::TYPE_REVISION, self::TYPE_BOTH]);
    }

    /**
     * @return stdClass
     */
    public function getDetails()
    {
        $question = new stdClass();
        $question->id = $this->id;
        $question->title = $this->title;
        $question->description = $this->description;
        $question->active = !!$this->active;
        $question->weight = $this->weight;
        $question->topicId = $this->topic_id;
        $question->topic = ($this->topic) ? $this->topic->getDetails() : null;

        $question->answers = $this->answers()
                                  ->get()
                                  ->map(function (Answer $answer) {
                                      return $answer->getDetails();
                                  });
        $question->numAnswers = $question->answers->count();

        return $question;
    }

}
