<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ProgramCourse;
use App\Models\Student;
use App\SomaHelpers;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StudentsController extends Controller
{
    use ValidatesHttpRequests;

    public function indexStudents()
    {
        return view('admin.students');
    }

    public function index(Request $request)
    {
        try
        {
            $builder = Student::query();
            $studentsData = $builder->paginate(8);
            $students = SomaHelpers::generatePagination($studentsData);
            $students->data = $studentsData->getCollection()
                                           ->map(function (Student $student) {
                                               return $student->getInfo();
                                           });
            return response()->json($students);
        } catch (Exception $ex)
        {
            Log::error("GET_STUDENTS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $this->validateData($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'username' => 'required|unique:users',
                'enrollNumber' => 'required|unique:users,enroll_number',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'required',
            ]);
            // check email
            $email = $request->get('email');
            if (!empty($email))
            {
                $email = strtolower($email);
                if (Student::query()->where('email', $email)->count())
                {
                    throw new Exception("Email {$email} already taken!");
                }
            }
            $role = Sentinel::getRoleRepository()->findBySlug('student');
            if (!$role)
            {
                throw new Exception('Could not map the new student to a valid role!');
            }
            $student = Sentinel::registerAndActivate([
                'first_name' => $request->get('firstName'),
                'last_name' => $request->get('lastName'),
                'username' => $request->get('username'),
                'email' => $email,
                'password' => $request->get('password'),
                'avatar' => '/images/avatar.png',
                'group' => 'learners',
                'enroll_number' => $request->get('enrollNumber'),
            ]);
            $role->users()->attach($student);
            return response()->json('Student created!');
        } catch (Exception $ex)
        {
            Log::error("CREATE_STUDENT: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $rules = [
                'id' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'enrollNumber' => 'required',
                'username' => 'required',
            ];
            $this->validateData($request->all(), $rules);
            $id = $request->get('id');
            // check user
            $student = Student::find($id);
            if (!$student)
            {
                throw new Exception("Student not found!");
            }
            $username = $request->get('username');
            $email = $request->get('email');
            // check username
            if (strtolower($username) != strtolower($student->username) && Student::query()->where('username', $username)->count())
            {
                throw new Exception("Username {$username} already taken!");
            }
            // check enroll number
            $enrollNumber = $request->get('enrollNumber');
            if (strtolower($enrollNumber) != strtolower($student->enroll_number) && Student::where('enroll_number', $enrollNumber)->count())
            {
                throw new Exception("Enrollment number {$enrollNumber} already taken!");
            }
            // check email
            if (!empty($email) && strtolower($email) != strtolower($student->email) && Student::where('email', strtolower($email))->count())
            {
                throw new Exception("Email address {$email} already taken!");
            }

            $student->first_name = $request->get('firstName');
            $student->last_name = $request->get('lastName');
            $student->username = $username;
            $student->email = strtolower($email);
            $student->enroll_number = $enrollNumber;
            $student->save();
            return response()->json('Student updated!');
        } catch (Exception $ex)
        {
            Log::error("UPDATE_STUDENT: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function show($id)
    {
        try
        {
            $student = Student::find($id);
            if (!$student)
            {
                throw new Exception("Student not found!");
            }
            $studentData = $student->getInfo();
            unset($studentData->role);
            $enrollments = $student->enrollments()
                                   ->get()
                                   ->map(function (Enrollment $enrollment) {
                                       return $enrollment->getDetails();
                                   });
            $studentData->numberOfEnrollments = $enrollments->count();
            $studentData->programsEnrolled = $enrollments->pluck('program_id')->all();
            $studentData->numberOfExams = 0;
            return response()->json($studentData);
        } catch (Exception $ex)
        {
            Log::error("GET_STUDENT: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function nextId()
    {
        try
        {
            $student = Student::query()->latest()->first();
            if (!$student)
            {
                $nextId = '0001';
            } else
            {
                $nextId = SomaHelpers::getNextSequenceValuePadded($student->id);
            }
            return response()->json($nextId);
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function myCourses()
    {
        try
        {
            $user = Sentinel::getUser();
            $student = Student::query()->find($user->getUserId());
            $courses = $student->myCourses();
            //dd($courses);
            return response()->json($courses);
        } catch (Exception $ex)
        {
            Log::error("GET_MY_COURSES: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function myPrograms()
    {
        try
        {
            $user = Sentinel::getUser();
            $student = Student::query()->find($user->getUserId());
            $programs = $student->myPrograms();
            //dd($programs);
            return response()->json($programs);
        } catch (Exception $ex)
        {
            Log::error("GET_MY_PROGRAMS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
