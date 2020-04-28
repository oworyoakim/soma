<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * Class ExamResponse
 * @package App\Models
 * @property int id
 * @property int result_id
 * @property int question_id
 * @property int answer_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class ExamResponse extends Model
{
    protected $table = 'exam_responses';

    public function result()
    {
        return $this->belongsTo(Result::class, 'result_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
