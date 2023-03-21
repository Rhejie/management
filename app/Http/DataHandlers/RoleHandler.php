<?php

namespace App\Http\DataHandlers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Requests\RoleRequest;
use App\Http\Requests\UserRequest;
use App\Traits\ResultTrait;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleHandler
{
    use ResultTrait;

    public function __construct()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'error' => true,
            ]);
        }
    }

    public function create(RoleRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }
        if (Role::where('name', $request->name)->first()) {
            return $this->result(true, (object)[
                'name' => ['Name already taken'],
            ]);
        }

        try {
            $role = Role::create(['name' => $request->name]);
            return $this->addPermissions($role, $request->permissions);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(RoleRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $role = Role::findOrFail($request->id);
            $requested = Role::where('name', $request->name)->first();

            if ($requested && ($role->id != $requested->id)) {
                return $this->result(true, (object)[
                    'name' => ['Name already taken'],
                ]);
            }

            $role->update([
                'name' => $request->name
            ]);

            return $this->addPermissions($role, $request->permissions);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function assignRole(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$role = Role::find($request->role_id)) {
            return $this->result(true, 'Role not found');
        }

        try {
            $user = User::findOrFail($request->id);
            $user->syncRoles([$role->name]);
            return $this->result(false, 'Role has been added');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Unknown User');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function revokeRole(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $user = User::with('roles')->findOrFail($request->id);

            $user->syncRoles([]);

            return $this->result(false, 'Role has been revoked');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Unknown User');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    private function addPermissions($role, $permissions)
    {
        $errors = [];
        $list = [];
        for ($index=0; $index < count($permissions) ; $index++)
        {
            $requested_permission = json_decode(json_encode($permissions[$index]), FALSE);
            if (!$permission = Permission::find($requested_permission->id)) {
                array_push($errors, $requested_permission->name .' not found');
                continue;
            }

            array_push($list, $permission);

            // $role->givePermissionTo($permission->name);
        }

        $role->syncPermissions($list);

        return (count($errors) > 0) ? $this->result(true, $errors) : $this->result(false, 'Success');
    }
}
