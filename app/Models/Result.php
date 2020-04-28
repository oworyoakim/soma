<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Result
 * @package App\Models
 * @property int id
 * @property int exam_id
 * @property int course_id
 * @property int enrollment_id
 * @property float score
 * @property float pass_score
 * @property bool passed
 * @property int retakes
 * @property int num_questions
 * @property int num_questions_answered
 * @property int num_questions_passed
 * @property Carbon exam_date
 * @property Carbon start_time
 * @property Carbon end_time
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Result extends Model
{
    protected $table = 'results';
    protected $dates = ['exam_date'];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function responses()
    {
        return $this->hasMany(ExamResponse::class, 'result_id');
    }

    public function getDetails()
    {
        $result = new stdClass();
        $result->id = $this->id;
        $result->examId = $this->exam_id;
        $result->courseId = $this->course_id;
        $result->enrollmentId = $this->enrollment_id;
        $result->examDate = $this->exam_date->toDateTimeString();
        $result->startTime = $this->start_time->toDateTimeString();
        $result->endTime = $this->end_time->toDateTimeString();
        $result->numberOfQuestions = $this->num_questions;
        $result->numberOfQuestionsAttempted = $this->num_questions_answered;
        $result->numberOfQuestionsPassed = $this->num_questions_passed;
        $result->score = $this->score;
        $result->passScore = $this->pass_score;
        $result->passed = !!$this->passed;
        $result->retakes = $this->retakes;
        return $result;
    }
}
