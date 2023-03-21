<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandModelResource;
use App\Http\Resources\InventoryResource;
use App\Models\SoftwareLicense;
use App\Models\PhysicalAsset;
use App\Http\Resources\SoftwareLicenseResource;
use App\Http\Resources\PhysicalAssetResource;
use App\Models\BrandModel;

class InventoryController extends Controller
{
    public function index()
    {
        $software = SoftwareLicenseResource::collection(SoftwareLicense::with([
            'purchase_order', 'asset_class', 'asset_subclass', 'brand', 'brand_model',
        ])->get()->load('purchase_order.company'));
        
        $hardware = PhysicalAssetResource::collection(PhysicalAsset::with([
            'purchase_order', 'asset_class', 'asset_subclass', 'brand', 'brand_model',
        ])->get()->load('purchase_order.company'));

        return collect($software->merge($hardware));

        // return BrandModelResource::collection(BrandModel::with(['asset_class', 'asset_subclass', 'brand', 'latest_po'])
        //         ->withSum('purchase_orders', 'quantity')
        //         ->withCount('physical_asset_tags')
        //         ->has('purchase_orders')
        //         ->get()
        //         ->load('latest_po.company')
        //     );
        // return InventoryResource::collection($software->merge($hardware));
    }

    public function view($id)
    {
        //TODO ASSET_CODE
        return new InventoryResource(SoftwareLicense::findOrFail($id));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create(SoftwareLicenseRequest $request, SoftwareHandler $handler)
    // {
    //     return $handler->create($request);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\SoftwareLicense  $SoftwareLicense
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(SoftwareLicenseRequest $request, SoftwareHandler $handler)
    // {
    //     return $handler->update($request);
    // }
}
