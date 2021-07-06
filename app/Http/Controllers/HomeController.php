<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Intake;
use App\Models\LearningPath;
use App\Models\Level;
use App\Models\Module;
use App\Models\Program;
use App\Models\ProgramCourse;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        return view("site.home");
    }

    public function indexAdmin()
    {
        return view('admin.dashboard');
    }

    public function indexStudent()
    {
        return view('student.dashboard');
    }

    public function studentCourses()
    {
        return view('student.courses');
    }

    public function studentProfile()
    {
        return view('student.profile');
    }

    public function about()
    {
        return view('site.about-us');
    }

    public function courses()
    {
        return view('site.courses.index');
    }

    public function primaryCourses()
    {
        return view('site.courses.primary');
    }

    public function lowerSecondaryCourses()
    {
        return view('site.courses.lower-secondary');
    }

    public function upperSecondaryCourses()
    {
        return view('site.courses.upper-secondary');
    }


    public function instructors()
    {
        return view('site.instructors');
    }

    public function login()
    {
        return view('site.login');
    }

    public function signup()
    {
        return view('site.signup');
    }

    public function forgotPassword()
    {
        return view('site.forgot-password');
    }


    public function formSelectionsOptions(Request $request)
    {
        try
        {
            $options = $request->get('options');
            $formOptions = [
                'learningPaths' => [],
                'levels' => [],
                'courses' => [],
                'modules' => [],
                'students' => [],
                'instructors' => [],
                'roles' => [],
            ];
            if (strpos($options, 'learningPaths') !== false || strpos($options, 'all') !== false)
            {
                $formOptions['learningPaths'] = LearningPath::all(['id', 'title', 'slug']);
            }
            if (strpos($options, 'courses') !== false || strpos($options, 'all') !== false)
            {
                $formOptions['courses'] = Course::all(['id', 'title']);
            }
            if (strpos($options, 'levels') !== false || strpos($options, 'all') !== false)
            {
                // learningPathId
                if ($learningPathId = $request->get('learningPathId'))
                {
                    $formOptions['levels'] = Level::query()
                                                  ->where(['learningPathId' => $learningPathId])
                                                  ->get(['id', 'title', 'learningPathId']);
                } else
                {
                    $formOptions['levels'] = Level::all(['id', 'title', 'learningPathId']);
                }
            }
            if (strpos($options, 'students') !== false || strpos($options, 'all') !== false)
            {
                $formOptions['students'] = Student::selectRaw("id, CONCAT(first_name, ' ', last_name) as fullName")->get();
            }
            if (strpos($options, 'instructors') !== false || strpos($options, 'all') !== false)
            {
                $formOptions['instructors'] = Instructor::selectRaw("id, CONCAT(first_name, ' ', last_name) as fullName")->get();
            }
            if (strpos($options, 'roles') !== false || strpos($options, 'all') !== false)
            {
                $formOptions['roles'] = Role::all(['id', 'name']);
            }

            if (strpos($options, 'modules') !== false || strpos($options, 'all') !== false)
            {
                if ($courseId = $request->get('courseId'))
                {
                    $formOptions['modules'] = Module::query()
                                                    ->where('course_id', $courseId)
                                                    ->get(['id', 'title']);
                }
            }
            return response()->json($formOptions);
        } catch (Exception $ex)
        {
            Log::error("GET_FORM_SELECTIONS_OPTIONS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function getLearningPaths()
    {
        try
        {
            $learningPaths = Course::all()->map(function (Course $item) {
                return $item->getInfoForHomePage();
            });
            return response()->json($learningPaths);
        } catch (Exception $ex)
        {
            Log::error("GET_LEARNING_PATHS:", ['message' => $ex->getMessage()]);
            return response()->json("Error: {$ex->getMessage()}", Response::HTTP_FORBIDDEN);
        }
    }
}
