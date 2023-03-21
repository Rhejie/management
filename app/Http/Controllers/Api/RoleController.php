<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;

use App\Http\DataHandlers\RoleHandler;

class RoleController extends Controller
{
    
    public function index()
    {
        return RoleResource::collection(Role::with('permissions')->where('name', '!=', 'Super Admin')->get());
    }

    public function createWithPermissions(RoleRequest $request, RoleHandler $handler)
    {
        return $handler->create($request);
    }

    public function updateWithPermissions(RoleRequest $request, RoleHandler $handler)
    {
        return $handler->update($request);
    }

    public function assignRole(UserRequest $request, RoleHandler $handler)
    {
        return $handler->assignRole($request);
    }

    public function revokeRole(UserRequest $request, RoleHandler $handler)
    {
        return $handler->revokeRole($request);
    }

    public function roleWithPermissions(Role $role)
    {
        return RoleResource::make($role->load('permissions'));
    }
}
