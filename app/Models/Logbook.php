<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use stdClass;

/**
 * Class Logbook
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int student_id
 * @property int instructor_id
 * @property int flight_type_id
 * @property string start_time
 * @property string end_time
 * @property string aircraft
 * @property string landings
 * @property float duration
 * @property int approved_by
 * @property Carbon date_recorded
 * @property Carbon created_at
 */
class Logbook extends Model
{
    protected $table = 'logbooks';
    protected $dates = ['date_recorded'];

    public function flightType()
    {
        return $this->belongsTo(FlightType::class, 'fight_type_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDetails()
    {
        $logbook = new stdClass();
        $logbook->id = $this->id;
        $logbook->userId = $this->user_id;
        $logbook->user = ($this->user) ? $this->user->getInfo(false) : null;
        $logbook->studentId = $this->student_id;
        $logbook->student = ($this->student) ? $this->student->getInfo(false) : null;
        $logbook->instructor_id = $this->instructor_id;
        $logbook->instructor = ($this->instructor) ? $this->instructor->getInfo(false) : null;
        $logbook->date_recorded = $this->date_recorded->toDateString();

        $logbook->startTime = $this->start_time;
        $logbook->endTime = $this->end_time;
        $logbook->aircraft = $this->aircraft;
        $logbook->landings = $this->landings;
        $logbook->duration = $this->duration;

        $logbook->flightTypeId = $this->flight_type_id;
        $logbook->flightType = null;
        if ($this->flightType)
        {
            $logbook->flightType = new stdClass();
            $logbook->flightType->id = $this->flightType->id;
            $logbook->flightType->title = $this->flightType->title;
        }
        return $logbook;
    }
}
