<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Exam
 * @package App\Models
 * @property int id
 * @property int code
 * @property string title
 * @property int course_id
 * @property int duration
 * @property int num_questions
 * @property float pass_score
 * @property string instructions
 * @property boolean active
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Exam extends Model
{
    protected $table = 'exams';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function examModules()
    {
        return $this->hasMany(ExamModule::class, 'exam_id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive(Builder $query)
    {
        return $query->where('active', false);
    }

    public function getDetails()
    {
        $exam = new stdClass();
        $exam->id = $this->id;
        $exam->code = $this->code;
        $exam->title = $this->title;
        $exam->courseId = $this->course_id;
        $exam->duration = $this->duration;
        $exam->numQuestions = $this->num_questions;
        $exam->numberOfQuestions = $this->num_questions;
        $exam->passMark = $this->pass_score;
        $exam->instructions = $this->instructions;
        $exam->active = !!$this->active;
        // relationships
        $exam->course = null;

        if ($this->course)
        {
            $exam->course = new stdClass();
            $exam->course->id = $exam->courseId;
            $exam->course->title = $this->course->title;
        }

        $exam->modules = [];
        foreach ($this->examModules()->get() as $examModule){
            $module = new stdClass();
            $module->id = $examModule->module_id;
            $module->title = ($examModule->module) ? $examModule->module->title : null;
            $module->maxNumQuestions = ($examModule->module) ? $examModule->module->questions()->count() : 0;
            $module->numQuestions = $examModule->number_of_questions;
            $exam->modules[] = $module;
        }

        $exam->createdBy = $this->created_by;
        $exam->updatedBy = $this->updated_by;
        $exam->createdAt = $this->created_at->toDateTimeString();
        $exam->updatedAt = $this->updated_at->toDateTimeString();
        return $exam;
    }
}
