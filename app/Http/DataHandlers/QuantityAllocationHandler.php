<?php

namespace App\Http\DataHandlers;

use App\Models\QuantityAllocation;
use App\Http\Requests\QuantityAllocationRequest;
use App\Models\BrandModel;
use App\Models\PhysicalAsset;
use App\Models\SoftwareLicense;
// use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\ResultTrait;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuantityAllocationHandler
{
    use ResultTrait;

    protected $model;

    public function __construct()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function save(QuantityAllocationRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }
        
        if($errors = $this->errors($request))
            return $this->result(true,$errors);

        $entities = $request->entities;

        // return $this->result(true, $asset);
        $QuantityAllocation = $this->ModelExists($request);
        
        if(count($QuantityAllocation->get()) > 0)
        {
            try {
                foreach($entities as $entity)
                {
                    $QuantityAllocation = $QuantityAllocation->where('company_id', $entity['id'])->first();
                    $QuantityAllocation->update([
                        'quantity_allocation' => $entity['quantity'],
                    ]);
                }

                return $this->result(false, 'Success');
            } catch (\Throwable $th) {
                return $this->result(true, $th->getMessage());
            }
        }
        else
        {

            $asset = BrandModel::findOrFail($request->asset_id);

            try {
                DB::transaction(function() use ($entities,$asset) {
                    foreach($entities as $entity)
                    {
                        $asset->assets()->create([
                            'company_id' => $entity['id'],
                            'quantity_allocation' => $entity['quantity'],
                        ]);
                    }
                });

                return $this->result(false, 'Success');
            } catch (\Throwable $th) {
                return $this->result(true, $th->getMessage());
            }
        }
    }

    private function errors(QuantityAllocationRequest $request)
    {
        //custom errrors scenarios
        $errors = [];

        
        //check quantity availability
        // $asset = SoftwareLicense::where('asset_number', $request->asset_id)->first();
        $asset = BrandModel::with(['asset_class', 'asset_subclass', 'brand'])
                        ->withSum('purchase_orders', 'quantity')
                        ->get()
                        ->where('asset_class.asset_type_id', $request->asset_type_id)
                        ->where('id', $request->asset_id)
                        ->first();

        if(!$asset)
        {
            $errors[] = 'Asset not exists!';
            return $errors;
        }

        $entities = $request->entities;

        $totalRequest = 0;

        foreach($entities as $entity)
            $totalRequest += (int) $entity['quantity'];

        // return $this->result(true, ['request' => $totalRequest, 'asset' => $asset->purchase_orders_sum_quantity]);

        if( (int) $totalRequest > (int) $asset->purchase_orders_sum_quantity)
            $errors[] = 'Total request quantity is higher than remaining';
        
        return $errors;
    }

    private function ModelExists(QuantityAllocationRequest $request)
    {
        // $filter[] = ['assetable_id', $request->asset_id];

        // if($request->asset_type_id == 0){
        //     $filter[] = ['assetable_type', 'App\Models\SoftwareLicense'];
        // }
        
        return QuantityAllocation::where('assetable_id', $request->asset_id);
    }
}
