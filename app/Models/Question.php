<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use stdClass;

/**
 * Class Question
 * @package App\Models
 * @property int id
 * @property int topic_id
 * @property int module_id
 * @property string title
 * @property string description
 * @property int weight
 * @property string type
 * @property bool shuffle_answers
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

    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
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
        $question->shuffleAnswers = !!$this->shuffle_answers;
        $question->active = !!$this->active;
        $question->weight = $this->weight;
        $question->type = $this->type;
        $question->topicId = $this->topic_id;
        $question->moduleId = $this->module_id;

        $question->answers = $this->answers()
                                  ->get()
                                  ->map(function (Answer $answer) {
                                      return $answer->getDetails();
                                  });
        if($question->shuffleAnswers){
            $question->answers = $question->answers->shuffle();
        }
        $question->numAnswers = $question->answers->count();

        return $question;
    }

    public function getDetailsForExamSession()
    {
        $question = new stdClass();
        $question->id = $this->id;
        $question->title = $this->title;
        $question->description = $this->description;
        $question->weight = $this->weight;
        $question->answered = false;
        $activeAnswers = $this->answers()
                              ->active()
                              ->get();

        $answers = $activeAnswers->map(function (Answer $answer) {
            return $answer->getDetailsForExamSession();
        });
        if($this->shuffle_answers){
            $question->answers = $answers->shuffle();
        }else {
            $question->answers = $answers;
        }
        $question->numAnswers = $answers->count();
        $numberOfCorrectAnswers = $activeAnswers->filter(function ($ans) {
            return !!$ans->correct;
        })->count();
        $question->hasCorrectAnswers = $numberOfCorrectAnswers > 0;
        $question->hasMultipleAnswers = $numberOfCorrectAnswers > 1;

        return $question;
    }

}
