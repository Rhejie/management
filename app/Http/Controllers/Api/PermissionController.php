<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\PermissionRequest;
use App\Http\DataHandlers\PermissionHandler;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function all()
    {
        return PermissionResource::collection(Permission::getPermissions());
    }

    public function userPermission()
    {
        return PermissionResource::collection(auth()->user()->getPermissionsViaRoles());
    }

    public function create(PermissionRequest $request, PermissionHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(PermissionRequest $request, PermissionHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(PermissionRequest $request, PermissionHandler $handler)
    {
        return $handler->delete($request);
    }
}
