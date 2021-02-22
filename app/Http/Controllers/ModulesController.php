<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class ModulesController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $builder = Module::query();
            $courseId = $request->get('courseId');
            if (!$courseId)
            {
                return response()->json("Course ID required!", Response::HTTP_FORBIDDEN);
            }
            $builder->where('course_id', $courseId);

            $modules = $builder->get()->map(function (Module $module) {
                return $module->getDetails();
            });
            return response()->json($modules);
        } catch (Exception $ex)
        {
            Log::error("GET_MODULES: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'title' => 'required',
                'courseId' => 'required',
            ]);
            $user = Sentinel::getUser();

            $courseId = $request->get('courseId');
            $course = Course::query()->find($courseId);
            if (!$course)
            {
                throw new Exception("Course not found!");
            }

            Module::query()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'course_id' => $request->get('courseId'),
                'duration' => $request->get('duration'),
                'weight' => $request->get('weight'),
                'created_by' => $user->getUserId(),
            ]);
            return response()->json("Module Created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_MODULE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $module = Module::query()->find($id);
            if (!$module)
            {
                throw new Exception("Module not found!");
            }
            $title = $request->get('title');

            if (!empty($title))
            {
                $module->title = $title;
            }

            if($duration = $request->get('duration'))
            {
                $module->duration = $duration;
            }
            if($weight = $request->get('weight')){
                $module->weight = $weight;
            }

            if($description = $request->get('description')){
                $module->description = $description;
            }elseif($request->has('description')){
                $module->description = null;
            }

            $module->save();

            return response()->json("Module Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_MODULE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function show($id)
    {
        try
        {
            $module = Module::query()->find($id);
            if (!$module)
            {
                return response()->json("Module not found!", Response::HTTP_NOT_FOUND);
            }
            $moduleData = $module->getDetails(true);
            return response()->json($moduleData);
        } catch (Exception $ex)
        {
            dd($ex);
            Log::error("GET_MODULE_DETAILS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

}
