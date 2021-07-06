<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Level;
use App\Models\Student;
use App\Models\Topic;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminController extends Controller
{
    protected $user = null;

    public function processAdminLogin(Request $request)
    {
        try
        {
            $loginName = $request->get('loginName');
            $password = $request->get('password');
            if (empty($loginName) || empty($password))
            {
                throw new Exception('Invalid Credentials!');
            }
            $credentials = [
                'username' => $loginName,
                'password' => $password,
            ];
            $user = User::firstWhere([
                'username' => $loginName,
                'group' => User::ACCOUNT_TYPE_ADMINS
            ]);

            if (!$user)
            {
                throw new Exception('Invalid credentials!');
            }
            $user = Sentinel::authenticate($credentials);
            if (!$user)
            {
                throw new Exception('Invalid credentials!');
            }
            return response()->json("You are Logged in!");
        }catch (Exception $ex){
            Log::error("PROCESS_ADMIN_LOGIN: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function dashboardStatistics(){
        $statistics =[
            "levels" => Level::count(),
            "courses" => Course::count(),
            "instructors" => Instructor::count(),
            "students" => Student::count(),
            "examsTaken" => 405,
            "ongoingClasses" => 6,
            "upcomingClasses" => 56,
            "topics" => Topic::count(),
        ];
        return response()->json($statistics);
    }
}
