<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuantityAllocation;
use App\Http\Resources\QuantityAllocationResource;
use App\Http\Requests\QuantityAllocationRequest;
use App\Http\DataHandlers\QuantityAllocationHandler;

class InventoryQuantityAllocationController extends Controller
{
    
    public function index()
    {
        return QuantityAllocationResource::collection(QuantityAllocation::all());
    }

    public function view($company_id)
    {
        return new QuantityAllocationResource(QuantityAllocation::findOrFail($company_id));
    }

    public function save(QuantityAllocationRequest $request, QuantityAllocationHandler $handler)
    {
        return $handler->save($request);
    }

    public function get($asset_id)
    {
        return QuantityAllocationResource::collection(QuantityAllocation::where('assetable_id',$asset_id)->get());
    }
}
