<?php

namespace App\Http\Controllers;

use App\Traits\ValidatesHttpRequests;
use Exception;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LogbooksController extends Controller
{
    use ValidatesHttpRequests;

    public function indexLogbooks()
    {
        return view('admin.logbooks');
    }

    public function index(Request $request)
    {
        try
        {
            $logbooks = Logbook::all()->map(function (Logbook $logbook) {
                return $logbook->getDetails();
            });
            return response()->json($logbooks);
        } catch (Exception $ex)
        {
            Log::error("GET_LOGBOOKS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $rules = [
                'studentId' => 'required',
                'flightTypeId' => 'required',
                'instructorId' => 'required',
                'aircraft' => 'required',
                'landings' => 'required',
                'dateRecorded' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
            ];

            $this->validateData($request->all(), $rules);
            $dateRecorded = $request->get('dateRecorded');
            $stime = $request->get('startTime');
            $etime = $request->get('endTime');
            $startTime = Carbon::parse("{$dateRecorded} {$stime}");
            $endTime = Carbon::parse("{$dateRecorded} {$etime}");
            $durationInMinutes = $endTime->diffInMinutes($startTime);
            $durationInHours = round($durationInMinutes/60, 2);

            Logbook::query()->create([
                'user_id' => $request->get('studentId'),
                'instructor_id' => $request->get('instructorId'),
                'flight_type_id' => $request->get('flightTypeId'),
                'aircraft' => $request->get('aircraft'),
                'landings' => $request->get('landings'),
                'date_recorded' => Carbon::parse($dateRecorded),
                'start_time' => $stime,
                'end_time' => $etime,
                'duration' => $durationInHours,
            ]);

            return response()->json("Logbook entry created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_LOGBOOK: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $rules = [
                'id' => 'required',
                'studentId' => 'required',
                'instructorId' => 'required',
                'flightTypeId' => 'required',
                'aircraft' => 'required',
                'landings' => 'required',
                'dateRecorded' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
            ];


            $this->validateData($request->all(), $rules);
            $id = $request->get('id');

            $logbook = Logbook::query()->find($id);
            if (!$logbook)
            {
                throw new Exception("Logbook not found!");
            }
            $dateRecorded = $request->get('dateRecorded');
            $stime = $request->get('startTime');
            $etime = $request->get('endTime');
            $startTime = Carbon::parse("{$dateRecorded} {$stime}");
            $endTime = Carbon::parse("{$dateRecorded} {$etime}");
            $durationInMinutes = $endTime->diffInMinutes($startTime);
            $durationInHours = round($durationInMinutes/60, 2);

            $logbook->update([
                'flight_type_id' => $request->get('flightTypeId'),
                'date_recorded' => Carbon::parse($dateRecorded),
                'start_time' => $stime,
                'end_time' => $etime,
                'aircraft' => $request->get('aircraft'),
                'landings' => $request->get('landings'),
                'duration' => $durationInHours,
            ]);

            return response()->json("Logbook entry updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_LOGBOOK: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

}
