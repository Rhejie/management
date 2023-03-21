<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetSubclass;
use App\Models\AssetClass;
use App\Http\Requests\AssetSubclassRequest;
use App\Http\Resources\AssetSubclassResource;
use App\Http\DataHandlers\AssetSubClassHandler;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssetSubclassController extends Controller
{
    public function index()
    {
        return AssetSubclassResource::collection(AssetSubclass::all());
    }

    public function view($asset_class_id){
        try {
            return AssetSubclassResource::collection(AssetClass::find($asset_class_id)->subClasses);
        } catch (ModelNotFoundException $th) {
            return response()->json([]);
        }
    }

    public function create(AssetSubclassRequest $request, AssetSubClassHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(AssetSubclassRequest $request, AssetSubClassHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(AssetSubclassRequest $request, AssetSubClassHandler $handler)
    {
        return $handler->delete($request);
    }
}
