<?php


namespace App\Traits;


use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;

trait ZoomJWT
{
    private function getAppTimeZone()
    {
        return env('APP_TIME_ZONE', 'UTC');
    }

    private function getZoomUrl()
    {
        return env('ZOOM_API_URL', "https://api.zoom.us/v2/");
    }

    /**
     * @param int $minutes
     * The lifetime of the token from the current timestamp in minutes
     * @return string
     */
    private function generateZoomToken($minutes = 1)
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => Carbon::now()->addMinutes($minutes)->getTimestamp(),
        ];
        return JWT::encode($payload, $secret, 'HS256');
    }

    private function getZoomRequestHeaders(){
        $token = $this->generateZoomToken();
        return [
            'authorization' => "Bearer {$token}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    private function getZoomMeetingSettings()
    {
        return [
            /**
             * Use Personal Meeting ID instead of an automatically generated meeting ID.
             * It can only be used for scheduled meetings, instant meetings and recurring meetings with no fixed time.
             */
            "use_pmi" => false,
            /**
             * Start video when the host joins the meeting
             */
            "host_video" => false,
            /**
             * Start panelists video when they join
             */
            "panelists_video" => true,
            /**
             * Start video when participants join the meeting
             */
            "participant_video" => false,
            /**
             * Allow participants to join the meeting before the host starts the meeting.
             * This field can only be used for scheduled or recurring meetings.
             * Note: If waiting room is enabled, the join before host setting will be disabled.
             */
            "join_before_host" => false,
            /**
             * Enable waiting room. Note that if the value of this field is set to true, it will override and disable the join_before_host setting.
             */
            "waiting_room" => true,
            /**
             * Mute participants upon entry
             */
            "mute_upon_entry" => true,
            /**
             * Enable practice session
             */
            "practice_session" => false,
            /**
             * 0 - Automatically approve.
             * 1 - Manually approve.
             * 2 - No registration required
             */
            "approval_type" => 2,
            /**
             * Alternative host's emails or IDs: multiple values separated by a comma.
             */
            "alternative_hosts" => "",
            /**
             * Determine how participants can join the audio portion of the meeting.
             * both - Both Telephony and VoIP.
             * telephony - Telephony only.
             * voip - VoIP only.
             */
            "audio" => "both",
            /**
             * Automatic recording:
             * local - Record on local.
             * cloud -  Record on cloud.
             * none - Disabled.
             */
            "auto_recording" => "local",
            /**
             * Close registration after event date
             */
            "close_registration" => false,
            /**
             * Send email notifications to registrants about approval, cancellation, denial of the registration.
             * The value of this field must be set to true in order to use the registrants_confirmation_email field.
             */
            "registrants_confirmation_email" => false,
            /**
             * Send email notifications to registrants about approval, cancellation, denial of the registration.
             * The value of this field must be set to true in order to use the registrants_confirmation_email field.
             */
            "registrants_email_notification" => false,
            /**
             * Add watermark when viewing a shared screen.
             */
            "watermark" => false,
            /**
             * Only [authenticated](https://support.zoom.us/hc/en-us/articles/360037117472-Authentication-Profiles-for-Meetings-and-Webinars) users can join meeting if the value of this field is set to true.
             */
            "meeting_authentication" => false,
            /**
             * If set to `true`, the registration page for the meeting will include social share buttons.
             * Note: This setting is only applied for meetings that have enabled registration.
             */
            "show_share_button" => false,
            /**
             * If set to true, attendees will be allowed to join a meeting from multiple devices.
             * Note: This setting is only applied for meetings that have enabled registration.
             */
            "allow_multiple_devices" => false,
        ];
    }
}
