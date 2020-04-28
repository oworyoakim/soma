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
            $courseId = $request->get('course_id');
            if ($courseId)
            {
                $builder->where('course_id', $courseId);
            }

            $modules = $builder->get()->map(function (Module $item) {
                $module = new stdClass();
                $module->id = $item->id;
                $module->title = $item->title;
                $module->description = $item->description;
                $module->courseId = $item->course_id;
                $module->course = null;
                $module->duration = $item->duration;
                $module->outline = $item->outline;
                return $module;
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
                'outline' => $request->get('outline'),
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

            $request->validate([
                'title' => 'required',
                'courseId' => 'required',
            ]);

            $courseId = (int)$request->get('courseId');
            $course = Course::query()->find($courseId);

            if ($courseId != $module->course_id && !$course)
            {
                throw new Exception("Course not found!");
            }

            $module->title = $title;
            $module->description = $request->get('description');
            $module->course_id = $request->get('courseId');
            $module->duration = $request->get('duration');
            $module->outline = $request->get('outline');
            $module->save();

            return response()->json("Module Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_MODULE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
