<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CostCenter;
use App\Models\Site;
use App\Http\Requests\CostCenterRequest;
use App\Http\Resources\CostCenterResource;
use App\Http\DataHandlers\CostCenterHandler;

class CostCenterController extends Controller
{
    public function all()
    {
        return CostCenterResource::collection(CostCenter::all());
    }

    public function create(CostCenterRequest $request, CostCenterHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(CostCenterRequest $request, CostCenterHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(CostCenterRequest $request, CostCenterHandler $handler)
    {
        return $handler->delete($request);
    }
}
