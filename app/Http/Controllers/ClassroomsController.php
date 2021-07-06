<?php

namespace App\Http\Controllers;

use App\Exceptions\ZoomRequestException;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\ProgramCourse;
use App\Models\Topic;
use App\Traits\MakesZoomHttpRequests;
use App\Traits\ValidatesHttpRequests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use stdClass;

class ClassroomsController extends Controller
{
    use MakesZoomHttpRequests, ValidatesHttpRequests;

    public function indexClassrooms()
    {
        return view('admin.live-classes');
    }

    public function index(Request $request)
    {
        try
        {
            $courseId = $request->get('courseId');
            $moduleId = $request->get('moduleId');
            $topicId = $request->get('topicId');
            $instructorId = $request->get('instructorId');
            $status = $request->get('status');
            $builder = Classroom::query();

            if (!empty($courseId))
            {
                $builder->where('course_id', $courseId);
            }

            if (!empty($moduleId))
            {
                $builder->where('module_id', $moduleId);
            }

            if (!empty($topicId))
            {
                $builder->where('topic_id', $topicId);
            }

            if (!empty($instructorId))
            {
                $builder->where('instructor_id', $instructorId);
            }

            if (!empty($status))
            {
                $builder->where('status', $status);
            }

            $classes = $builder->get()
                               ->map(function (Classroom $classroom) {
                                   $user = Sentinel::getUser();
                                   $classroomData = $classroom->getDetails($user);
                                   $classroomData->course = null;
                                   if ($classroom->course)
                                   {
                                       $classroomData->course = $classroom->course->getDetails();
                                   }
                                   $classroomData->module = null;
                                   if ($classroom->module)
                                   {
                                       $classroomData->module = $classroom->module->getDetails();
                                   }
                                   $classroomData->topic = null;
                                   if ($classroom->topic)
                                   {
                                       $classroomData->topic = $classroom->topic->getDetails();
                                   }

                                   $classroomData->instructor = null;
                                   /*
                                   if($classroom->instructor){
                                       $classroomData->instructor = $classroom->instructor->getDetails();
                                   }
                                   */
                                   return $classroomData;
                               });
            return response()->json($classes);
        } catch (Exception $ex)
        {
            Log::error("GET_CLASSROOMS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        $responseData = null;
        $type = $request->get('type');
        try
        {
            $rules = [
                'title' => 'required',
                'startTime' => 'required',
                'duration' => 'required',
                'type' => 'required',
                'courseId' => 'required',
                'moduleId' => 'required',
                'topicId' => 'required',
            ];
            $this->validateData($request->all(), $rules);

            $startTime = Carbon::parse($request->get('startTime'));

            if ($type == 'webinar')
            {
                $responseData = $this->storeWebinar($request);
            } else
            {
                $responseData = $this->storeMeeting($request);
            }

            return response()->json("Classroom scheduled for {$startTime->toDateTimeString()}");
        } catch (Exception $ex)
        {
            if (!empty($responseData['id']))
            {
                // we delete the meeting/webinar from zoom
                $path = "{$type}s/{$responseData['id']}";
                try
                {
                    $this->deleteZoom($path, []);
                } catch (Exception $zex)
                {
                    Log::error("ZOOM: {$ex->getMessage()}");
                }
            }
            Log::error("CREATE_CLASSROOM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $rules = [
                'id' => 'required',
                'title' => 'required',
                'startTime' => 'required',
                'duration' => 'required',
                'type' => 'required',
                'courseId' => 'required',
                'moduleId' => 'required',
                'topicId' => 'required',
            ];
            $this->validateData($request->all(), $rules);
            $classroomId = $request->get('id');
            $classroom = Classroom::query()->find($classroomId);
            if (!$classroom)
            {
                throw new Exception("Classroom not found!");
            }
            $topicId = $request->get('topicId');
            $topic = Topic::query()->find($topicId);
            if (!$topic)
            {
                throw new Exception("Topic not found!");
            }
            $startTime = Carbon::parse($request->get('startTime'));
            $title = $request->get('title');
            // we need to update the zoom meeting/webinar details

            // then we update the classroom details
            $classroom->title = $title;
            $classroom->topic_id = $topic->id;
            $classroom->remarks = $request->get('remarks');
            $classroom->start_time = $startTime;
            $classroom->duration = $request->get('duration');
            $classroom->end_time = $startTime->clone()->addMinutes($classroom->duration);
            $classroom->course_id = $request->get('courseId');
            $classroom->module_id = $request->get('moduleId');
            $classroom->save();

            return response()->json("Classroom reschedules for {$startTime->toDateTimeString()}");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_CLASSROOM: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    private function storeWebinar(Request $request)
    {
        $courseId = $request->get('courseId');
        $moduleId = $request->get('moduleId');
        $topicId = $request->get('topicId');
        $topic = Topic::query()->find($topicId);
        if (!$topic)
        {
            throw new Exception("Topic not found!");
        }
        $user = Sentinel::getUser();
        $duration = $request->get('duration');
        $title = $request->get('title');
        $startTime = Carbon::parse($request->get('startTime'));

        $meetingSettings = $this->getZoomMeetingSettings();
        $settings = Arr::only($meetingSettings, [
            "host_video",
            "panelists_video",
            "join_before_host",
            "mute_upon_entry",
            "watermark",
            "use_pmi",
            "approval_type",
            "registration_type",
            "practice_session",
            "audio",
            "auto_recording",
        ]);
        $zoomData = [
            'type' => Classroom::WEBINAR_SCHEDULE,
            'topic' => $topic->title,
            'agenda' => $title,
            'duration' => $duration,
            'start_time' => $startTime->toDateTimeLocalString(),
            'timezone' => $this->getAppTimeZone(),
            'settings' => $settings,
        ];

        $path = 'users/me/webinars';

        $responseData = $this->postZoom($path, $zoomData);

        // throw new Exception('Testing zoom delete!');

        $classroom = Classroom::query()->create([
            'title' => $title,
            'meeting_id' => $responseData['id'],
            'meeting_password' => $responseData['password'],
            'start_url' => $responseData['start_url'],
            'join_url' => $responseData['join_url'],
            'meeting_uuid' => $responseData['uuid'],
            'host_id' => $responseData['host_id'],
            'start_time' => $startTime,
            'duration' => $duration,
            'end_time' => $startTime->clone()->addMinutes($duration),
            'settings' => serialize($responseData['settings']),
            'remarks' => $request->get('remarks'),
            'course_id' => $courseId,
            'module_id' => $moduleId,
            'topic_id' => $topicId,
            'type' => 'webinar',
            'instructor_id' => $user->getUserId(),
        ]);
        return $responseData;
    }

    private function storeMeeting(Request $request)
    {
        $courseId = $request->get('courseId');
        $moduleId = $request->get('moduleId');
        $topicId = $request->get('topicId');
        $topic = Topic::query()->find($topicId);
        if (!$topic)
        {
            throw new Exception("Topic not found!");
        }
        $user = Sentinel::getUser();
        $duration = $request->get('duration');
        $title = $request->get('title');
        $startTime = Carbon::parse($request->get('startTime'));

        $meetingSettings = $this->getZoomMeetingSettings();
        $settings = Arr::only($meetingSettings, [
            "host_video",
            "participant_video",
            "join_before_host",
            "waiting_room",
            "mute_upon_entry",
            "watermark",
            "use_pmi",
            "approval_type",
            "registration_type",
            "audio",
            "auto_recording",
        ]);
        $zoomData = [
            'type' => Classroom::MEETING_TYPE_SCHEDULE,
            'topic' => $topic->title,
            'agenda' => $title,
            'duration' => $duration,
            'start_time' => $startTime->toDateTimeLocalString(),
            'timezone' => $this->getAppTimeZone(),
            'settings' => $settings,
        ];

        $path = 'users/me/meetings';

        $responseData = $this->postZoom($path, $zoomData);

        // throw new Exception('Testing zoom delete!');

        $classroom = Classroom::query()->create([
            'title' => $title,
            'meeting_id' => $responseData['id'],
            'meeting_password' => $responseData['password'],
            'start_url' => $responseData['start_url'],
            'join_url' => $responseData['join_url'],
            'meeting_uuid' => $responseData['uuid'],
            'host_id' => $responseData['host_id'],
            'start_time' => $startTime,
            'duration' => $duration,
            'end_time' => $startTime->clone()->addMinutes($duration),
            'settings' => serialize($responseData['settings']),
            'remarks' => $request->get('remarks'),
            'course_id' => $courseId,
            'module_id' => $moduleId,
            'topic_id' => $topicId,
            'type' => 'meeting',
            'instructor_id' => $user->getUserId(),
        ]);
        return $responseData;
    }

    public function getZoomToken(Request $request)
    {
        $minutes = $request->get('minutes') ?: 5;
        return $this->generateZoomToken($minutes);
    }

    public function zoomClassroom(Request $request)
    {
        try
        {
            $classroomId = $request->get('classroomId');
            $classroom = Classroom::query()->find($classroomId);
            if (!$classroom)
            {
                throw new Exception('Classroom not found!');
            }
            $loggedInUser = Sentinel::getUser();
            $user = new stdClass();
            $user->id = $loggedInUser->getUserId();
            $user->fullName = $loggedInUser->fullName();
            $user->email = $loggedInUser->email;
            $user->username = $loggedInUser->username;
            $user->avatar = $loggedInUser->avatar;
            $user->isStudent = $loggedInUser->inRole('student') && $loggedInUser->group == 'learners';
            $user->settings = [
                "isSupportAV" => true, // Enable or disable if you want use audio and video feature.
                "isSupportChat" => !$user->isStudent, // Enable or disable if you want use chat feature.
                "isSupportQA" => !$user->isStudent, // Enable or disable if you want use Webinar Q&A feature.
                "screenShare" => !$user->isStudent, // Enable or disable if you want use browser feature(only chrome).
                "disableInvite" => $user->isStudent, // Enable or disable invite function.
                //"disableCallOut" => $user->isStudent, // Enable or disable call out function.
                "disableRecord" => $user->isStudent, // Enable or disable record function.
                "disableJoinAudio" => $user->isStudent, // Enable or disable join audio function.
                //"disableReport" => $user->isStudent, // Enable/Disable Report feature.
            ];
            $data = [
                'user' => $user,
                'classroom' => $classroom->getDetails(),
            ];
            return view('admin.zoom-class', $data);
        } catch (Exception $ex)
        {
            return view('admin.zoom-class-error')->with('error', "Live session: {$ex->getMessage()}");
        }
    }
}
