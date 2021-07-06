<?php

namespace App\Http\Controllers;

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class AccountController extends Controller
{

    public function index()
    {
        if (!Sentinel::check())
        {
            Sentinel::logout(null, true);
            return redirect()->route('login');
        }
        if (Sentinel::inRole('student'))
        {
            return redirect()->intended(route('student.dashboard'));
        }
        return redirect()->intended(route('admin.dashboard'));
    }

    public function login()
    {
        if (Sentinel::check())
        {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function processLogin(Request $request)
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
                'group' => User::ACCOUNT_TYPE_LEARNERS
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
            Log::error("PROCESS_LOGIN: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function processInstructorLogin(Request $request)
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
                'group' => User::ACCOUNT_TYPE_INSTRUCTORS
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
            Log::error("PROCESS_LOGIN: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }


    public function getUserData()
    {
        try
        {
            if(!$loggedInUser = Sentinel::check()){
                return response()->json(false);
            }
            $user = new stdClass();
            $user->id = $loggedInUser->getUserId();
            $user->firstName = $loggedInUser->first_name;
            $user->lastName = $loggedInUser->last_name;
            $user->username = $loggedInUser->username;
            $user->email = $loggedInUser->email;
            $user->avatar = $loggedInUser->avatar;
            $user->isAdmin = Sentinel::inRole('admin');
            $user->isInstructor = Sentinel::inRole('instructor');
            $user->isStudent = Sentinel::inRole('student');
            $user->tinymceApiKey = null;
            if ($user->isAdmin || $user->isInstructor)
            {
                $user->tinymceApiKey = env("TINYMCE_API_KEY");
            }
            $user->permissions = $loggedInUser->getPermissions();
            if ($role = $loggedInUser->roles()->first())
            {
                $user->permissions = array_merge($user->permissions, $role->getPermissions());
            }
            return response()->json($user);
        } catch (Exception $ex)
        {
            Log::error("PROCESS_LOGIN: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }


    public function logout(Request $request)
    {
        $user = Sentinel::getUser();
        Sentinel::logout($user, true);
        $request->session()->forget('url.intended');
        return response()->json("Logged Out!");
    }
}
