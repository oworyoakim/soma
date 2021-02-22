<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;

class LevelsController extends Controller
{
    use ValidatesHttpRequests;

    public function indexLevels()
    {
        return view('admin.levels');
    }

    public function index(Request $request)
    {
        try
        {
            $levels = Level::query()
                           ->get()
                           ->map(function (Level $level) {
                               return $level->getDetails();
                           });
            return response()->json($levels);
        } catch (Exception $ex)
        {
            Log::error("GET_LEVELS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $this->validateData($request->all(), [
                'title' => 'required|unique:levels',
            ]);

            $user = Sentinel::getUser();
            $title = $request->get('title');
            $slug = Str::slug($title);
            Level::query()->create([
                'title' => $title,
                'slug' => $slug,
                'created_by' => $user->getUserId(),
            ]);
            return response()->json("Level Created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_LEVEL: {$ex->getMessage()}");
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
            $id = $request->get('id');
            $level = Level::query()->find($id);
            if (!$level)
            {
                throw new Exception("Level not found!");
            }
            $title = $request->get('title');
            $slug = Str::slug($title);

            if ($slug != $level->slug && Level::query()->where('slug', $slug)->count())
            {
                throw new Exception("A level titled {$title} already exists!");
            }
            if($slug != $level->slug){
                $level->title = $title;
                $level->slug = $slug;
                $level->updated_by = Sentinel::getUser()->getUserId();
                $level->save();
            }
            return response()->json("Level Updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_LEVEL: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
