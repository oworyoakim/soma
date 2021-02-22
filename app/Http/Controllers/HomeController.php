<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\FlightType;
use App\Models\Instructor;
use App\Models\Intake;
use App\Models\Level;
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
        if (!Sentinel::check())
        {
            Sentinel::logout(null, true);
            return redirect()->route('login');
        }
        if (Sentinel::inRole('student'))
        {
            return redirect()->intended(route('student.dashboard'));
        }
        return redirect()->intended(route('admin.dashboard'));
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


    public function formSelectionsOptions()
    {
        try
        {
            $options = new stdClass();
            $options->programs = Program::all(['id', 'title'])->map(function (Program $program){
                $program->courseIds = ProgramCourse::query()->where('program_id', $program->id)->pluck('course_id')->all();
                return $program;
            });
            $options->intakes = Intake::all(['id', 'title']);
            $options->courses = Course::all(['id', 'title']);
            $options->levels = Level::all(['id', 'title']);
            $options->students = Student::selectRaw("id, CONCAT(first_name, ' ', last_name) as fullName")->get();
            $options->instructors = Instructor::selectRaw("id, CONCAT(first_name, ' ', last_name) as fullName")->get();
            $options->roles = Role::all(['id', 'name']);
            $options->flightTypes = FlightType::all(['id', 'title']);
            return response()->json($options);
        } catch (Exception $ex)
        {
            Log::error("GET_FORM_SELECTIONS_OPTIONS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
