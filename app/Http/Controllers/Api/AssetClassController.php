<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetClass;

use App\Http\Requests\AssetClassRequest;
use App\Http\Resources\AssetClassResource;

use App\Http\DataHandlers\AssetClassHandler;

class AssetClassController extends Controller
{
    public function index()
    {
        // $isWithSubclass = $request->isWithSubclass;
        
        // $validator = Validator::make((array)[
        //     'isWithSubclass' => $isWithSubclass,
        // ],[
        //     'isWithSubclass' => 'required|in:true,false',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([]);
        // }
        
        // $assets = ($isWithSubclass == "true") ? AssetClass::with('subClasses')->get() : AssetClass::all();

        // return AssetClassResource::collection($assets);
        return AssetClassResource::collection(AssetClass::with('subClasses')->get());
    }

    public function searchByType($asset_type_id)
    {
        return AssetClassResource::collection(AssetClass::where('asset_type_id', $asset_type_id)->get());
    }

    public function create(AssetClassRequest $request, AssetClassHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(AssetClassRequest $request, AssetClassHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(AssetClassRequest $request, AssetClassHandler $handler)
    {
        return $handler->delete($request);
    }
}
