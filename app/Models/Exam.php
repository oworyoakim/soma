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
 * @property int intake_id
 * @property int course_id
 * @property int level_id
 * @property int program_id
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

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

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
        $exam->intakeId = $this->intake_id;
        $exam->courseId = $this->course_id;
        $exam->levelId = $this->level_id;
        $exam->programId = $this->program_id;
        $exam->duration = $this->duration;
        $exam->numQuestions = $this->num_questions;
        $exam->numberOfQuestions = $this->num_questions;
        $exam->passMark = $this->pass_score;
        $exam->instructions = $this->instructions;
        $exam->active = !!$this->active;
        // relationships
        $exam->intake = null;
        $exam->level = null;
        $exam->program = null;
        $exam->course = null;
        if ($this->intake)
        {
            $exam->intake = new stdClass();
            $exam->intake->id = $exam->intakeId;
            $exam->intake->title = $this->intake->title;
        }

        if ($this->level)
        {
            $exam->level = new stdClass();
            $exam->level->id = $exam->levelId;
            $exam->level->title = $this->level->title;
        }

        if ($this->program)
        {
            $exam->program = new stdClass();
            $exam->program->id = $exam->programId;
            $exam->program->title = $this->program->title;
        }

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
