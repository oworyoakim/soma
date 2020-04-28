<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Answer;
use App\Models\Question;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class AnswersController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $builder = Answer::query();
            $questionId = $request->get('question_id');
            if ($questionId)
            {
                $builder->where('question_id', $questionId);
            }

            $answers = $builder->get()->transform(function (Answer $item) {
                $answer = new stdClass();
                $answer->id = $item->id;
                $answer->title = $item->title;
                $answer->correct = !!$item->correct;
                $answer->status = $item->active;
                $answer->questionId = $item->question_id;
                $answer->question = null;
                return $answer;
            });
            return response()->json($answers);
        } catch (Exception $ex)
        {
            Log::error("GET_ANSWERS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }


    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'title' => 'required',
                'questionId' => 'required',
            ]);
            $user = Sentinel::getUser();

            $questionId = $request->get('questionId');
            /*
            $question = Question::query()->find($questionId);
            if (!$question)
            {
                throw new Exception("Question not found!");
            }
            */
            Answer::query()->create([
                'title' => $request->get('title'),
                'question_id' => $questionId,
                'correct' => $request->get('correct'),
                'created_by' => $user->getUserId(),
            ]);
            return response()->json("Answer Created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_ANSWER: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $answer = Answer::query()->find($id);
            if (!$answer)
            {
                throw new Exception("Answer not found!");
            }
            $title = $request->get('title');

            $request->validate([
                'title' => 'required',
                'questionId' => 'required',
            ]);

            $questionId = $request->get('questionId');
            /*
            $question = Question::query()->find($questionId);
            if (!$question)
            {
                throw new Exception("Question not found!");
            }
            */

            $answer->title = $title;
            $answer->question_id = $questionId;
            $answer->correct = $request->get('correct');
            $answer->save();

            return response()->json("Answer Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_ANSWER: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
