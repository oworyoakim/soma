<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Intake;
use App\Models\Program;
use App\Models\Student;
use App\SomaHelpers;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EnrollmentsController extends Controller
{
    use ValidatesHttpRequests;

    public function indexEnrollments()
    {
        return view('admin.enrollments');
    }

    public function index(Request $request)
    {
        try
        {
            $builder = Enrollment::query();
            $enrollmentsData = $builder->paginate(8);
            $enrollments = SomaHelpers::generatePagination($enrollmentsData);
            $enrollments->data = $enrollmentsData->getCollection()
                                                 ->map(function (Enrollment $enrollment) {
                                                     return $enrollment->getDetails();
                                                 });
            return response()->json($enrollments);
        } catch (Exception $ex)
        {
            Log::error("GET_ENROLLMENTS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $rules = [
                'studentId' => 'required',
                'programId' => 'required',
                'intakeId' => 'required',
            ];

            $this->validateData($request->all(), $rules);
            $loggedInUser = Sentinel::getUser();
            $intakeId = $request->get('intakeId');
            $intake = Intake::query()->find($intakeId);
            if (!$intake)
            {
                throw new Exception("Intake not found!");
            }
            $programId = $request->get('programId');
            $program = Program::query()->find($programId);
            if (!$program)
            {
                throw new Exception("Program not found!");
            }

            $studentId = $request->get('studentId');
            $student = Student::query()->find($studentId);
            if (!$student)
            {
                throw new Exception("Student not found!");
            }
            if ($student->hasEnrolledFor($programId, $intakeId))
            {
                throw new Exception("Student already enrolled for the selected program in the selected intake!");
            }
            if(!$student->isEligibleFor($programId)){
                throw new Exception("Student is not eligible for this program!");
            }

            Enrollment::query()->create([
                'intake_id' => $intakeId,
                'program_id' => $programId,
                'student_id' => $studentId,
                'user_id' => $loggedInUser->getUserId(),
                'enroll_date' => Carbon::today(),
            ]);
            return response()->json("Enrollment created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_ENROLLMENT: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
