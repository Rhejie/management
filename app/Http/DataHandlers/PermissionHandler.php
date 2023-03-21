<?php

namespace App\Http\DataHandlers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Requests\PermissionRequest;
use App\Traits\ResultTrait;

class PermissionHandler
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

    public function create(PermissionRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            return $this->addPermissions($request->list);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(PermissionRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            if (!$permission = Permission::find($request->id)) {
                return $this->result(true, 'Permission not found');
            }
            $permission->update([
                'name' => $request->name,
            ]);

            return $this->result(false, 'Success');

        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(PermissionRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            if (!$permission = Permission::find($request->id)) {
                return $this->result(true, 'Permission not found');
            }
            $permission->delete();

            return $this->result(false, 'Success');
            
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    private function addPermissions($permissions)
    {
        for ($index=0; $index < count($permissions) ; $index++)
        {
            $permission = json_decode(json_encode($permissions[$index]), FALSE);
            Permission::create(['name' => $permission]);
        }

        return $this->result(false, 'Success');
    }
}
