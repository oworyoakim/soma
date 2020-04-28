<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Topic;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class TopicsController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $builder = Topic::query();
            if ($moduleId = $request->get('module_id'))
            {
                $builder->where('module_id', $moduleId);
            }
            $topics = $builder->get()
                              ->transform(function (Topic $item) {
                                  $topic = new stdClass();
                                  $topic->id = $item->id;
                                  $topic->title = $item->title;
                                  $topic->description = $item->description;
                                  $topic->body = $item->body;
                                  $topic->moduleId = $item->module_id;
                                  $topic->module = null;
                                  return $topic;
                              });
            return response()->json($topics);
        } catch (Exception $ex)
        {
            Log::error("GET_TOPICS: {$ex->getMessage()}");
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
            ]);
            $user = Sentinel::getUser();

            Topic::query()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'body' => $request->get('body'),
                'module_id' => $request->get('moduleId'),
                'created_by' => $user->getUserId(),
            ]);
            return response()->json("Topic Created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_TOPIC: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $topic = Topic::query()->find($id);
            if (!$topic)
            {
                throw new Exception("Topic not found!");
            }
            $title = $request->get('title');

            $request->validate([
                'title' => 'required',
                'moduleId' => 'required',
            ]);

            $topic->title = $title;
            $topic->description = $request->get('description');
            $topic->body = $request->get('body');
            $topic->module_id = $request->get('moduleId');
            $topic->save();

            return response()->json("Topic Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_TOPIC: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
