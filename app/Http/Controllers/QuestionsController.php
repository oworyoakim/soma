<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class QuestionsController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $builder = Question::query();
            if ($moduleId = $request->get('module_id'))
            {
                $builder->where('module_id', $moduleId);
            }
            if ($topicId = $request->get('topic_id'))
            {
                $builder->where('topic_id', $topicId);
            }
            $questions = $builder->get()
                                 ->map(function (Question $question) {
                                     return $question->getDetails();
                                 });
            return response()->json($questions);
        } catch (Exception $ex)
        {
            Log::error("GET_QUESTIONS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }


    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'title' => 'required',
                'moduleId' => 'required',
                'topicId' => 'required',
            ]);
            $user = Sentinel::getUser();

            Question::query()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'module_id' => $request->get('moduleId'),
                'topic_id' => $request->get('topicId'),
                'type' => $request->get('type'),
                'weight' => $request->get('weight'),
                'created_by' => $user->getUserId(),
            ]);
            return response()->json("Question Created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_QUESTION: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $question = Question::query()->find($id);
            if (!$question)
            {
                throw new Exception("Question not found!");
            }
            $title = $request->get('title');

            $request->validate([
                'title' => 'required',
            ]);

            $question->title = $title;
            $question->description = $request->get('description');
            $question->type = $request->get('type');
            $question->weight = $request->get('weight');
            $question->save();

            return response()->json("Question Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_QUESTION: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
