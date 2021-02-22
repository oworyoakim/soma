<?php

namespace App\Models;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Classroom
 * @package App\Models
 * @property int id
 * @property int course_id
 * @property int module_id
 * @property int topic_id
 * @property string title
 * @property string meeting_id
 * @property string meeting_password
 * @property string meeting_uuid
 * @property string recorded_video_path
 * @property int duration
 * @property Carbon start_time
 * @property Carbon end_time
 * @property string status
 * @property string remarks
 * @property string options
 * @property string join_url
 * @property string start_url
 * @property string host_id
 * @property string type
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Classroom extends Model
{
    protected $table = 'classrooms';

    protected $dates = ['start_time', 'end_time'];
    // Meeting types
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
    // Webinar types
    const WEBINAR_SCHEDULE = 5;
    const WEBINAR_RECURRING_WITH_NO_FIXED_TIME = 6;
    const WEBINAR_RECURRING_WITH_FIXED_TIME = 9;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    /**
     * @return stdClass
     */
    public function getDetails($loggedInUser = null)
    {
        $classroom = new stdClass();
        $classroom->id = $this->id;
        $classroom->courseId = $this->course_id;
        $classroom->moduleId = $this->module_id;
        $classroom->topicId = $this->topic_id;
        $classroom->title = $this->title;
        $classroom->meetingId = $this->meeting_id; // 83266570809
        $classroom->meetingPassword = $this->meeting_password;
        $classroom->meetingUuid = $this->meeting_uuid;
        $classroom->joinUrl = $this->join_url;
        $classroom->startUrl = $this->start_url;
        if (!$loggedInUser)
        {
            $wcUrl = null;
        } else
        {
            if ($loggedInUser->id == $this->instructor_id)
            {
                $wcUrl = "https://zoom.us/wc/{$this->meeting_id}/join?prefer=1&un={$loggedInUser->fullName()}";
            } else
            {
                $wcUrl = "https://zoom.us/wc/{$this->meeting_id}/join?un={$loggedInUser->fullName()}";
            }
        }
        $classroom->meetingUrl = $wcUrl;
        $classroom->hostId = $this->host_id;
        $classroom->duration = $this->duration;
        $classroom->startTime = !empty($this->end_time) ? $this->start_time->toDateTimeString() : null;
        $classroom->endTime = !empty($this->end_time) ? $this->end_time->toDateTimeString() : null;
        $classroom->status = $this->status;
        $classroom->remarks = $this->remarks;
        $classroom->type = $this->type;
        $classroom->options = !empty($this->options) ? unserialize($this->options) : null;
        $classroom->recordedVideoPath = $this->recorded_video_path;
        $classroom->createdAt = $this->created_at->toDateTimeString();
        $classroom->updatedAt = $this->updated_at->toDateTimeString();
        return $classroom;
    }
}
