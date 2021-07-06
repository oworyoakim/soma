<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * Class ExamModule
 * @package App\Models
 * @property int id
 * @property int exam_id
 * @property int module_id
 * @property int number_of_questions
 */
class ExamModule extends Model
{
    protected $table = 'exam_modules';

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function module(){
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function getDetails(){
        $examModule = new stdClass();
        $examModule->id = $this->id;
        $examModule->examId = $this->exam_id;
        $examModule->moduleId = $this->module_id;
        $examModule->numberOfQuestions = $this->number_of_questions;
        return $examModule;
    }
}
