<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use App\Traits\ValidatesHttpRequests;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;

class IntakesController extends Controller
{
    use ValidatesHttpRequests;

    public function indexIntakes()
    {
        return view('admin.intakes');
    }

    public function index(Request $request)
    {
        try
        {
            $intakes = Intake::all()
                             ->map(function (Intake $intake) {
                                 return $intake->getDetails();
                             });
            return response()->json($intakes);
        } catch (Exception $ex)
        {
            Log::error("GET_INTAKES: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $this->validateData($request->all(), [
                'title' => 'required|unique:intakes',
            ]);
            $title = $request->get('title');
            Intake::query()->create([
                'title' => $title,
                'slug' => Str::slug($title),
            ]);

            return response()->json("Intake created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_INTAKE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $this->validateData($request->all(), [
                'title' => 'required',
            ]);
            $intakeId = $request->get('id');
            $intake = Intake::query()->find($intakeId);
            if (!$intake)
            {
                throw new Exception("Intake not found!");
            }
            $title = $request->get('title');
            $slug = Str::slug($title);
            if ($slug != $intake->slug && Intake::query()->where('slug', $slug)->count())
            {
                throw new Exception("An intake named {$title} already exists!");
            }
            $intake->title = $title;
            $intake->slug = $slug;
            $intake->save();
            return response()->json("Intake updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_INTAKE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
