<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProgramsController extends Controller
{
    use ValidatesHttpRequests;

    public function indexPrograms()
    {
        return view('admin.programs');
    }

    public function index(Request $request)
    {
        try
        {
            $levels = Program::query()
                             ->get()
                             ->map(function (Program $program) {
                                 return $program->getDetails();
                             });
            return response()->json($levels);
        } catch (Exception $ex)
        {
            Log::error("GET_PROGRAMS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $rules = [
                'title' => 'required|unique:programs',
                'duration' => 'required|numeric|min:0',
                'ageLimit' => 'required|numeric|min:0|max:100',
                'passMark' => 'required|numeric|min:0|max:100',
                'requirements' => 'required',
            ];

            $this->validateData($request->all(), $rules);

            $user = Sentinel::getUser();
            $title = $request->get('title');
            $slug = Str::slug($title);
            DB::beginTransaction();
            $program = Program::query()->create([
                'title' => $title,
                'slug' => $slug,
                'description' => $request->get('description'),
                'requirements' => $request->get('requirements'),
                'duration' => $request->get('duration'),
                'age_limit' => $request->get('ageLimit'),
                'pass_mark' => $request->get('passMark'),
                'prerequisites' => serialize($request->get('prerequisiteIds')),
                'created_by' => $user->getUserId(),
            ]);
            $courseIds = $request->get('courseIds');
            $program->courses()->sync($courseIds);
            DB::commit();
            return response()->json("Program Created!");
        } catch (Exception $ex)
        {
            DB::rollBack();
            Log::error("CREATE_PROGRAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $program = Program::query()->find($id);
            if (!$program)
            {
                throw new Exception("Program not found!");
            }
            $rules = [
                'title' => 'required',
                'duration' => 'required|numeric|min:0',
                'ageLimit' => 'required|numeric|min:0|max:100',
                'passMark' => 'required|numeric|min:0|max:100',
                'requirements' => 'required',
            ];

            $this->validateData($request->all(), $rules);

            $user = Sentinel::getUser();
            $title = $request->get('title');
            $slug = Str::slug($title);

            if ($slug != $program->slug && Program::query()->where('slug', $slug)->count())
            {
                throw new Exception("A program titled {$title} already exists!");
            }

            $program->title = $title;
            $program->slug = $slug;
            $program->description = $request->get('description');
            $program->requirements = $request->get('requirements');
            $program->duration = $request->get('duration');
            $program->age_limit = $request->get('ageLimit');
            $program->pass_mark = $request->get('passMark');
            $program->updated_by = $user->getUserId();
            DB::beginTransaction();
            $program->save();
            $courseIds = $request->get('courseIds');
            $program->courses()->sync($courseIds);
            DB::commit();
            return response()->json("Program Updated!");
        } catch (Exception $ex)
        {
            DB::rollBack();
            Log::error("UPDATE_PROGRAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function show(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $program = Program::query()->find($id);
            if (!$program)
            {
                throw new Exception("Program not found!");
            }

            $programData = $program->getDetails();

            return response()->json($programData);
        } catch (Exception $ex)
        {
            Log::error("UPDATE_PROGRAM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

}
