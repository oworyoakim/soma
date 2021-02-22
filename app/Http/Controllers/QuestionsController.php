<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class QuestionsController extends Controller
{
    use ValidatesHttpRequests;

    public function index(Request $request)
    {
        try
        {
            $builder = Question::query();
            if ($moduleId = $request->get('moduleId'))
            {
                $builder->where('module_id', $moduleId);
            }
            if ($topicId = $request->get('topicId'))
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
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'moduleId' => 'required',
                'topicId' => 'required',
            ];

            $this->validateData($request->all(),$rules);

            $user = Sentinel::getUser();

            $question = Question::query()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'module_id' => $request->get('moduleId'),
                'topic_id' => $request->get('topicId'),
                'type' => $request->get('type'),
                'weight' => $request->get('weight'),
                'shuffle_answers' => $request->get('shuffleAnswers'),
                'created_by' => $user->getUserId(),
            ]);

            $answers = $request->get('answers');
            foreach ($answers as $answer){
                Answer::query()->create([
                    'question_id' => $question->id,
                    'description' => $answer['description'],
                    'correct' => $answer['correct'],
                    'created_by' => $user->getUserId(),
                ]);
            }

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
            if($title = $request->get('title')){
                $question->title = $title;
            }

            if($description = $request->get('description')){
                $question->description = $description;
            }
            if($type = $request->get('type')){
                $question->type = $type;
            }
            if($weight = $request->get('weight')){
                $question->weight = $weight;
            }
            $question->shuffle_answers = $request->get('shuffleAnswers');
            $question->save();
            return response()->json("Question Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_QUESTION: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
