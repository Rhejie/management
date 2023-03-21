<?php

namespace App\Http\Controllers\Api;

use App\Models\PhysicalAsset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PhysicalAssetResource;

class PhysicalAssetController extends Controller
{
    public function all()
    {
        // return PhysicalAssetResource::collection(PhysicalAsset::all());
        return PhysicalAssetResource::collection(PhysicalAsset::with([
            'purchase_order', 'asset_class', 'asset_subclass', 'brand', 'brand_model',
        ])->get());
    }
}
