<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $builder = User::query();
            $users = $builder->get()->map(function (User $user){
                return $user->getInfo();
            });
            return response()->json($users);
        } catch (Exception $ex)
        {
            Log::error("GET_USERS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $this->validate($request,[
                'roleId' => 'required',
                'firstName' => 'required',
                'lastName' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
            ]);
            $roleId = $request->get('roleId');
            $role = Sentinel::getRoleRepository()->find($roleId);
            if(!$role){
               throw new Exception('Role not found!');
            }
            $user = Sentinel::registerAndActivate([
                'first_name' => $request->get('firstName'),
                'last_name' => $request->get('lastName'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'avatar' => '/images/avatar.png',
            ]);
            $role->users()->attach($user);
            return response()->json('User created!');
        }catch (Exception $ex)
        {
            Log::error("CREATE_USER: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }


}
