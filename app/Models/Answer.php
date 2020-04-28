<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use stdClass;

/**
 * Class Answer
 * @package App\Models
 * @property int id
 * @property int question_id
 * @property string title
 * @property bool correct
 * @property bool active
 * @property int created_by
 */
class Answer extends Model
{
    protected $table = 'answers';

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }

    public function scopeInactive(Builder $builder)
    {
        return $builder->where('active', false);
    }

    public function scopeCorrect(Builder $builder)
    {
        return $builder->where('correct', true);
    }

    public function scopeIncorrect(Builder $builder)
    {
        return $builder->where('correct', false);
    }

    /**
     * @return stdClass
     */
    public function getDetails()
    {
        $answer = new stdClass();
        $answer->id = $this->id;
        $answer->title = $this->title;
        $answer->correct = !!$this->correct;
        $answer->active = !!$this->active;
        return $answer;
    }
}
