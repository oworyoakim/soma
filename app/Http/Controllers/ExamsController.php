<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Intake;
use App\Models\Question;
use App\Models\Result;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExamsController extends Controller
{
    public function getExamInfo(Request $request)
    {
        try
        {
            $examInfo = new stdClass();

            $slug = $request->get('slug');
            $course = Course::query()->where('slug', $slug)->first();
            if (!$course)
            {
                throw new Exception("Course {$slug} not found!");
            }
            $user = Sentinel::getUser();
            $exam = Exam::active()->where('course_id', $course->id)->first();
            if (!$exam)
            {
                throw new Exception("There is no active exam for course {$course->title}!");
            }
            $intake = Intake::query()->find($exam->intake_id);
            if (!$intake)
            {
                throw new Exception("There is no intake associated with an exam for course {$course->title}!");
            }
            $enrollment = Enrollment::active()->where('user_id', $user->getUserId())->where('intake_id', $intake->id)->first();
            if (!$enrollment)
            {
                throw new Exception("You are not enrolled for this course {$course->title}!");
            }

            $examInfo->id = $exam->id;
            $examInfo->code = $exam->code;
            $examInfo->numberOfQuestions = $exam->num_questions;
            $examInfo->duration = $exam->duration;
            $examInfo->passScore = $exam->pass_score;
            $examInfo->intakeId = $intake->id;
            $examInfo->intakeTitle = $intake->title;
            $examInfo->courseId = $course->id;
            $examInfo->courseTitle = $course->title;
            $examInfo->studentId = $user->getUserId();
            $examInfo->studentName = $user->fullName();
            $examInfo->studentNumber = $enrollment->student_number;
            $examInfo->instructions = $exam->instructions;
            $examInfo->numberOfAttempts = Result::query()
                                                ->where('enrollment_id', $enrollment->id)
                                                ->where('course_id', $course->id)
                                                ->count();

            // questions and answers
            $questionsBuilder = Question::active()->examinable();
            $questionsBuilder->where('module.course_id', $course->id);
            $questions = $questionsBuilder->get(['id', 'title', 'description', 'weight'])
                                          ->map(function (Question $item) {
                                              $question = new stdClass();
                                              $question->id = $item->id;
                                              $question->title = $item->title;
                                              $question->description = $item->description;
                                              $question->weight = $item->weight;
                                              $question->answered = false;
                                              $activeAnswers = $item->answers()
                                                                    ->active()
                                                                    ->get(['id', 'title', 'correct']);

                                              $answers = $activeAnswers->map(function (Answer $ans) {
                                                  $answer = new stdClass();
                                                  $answer->id = $ans->id;
                                                  $answer->title = $ans->title;
                                                  $answer->selected = false;
                                                  return $answer;
                                              });
                                              $question->answers = $answers->shuffle();
                                              $question->numAnswers = $answers->count();

                                              $question->numCorrectAnswers = $activeAnswers->filter(function ($ans) {
                                                  return !!$ans->correct;
                                              })->count();

                                              return $question;
                                          });

            $examInfo->questions = $questions->shuffle()
                                             ->random($exam->num_questions);
            /*
            $examInfo = new stdClass();
            $examInfo->intakeId = 1;
            $examInfo->intakeTitle= "Intake 1";
            $examInfo->courseId= 10;
            $examInfo->courseTitle= "Course 1";
            $examInfo->studentId= 14;
            $examInfo->studentName= "Student 1";
            $examInfo->studentNumber= "STA0012";
            $examInfo->examId= 8;
            $examInfo->examDuration= 45;
            $examInfo->instructions= "";
            $examInfo->questions = [
                    {
                        id: 1,
                        title: 'Question 1.',
                        description: 'How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight?',
                        answered: false,
                        answers: [
                          {id: 21, title: 'Answer 1',selected: false},
                          {id: 23, title: 'Answer 2',selected: false},
                          {id: 25, title: 'Answer 3',selected: false},
                          {id: 26, title: 'Answer 4',selected: false},

                        ]
                    },
                    {
                        id: 2,
                        title: 'Question 2.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                          {id: 31, title: 'Answer 1',selected: false},
                          {id: 32, title: 'Answer 2',selected: false},
                          {id: 33, title: 'Answer 3',selected: false},
                          {id: 34, title: 'Answer 4',selected: false},

                        ]
                    },
                    {
                        id: 3,
                        title: 'Question 3.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                          {id: 41, title: 'Answer 1',selected: false},
                          {id: 42, title: 'Answer 2',selected: false},
                          {id: 43, title: 'Answer 3',selected: false},
                          {id: 44, title: 'Answer 4',selected: false},

                        ]
                    },
                    {
                        id: 4,
                        title: 'Question 4.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                          {id: 51, title: 'Answer 1',selected: false},
                          {id: 52, title: 'Answer 2',selected: false},
                          {id: 53, title: 'Answer 3',selected: false},
                          {id: 54, title: 'Answer 4',selected: false},

                        ]
                    },
                    {
                        id: 5,
                        title: 'Question 5.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                          {id: 61, title: 'Answer 1',selected: false},
                          {id: 62, title: 'Answer 2',selected: false},
                          {id: 63, title: 'Answer 3',selected: false},
                          {id: 64, title: 'Answer 4',selected: false},

                        ]
                    },
                    {
                        id: 6,
                        title: 'Question 6.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                          {id: 71, title: 'Answer 1',selected: false},
                          {id: 72, title: 'Answer 2',selected: false},
                          {id: 73, title: 'Answer 3',selected: false},
                          {id: 74, title: 'Answer 4',selected: false},

                        ]
                    },
                ],
            */
            return response()->json($examInfo);
        } catch (Exception $ex)
        {
            Log::error("GET_EXAM_INFO: {$ex->getMessage()}");
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

}
