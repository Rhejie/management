<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\Brand;
use App\Http\Requests\BrandModelRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\BrandModelResource;
use App\Http\DataHandlers\BrandModelHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BrandModelController extends Controller
{
    public function index()
    {
        return BrandModelResource::collection(BrandModel::with('brand')->get());
    }

    public function softwareInventory()
    {
        return BrandModelResource::collection(BrandModel::with(['asset_class', 'asset_subclass', 'brand', 'latest_po', 'latest_asset'])
                ->withSum('purchase_orders', 'quantity')
                ->withCount('software_tags')
                ->has('purchase_orders')
                ->get()
                ->where('asset_class.asset_type_id', 0)
                ->load('latest_po.company')
            );
    }

    public function brandModelSummary($brand_model_id)
    {
        return BrandModelResource::make(BrandModel::with(['asset_class', 'asset_subclass', 'brand', 'latest_po', 'latest_asset'])
            ->withSum('purchase_orders', 'quantity')
            ->find($brand_model_id)
        );
    }

    public function physicalAssetInventory()
    {
        return BrandModelResource::collection(BrandModel::with(['asset_class', 'asset_subclass', 'brand', 'latest_po', 'latest_asset'])
                ->withSum('purchase_orders', 'quantity')
                ->withCount('physical_asset_tags')
                ->has('purchase_orders')
                ->get()
                ->where('asset_class.asset_type_id', 1)
                ->load('latest_po.company')
            );
    }

    public function view($brand_id){
        try {
            return BrandModelResource::collection(Brand::find($brand_id)->brand_models->load('brand'));
        } catch (ModelNotFoundException $th) {
            return response()->json([]);
        }
    }

    public function search(SearchRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        return BrandModelResource::collection(BrandModel::where('name', 'like', '%'.$request->search_name.'%')->get());
    }

    public function searchAsset(SearchRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        return BrandModelResource::collection(BrandModel::with([
            'asset_class', 'asset_subclass', 'brand', 'purchase_orders',
            ])
                ->withSum('purchase_orders', 'quantity')
                ->withCount('software_tags')
                ->has('purchase_orders')
                ->where('name', 'like', '%'.$request->search_name.'%')
                ->get()
            );
    }

    public function create(BrandModelRequest $request, BrandModelHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(BrandModelRequest $request, BrandModelHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(BrandModelRequest $request, BrandModelHandler $handler)
    {
        return $handler->delete($request);
    }
}
