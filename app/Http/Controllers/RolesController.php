<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RolesController extends Controller
{

    public function index(Request $request)
    {
        try
        {
            $roles = Role::all()->map(function (Role $role) {
                return $role->getDetails();
            });
            $permissions = Permission::query()
                                     ->where('parent_id', 0)
                                     ->get()
                                     ->map(function (Permission $parent) {
                                         $permission = $parent->getDetails();
                                         $permission->children = Permission::query()
                                                                           ->where('parent_id', $parent->id)
                                                                           ->get()
                                                                           ->map(function (Permission $child) {
                                                                               return $child->getDetails();
                                                                           });
                                         return $permission;
                                     });
            $data = [
                'roles' => $roles,
                'permissions' => $permissions,
            ];
            return response()->json($data);
        } catch (Exception $ex)
        {
            Log::error("GET_ROLES: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'name' => 'required',
            ]);

            $name = $request->get('name');
            $slug = Str::slug($name);

            if ($oldRole = Role::whereSlug($slug)->first())
            {
                throw new Exception("Role {$name} already exists!");
            }

            $role = Role::create([
                'name' => $name,
                'slug' => $slug,
            ]);
            //$role = Sentinel::getRoleRepository()->findBySlug($slug);
            $permissions = $request->get('permissions') ?? [];
            $role->setPermissions($permissions);
            return response()->json("Role created!");
        } catch (Exception $ex)
        {
            Log::error("CREATE_ROLE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->get('id');
            $role = Role::find($id);

            if (!$role)
            {
                throw new Exception('Role not found!');
            }
            $name = $request->get('name');
            $slug = Str::slug($name);

            $oldRole = Role::whereSlug($slug)->first();
            if ($oldRole && $oldRole->id != $role->id)
            {
                throw new Exception("Role {$name} already exists!");
            }

            $role->name = $name;
            $role->slug = $slug;
            $role->save();

            return response()->json("Role updated!");
        } catch (Exception $ex)
        {
            Log::info("UPDATE_ROLE: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function updatePermissions(Request $request)
    {
        try
        {
            $request->validate([
                'id' => 'required',
            ]);

            $roleId = $request->get('id');
            $role = Role::find($roleId);

            if (!$role)
            {
                throw new Exception("Role not found!");
            }

            $permissions = $request->get('permissions') ?? [];
            $role->permissions = [];
            foreach ($permissions as $permission)
            {
                $role->addPermission($permission);
            }

            $role->save();

            return response()->json("Role permissions updated!");
        } catch (Exception $ex)
        {
            Log::error("UPDATE_PERMISSIONS: {$ex->getMessage()}");
            return response()->json($ex->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
