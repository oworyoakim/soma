<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $courses = Course::query()
                             ->get()
                             ->map(function (Course $course) {
                                 return $course->getDetails();
                             });
            return response()->json($courses);
        } catch (Exception $ex)
        {
            Log::error("GET_COURSES: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'title' => 'required|unique:courses',
                'code' => 'required|unique:courses',
                'duration' => 'required',
                'weight' => 'required',
            ]);

            $user = Sentinel::getUser();

            Course::query()->create([
                'title' => $request->get('title'),
                'slug' => Str::slug($request->get('title')),
                'code' => $request->get('code'),
                'duration' => $request->get('duration'),
                'weight' => $request->get('weight'),
                'created_by' => $user->getUserId(),
            ]);
            return response()->json("Course Created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_COURSE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $course = Course::query()->find($id);
            if (!$course)
            {
                throw new Exception("Course not found!");
            }
            $code = $request->get('code');
            $title = $request->get('title');
            $slug = Str::slug($title);

            $rules = [
                'duration' => 'required',
                'weight' => 'required',
            ];


            if ($slug != $course->slug)
            {
                $someCourse = Course::query()->where('slug', $slug)->first();

                if ($someCourse && $someCourse->id != $course->id)
                {
                    throw new Exception("A course titled {$title} already exists!");
                }
                $rules['title'] = 'required|unique:courses';
            }

            if ($code != $course->code)
            {
                $rules['code'] = 'required|unique:courses';
            }

            $request->validate($rules);

            $course->title = $title;
            $course->slug = $slug;
            $course->code = $code;
            $course->duration = $request->get('duration');
            $course->weight = $request->get('weight');
            $course->save();

            return response()->json("Course Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_COURSE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
