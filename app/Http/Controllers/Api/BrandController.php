<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\AssetSubclass;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\DataHandlers\BrandHandler;

class BrandController extends Controller
{

    public function index()
    {
        return BrandResource::collection(Brand::with('asset_class')->get());
    }

    public function view($asset_subclass_id){
        try {
            return BrandResource::collection(AssetSubclass::find($asset_subclass_id)->brands);
        } catch (ModelNotFoundException $th) {
            return response()->json([]);
        }
    }

    public function create(BrandRequest $request, BrandHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(BrandRequest $request, BrandHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(BrandRequest $request, BrandHandler $handler)
    {
        return $handler->delete($request);
    }
}
