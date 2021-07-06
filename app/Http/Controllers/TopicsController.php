<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Question;
use App\Models\Topic;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class TopicsController extends Controller
{
    use ValidatesHttpRequests;

    public function index(Request $request)
    {
        try
        {
            $builder = Topic::query();
            $moduleIds = [];
            if ($courseId = $request->get('courseId'))
            {
                $moduleIds = Module::query()
                                   ->where('course_id', $courseId)
                                   ->pluck('id')
                                   ->all();
            } elseif ($moduleId = $request->get('moduleId'))
            {
                $moduleIds = [$moduleId];
            }
            $topics = $builder->whereIn('module_id', $moduleIds)
                              ->get()
                              ->map(function (Topic $topic) {
                                  return $topic->getDetails();
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
            $this->validateData($request->all(), [
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
            if ($title = $request->get('title'))
            {
                $topic->title = $title;
            }
            if ($description = $request->get('description'))
            {
                $topic->description = $description;
            }
            if ($body = $request->get('body'))
            {
                $topic->body = $body;
            }
            if ($moduleId = $request->get('moduleId'))
            {
                $topic->module_id = $moduleId;
            }

            $topic->save();

            return response()->json("Topic Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_TOPIC: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function show($id)
    {
        try
        {
            $loggedInUser = Sentinel::getUser();
            $topic = Topic::query()->find($id);
            if (!$topic)
            {
                throw new Exception("Topic not found!");
            }
            $topicData = $topic->getDetails(true);
            $topicData->classroom = null;
            $classroom = $topic->classrooms()->whereIn('status', ['scheduled', 'ongoing', 'missed'])->first();
            if ($classroom)
            {
                $topicData->classroom = $classroom->getDetails($loggedInUser);
            }
            return response()->json($topicData);
        } catch (Exception $ex)
        {
            Log::error("GET_TOPIC: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
