<?php

namespace App\Http\Controllers\Api;

use App\Models\SoftwareLicense;
use Illuminate\Http\Request;
use App\Http\Resources\SoftwareLicenseResource;
use App\Http\Controllers\Controller;
use App\Http\DataHandlers\SoftwareHandler;
use App\Http\Requests\SoftwareLicenseRequest;

class SoftwareLicenseController extends Controller
{
    public function all()
    {
        // return SoftwareLicenseResource::collection(SoftwareLicense::all());
        return SoftwareLicenseResource::collection(SoftwareLicense::with([
            'purchase_order', 'asset_class', 'asset_subclass', 'brand', 'brand_model',
        ])->get());
    }

    public function view($id)
    {
        return new SoftwareLicenseResource(SoftwareLicense::findOrFail($id));
    }
    
    public function create(SoftwareLicenseRequest $request, SoftwareHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(SoftwareLicenseRequest $request, SoftwareHandler $handler)
    {
        return $handler->update($request);
    }
}
