<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\SomaHelpers;
use App\Traits\ValidatesHttpRequests;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InstructorsController extends Controller
{
    use ValidatesHttpRequests;

    public function indexInstructors()
    {
        return view('admin.instructors');
    }

    public function index(Request $request)
    {
        try
        {
            $builder = Instructor::query();
            $instructorsData = $builder->paginate(8);
            $instructors = SomaHelpers::generatePagination($instructorsData);
            $instructors->data = $instructorsData->getCollection()->map(function (Instructor $instructor) {
                return $instructor->getInfo();
            });
            return response()->json($instructors);
        } catch (Exception $ex)
        {
            Log::error("GET_INSTRUCTORS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

}
