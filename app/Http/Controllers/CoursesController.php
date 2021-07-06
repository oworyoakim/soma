<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;

class CoursesController extends Controller
{
    use ValidatesHttpRequests;

    public function indexCourses()
    {
        return view('admin.courses.index');
    }

    public function showCourse($courseId)
    {
        $course = Course::find($courseId);
        if(empty($course)){
            return redirect()->to('/admin/courses')->with(['error' => 'Course not found!']);
        }
        return view('admin.courses.show', compact('course'));
    }

    public function courseModules($courseId)
    {
        $course = Course::find($courseId);
        if(empty($course)){
            return redirect()->to('/admin/courses')->with(['error' => 'Course not found!']);
        }
        return view('admin.courses.modules', compact('course'));
    }

    public function courseTopics($courseId)
    {
        $course = Course::find($courseId);
        if(empty($course)){
            return redirect()->to('/admin/courses')->with(['error' => 'Course not found!']);
        }
        return view('admin.courses.topics', compact('course'));
    }

    public function index(Request $request)
    {
        try
        {
            $programId = $request->get('programId');
            $builder = Course::query();
            if (!empty($programId))
            {
                $courseIds = ProgramCourse::query()->where('program_id', $programId)->pluck('course_id')->all();
                $builder->whereIn('id', $courseIds);
            }
            $courses = $builder->get()
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
            $rules = [
                'title' => 'required|unique:courses',
                'code' => 'required|unique:courses',
                'levelId' => 'required',
            ];

            $this->validateData($request->all(), $rules);

            $user = Sentinel::getUser();
            DB::beginTransaction();
            $course = Course::query()->create([
                'title' => $request->get('title'),
                'slug' => Str::slug($request->get('title')),
                'code' => $request->get('code'),
                'duration' => $request->get('duration'),
                'level_id' => $request->get('levelId'),
                'weight' => $request->get('weight'),
                'description' => $request->get('description'),
                'created_by' => $user->getUserId(),
            ]);
            DB::commit();
            return response()->json("Course Created!");
        } catch (Exception $ex)
        {
            DB::rollBack();
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

            if ($slug != $course->slug)
            {
                $someCourse = Course::query()->where('slug', $slug)->first();

                if ($someCourse && $someCourse->id != $course->id)
                {
                    throw new Exception("A course titled {$title} already exists!");
                }
            }

            if (!empty($code) && $code != $course->code)
            {
                $someCourse = Course::query()->where('code', $code)->first();

                if ($someCourse && $someCourse->id != $course->id)
                {
                    throw new Exception("A course with code {$code} already exists!");
                }
            }

            if (!empty($title))
            {
                $course->title = $title;
                $course->slug = $slug;
            }

            if (!empty($code))
            {
                $course->code = $code;
            }
            if ($levelId = $request->get('levelId'))
            {
                $course->level_id = $levelId;
            }
            if ($duration = $request->get('duration'))
            {
                $course->duration = $duration;
            }
            if ($weight = $request->get('weight'))
            {
                $course->weight = $weight;
            }

            if ($description = $request->get('description'))
            {
                $course->description = $description;
            } elseif ($request->has('description'))
            {
                $course->description = null;
            }
            DB::beginTransaction();
            $course->save();
            DB::commit();
            return response()->json("Course Updated!");
        } catch (Exception $ex)
        {
            DB::rollBack();
            Log::error("UPDATE_COURSE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function updateCourseDescription(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $course = Course::query()->find($id);
            if (!$course)
            {
                throw new Exception("Course not found!");
            }
            if ($request->has('description'))
            {
                $course->description = $request->get('description');
            }
            DB::beginTransaction();
            $course->save();
            DB::commit();
            return response()->json("Course description updated!");
        } catch (Exception $ex)
        {
            DB::rollBack();
            Log::error("UPDATE_COURSE_DESCRIPTION: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function show($id)
    {
        try
        {
            $course = Course::query()->find($id);
            if (!$course)
            {
                throw new Exception('Course not found!');
            }

            $courseData = $course->getDetails();

            return response()->json($courseData);
        } catch (Exception $ex)
        {
            Log::error("GET_COURSE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
