<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamModule;
use App\Models\Intake;
use App\Models\Question;
use App\Models\Result;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExamsController extends Controller
{
    use ValidatesHttpRequests;

    public function indexExams()
    {
        return view('admin.exams');
    }

    public function index(Request $request)
    {
        try
        {
            $builder = Exam::query();
            $exams = $builder->get()->map(function (Exam $exam) {
                return $exam->getDetails();
            });
            return response()->json($exams);
        } catch (Exception $ex)
        {
            Log::error("GET_EXAMS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            //throw new Exception("Okay");
            $rules = [
                //'title' => 'required|unique:exams',
                'code' => 'required|unique:exams',
                'duration' => 'required',
                'courseId' => 'required',
                'intakeId' => 'required',
                'numberOfQuestions' => 'required',
                'passMark' => 'required',
                'instructions' => 'required',
            ];
            $this->validateData($request->all(), $rules);
            DB::beginTransaction();
            $exam = Exam::query()->create([
                'code' => $request->get('code'),
                'duration' => $request->get('duration'),
                'program_id' => $request->get('programId'),
                'course_id' => $request->get('courseId'),
                'intake_id' => $request->get('intakeId'),
                'level_id' => $request->get('levelId'),
                'num_questions' => $request->get('numberOfQuestions'),
                'pass_score' => $request->get('passMark'),
                'instructions' => $request->get('instructions'),
                'maximum_attempts' => $request->get('maximumAttempts') ?: 5,
            ]);

            $modules = $request->get('modules');
            foreach ($modules as $module)
            {
                ExamModule::query()->create([
                    'exam_id' => $exam->id,
                    'module_id' => $module['id'],
                    'number_of_questions' => $module['numQuestions']
                ]);
            }
            DB::commit();
            return response()->json("Exam created!");
        } catch (Exception $ex)
        {
            DB::rollBack();
            Log::error("CREATE_EXAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
            //return response()->json($request->all(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $examId = $request->get('id');
            $exam = Exam::query()->find($examId);
            if (empty($exam))
            {
                throw new Exception("Exam not found!");
            }
            if ($code = $request->get('code'))
            {
                if ($code != $exam->code && Exam::query()->where('code', $code)->count())
                {
                    throw new Exception("An examination with code {$code} already exists!");
                }
                $exam->code = $code;
            }
            if ($duration = $request->get('duration'))
            {
                $exam->duration = $duration;
            }
            if ($programId = $request->get('programId'))
            {
                $exam->program_id = $programId;
            }
            if ($courseId = $request->get('courseId'))
            {
                $exam->course_id = $courseId;
            }
            if ($intakeId = $request->get('intakeId'))
            {
                $exam->intake_id = $intakeId;
            }
            if ($levelId = $request->get('levelId'))
            {
                $exam->level_id = $levelId;
            }
            if ($instructions = $request->get('instructions'))
            {
                $exam->instructions = $instructions;
            }
            if ($maximumAttempts = $request->get('maximumAttempts'))
            {
                $exam->maximum_attempts = $maximumAttempts;
            }
            if ($numQuestions = $request->get('numberOfQuestions'))
            {
                $exam->num_questions = $numQuestions;
            }
            if ($passScore = $request->get('passScore'))
            {
                $exam->pass_score = $passScore;
            }
            $exam->save();
            return response()->json("Exam updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_EXAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function show($id)
    {
        try
        {
            $exam = Exam::query()->find($id);
            if (empty($exam))
            {
                throw new Exception("Exam not found!");
            }

            return response()->json($exam->getDetails());
        } catch (Exception $ex)
        {
            Log::error("GET_EXAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function getExamInfo(Request $request)
    {
        try
        {
            $examInfo = new stdClass();

            $slug = $request->get('slug');
            $examId = $request->get('examId');
            $exam = null;
            $course = null;
            if ($examId)
            {
                $exam = Exam::active()->find($examId);
                $course = $exam->course;
            } elseif ($slug)
            {
                $course = Course::query()->where('slug', $slug)->first();
                if (!$course)
                {
                    throw new Exception("Course {$slug} not found!");
                }
                $exam = Exam::active()->where('course_id', $course->id)->first();
            } else
            {
                throw new Exception("An exam ID or a course slug is required!");
            }
            if (!$exam)
            {
                throw new Exception("There is no active exam!");
            }

            $intake = Intake::query()->find($exam->intake_id);
            if (!$intake)
            {
                throw new Exception("Exam intake not found!");
            }

            $examInfo->id = $exam->id;
            $examInfo->code = $exam->code;
            $examInfo->numberOfQuestions = $exam->num_questions;
            $examInfo->duration = $exam->duration;
            $examInfo->passScore = $exam->pass_score;
            $examInfo->intakeId = $intake->id;
            $examInfo->intakeTitle = $intake->title;
            $examInfo->courseId = $exam->course_id;
            $examInfo->courseTitle = ($course) ? $course->title : null;
            $examInfo->programId = $exam->program_id;
            $examInfo->programTitle = ($exam->program) ? $exam->program->title : null;
            $examInfo->instructions = $exam->instructions;
            $examInfo->studentId = null;
            $examInfo->studentName = null;
            $examInfo->studentNumber = null;
            $examInfo->numberOfAttempts = null;
            if (Sentinel::inAnyRole(['student']))
            {
                $user = Sentinel::getUser();

                $enrollment = Enrollment::active()
                                        ->where('user_id', $user->getUserId())
                                        ->where('intake_id', $intake->id)
                                        ->where('program_id', $exam->program_id)
                                        ->first();
                if (!$enrollment)
                {
                    throw new Exception("You are not enrolled to take this exam!");
                }

                $examInfo->studentId = $user->getUserId();
                $examInfo->studentName = $user->fullName();
                $examInfo->studentNumber = $user->enroll_number;
                $examInfo->numberOfAttempts = Result::query()
                                                    ->where('enrollment_id', $enrollment->id)
                                                    ->where('course_id', $exam->course_id)
                                                    ->count();
            }
            return response()->json($examInfo);
        } catch (Exception $ex)
        {
            Log::error("GET_EXAM_INFO: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function getExamQuestions(Request $request)
    {
        try
        {
            $examId = $request->get('examId');
            $exam = Exam::query()->find($examId);
            if (!$exam)
            {
                throw new Exception("Exam not found!");
            }

            // questions and answers
            $questions = Collection::make();
            $examModules = ExamModule::query()
                                     ->where('exam_id', $exam->id)
                                     ->where('number_of_questions', '>', 0)
                                     ->get();

            foreach ($examModules as $examModule)
            {
                $moduleQuestions = Question::active()
                                           ->examinable()
                                           ->where('module_id', $examModule->module_id)
                                           ->inRandomOrder()
                                           ->get()
                                           ->map(function (Question $question) {
                                               return $question->getDetailsForExamSession();
                                           })
                                           ->filter(function ($question) {
                                               return $question->hasCorrectAnswers;
                                           })
                                           ->take($examModule->number_of_questions);

                $questions = $questions->merge($moduleQuestions);
            }
            $questions = $questions->shuffle();
            return response()->json($questions);
        } catch (Exception $ex)
        {
            Log::error("GET_EXAM_QUESTIONS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function markExam(Request $request)
    {
        try
        {
            $exam = $request->get('exam');
            $results = new stdClass();
            $results->examId = $exam['id'];

        } catch (Exception $ex)
        {
            Log::error("MARK_EXAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function storeResponses(Request $request)
    {

    }

}
