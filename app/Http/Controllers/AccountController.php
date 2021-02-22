<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class AccountController extends Controller
{
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

            if (Sentinel::check())
            {
                throw new Exception('Already Logged In!');
            }

            $loginName = $request->get('login_name');
            $password = $request->get('password');


            if (empty($loginName) || empty($password))
            {
                throw new Exception('Invalid Credentials!');
            }
            //dd($request->all());
            $credentials = [
                'username' => $loginName,
                'password' => $password,
            ];
            //dd($credentials);
            $user = Sentinel::authenticate($credentials);
            //dd($user);
            if (!$user)
            {
                throw new Exception('Invalid Credentials!');
            }
            return response()->json('Logged In!');
        } catch (Exception $ex)
        {
            Log::error("PROCESS_LOGIN: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }


    public function getUserData()
    {
        try
        {
            $loggedInUser = Sentinel::getUser();
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
