<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Answer;
use App\Models\Question;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class AnswersController extends Controller
{
    use ValidatesHttpRequests;

    public function index(Request $request)
    {
        try
        {
            $builder = Answer::query();
            $questionId = $request->get('questionId');
            if ($questionId)
            {
                $builder->where('question_id', $questionId);
            }

            $answers = $builder->get()->transform(function (Answer $answer) {
                return $answer->getDetails();
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
            $this->validateData($request->all(),[
                'description' => 'required',
                'questionId' => 'required',
            ]);
            $user = Sentinel::getUser();

            $questionId = $request->get('questionId');
            Answer::query()->create([
                'description' => $request->get('description'),
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
            $description = $request->get('description');

            $this->validateData($request->all(),[
                'description' => 'required',
                'questionId' => 'required',
            ]);

            $questionId = $request->get('questionId');

            $answer->description = $description;
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
