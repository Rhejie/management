<?php

namespace App\Http\DataHandlers;

use App\Models\SoftwareLicense;
use App\Models\PhysicalAsset;

use App\Http\Requests\PurchaseOrderRequest;
use App\Models\AssetSubclass;
use App\Models\AssetClass;
use App\Models\Brand;
use App\Models\PurchaseOrder;
use App\Models\Site;
use App\Models\Company;
use App\Traits\ResultTrait;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PurchaseOrderHandler
{
    use ResultTrait;

    public function __construct()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function create(PurchaseOrderRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        $errors = $this->errors($request);

        if(count((array)$errors) > 0)
        {
            return $this->result(true, $errors);
        }

        try {
            $purchaseOrder = PurchaseOrder::firstOrCreate([
                'company_id' => $request->company_id,
                'brand_model_id' => $request->brand_model_id,
                'po_number' => $request->po_number,
                'date_acquired' => $request->date_acquired,
                'expiration_date' => $request->date_expired,
                // 'asset_number' => $request->asset_number,
                'asset_value' => $request->asset_value,
                // 'accounting_value' => $request->accounting_value,
                // 'accumulated_depreciation' => $request->accumulated_depreciation,
                'isPEZA' => $request->isPEZA,
                'lifespan' => $request->lifespan,
                //always OPEX = 1
                'account_type' => 1,
                
                'serial_number' => $request->serial_number,
                'warranty_date' => $request->warranty_date,
                'warranty_description' => $request->warranty_description,
                'quantity' => $request->quantity,
            ]);

            if ($request->asset_type_id == 0) {
                $purchaseOrder->softwareLicenses()->firstOrCreate([
                    'brand_model_id' => $request->brand_model_id,
                    'segment_id' => $request->segment_id,
                    'disposal' => $request->isDisposal,
                    // 'asset_value' => $request->asset_value,
                    // 'accounting_value' => $request->accounting_value,
                    // 'accumulated_depreciation' => $request->accumulated_depreciation,
                    // 'isPEZA' => $request->isPEZA,
                    // 'lifespan' => $request->lifespan,
                    // 'quantity' => $request->quantity,
                    'isActive' => 1,
                ]);
            }else {
                $purchaseOrder->physicalAssets()->firstOrCreate([
                    'brand_model_id' => $request->brand_model_id,
                    'po_number_id' => $purchaseOrder->id,
                    'segment_id' => $request->segment_id,
                    'disposal' => $request->isDisposal,
                    // 'asset_value' => $request->asset_value,
                    // 'accounting_value' => $request->accounting_value,
                    // 'accumulated_depreciation' => $request->accumulated_depreciation,
                    // 'isPEZA' => $request->isPEZA,
                    // 'lifespan' => $request->lifespan,
                    'isActive' => 1,
                ]);
            }
            
            return $this->result(false, 'Success');
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }
    
    public function updateSummary(PurchaseOrderRequest $request) 
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $assetArg = [
                'brand_model_id' => $request->brand_model_id,
                'segment_id' => $request->segment_id,
                'disposal' => $request->isDisposal,
            ];

            $PurchaseOrder = PurchaseOrder::findOrFail($request->id);

            $PurchaseOrder->update([
                'company_id' => $request->company_id,
                'brand_model_id' => $request->brand_model_id,
                'serial_number' => $request->serial_number,
                'account_type' => $request->account_type,
                'po_number' => $request->po_number,
            ]);

            if($request->old_asset_type_id != $request->asset_type_id)
                $this->deleteOldAsset($request);

            if ($request->asset_type_id == 0) {
                $PurchaseOrder->softwareLicenses()->firstOrCreate($assetArg);
            } else {
                $PurchaseOrder->physicalAssets()->firstOrCreate($assetArg);
            }

            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Asset class1 not found.');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    private function createNewPurchaseOrder(PurchaseOrderRequest $request)
    {
        return PurchaseOrder::create([
            'company_id' => $request->company_id,
            'brand_model_id' => $request->brand_model_id,
            'po_number' => $request->po_number,
            'date_acquired' => $request->date_acquired,
            'expiration_date' => $request->date_expired,
            // 'asset_number' => $request->asset_number,
            'asset_value' => $request->asset_value,
            'accounting_value' => $request->accounting_value,
            'accumulated_depreciation' => $request->accumulated_depreciation,
            'isPEZA' => $request->isPEZA,
            'lifespan' => $request->lifespan,
            'account_type' => $request->account_type,
            
            'serial_number' => $request->serial_number,
            'warranty_date' => $request->warranty_date,
            'warranty_description' => $request->warranty_description,
            'quantity' => $request->quantity,
        ]);
    }

    private function deleteOldAsset(PurchaseOrderRequest $request)
    {
        if ($request->old_asset_type_id == 1) {
            $asset = PhysicalAsset::where('brand_model_id',$request->old_brand_model_id)
                ->where('po_number_id',$request->id)
                ->where('segment_id',$request->segment_id);
        } else {
            $asset = SoftwareLicense::where('brand_model_id',$request->old_brand_model_id)
                ->where('po_number_id',$request->id)
                ->where('segment_id',$request->segment_id);
        }

        $asset->delete();
    }
    

    private function assetExists(PurchaseOrderRequest $request)
    {
        if ($request->asset_type_id == 1) {
            return PhysicalAsset::where('brand_model_id',$request->old_brand_model_id)
                ->where('po_number_id',$request->id)
                ->where('segment_id',$request->segment_id)
                ->first();
        } else {
            return SoftwareLicense::where('brand_model_id',$request->old_brand_model_id)
                ->where('po_number_id',$request->id)
                ->where('segment_id',$request->segment_id)
                ->first();
        }
        // $filter[] = ['assetable_id', $request->asset_id];

        // if($request->asset_type_id == 0){
        //     $filter[] = ['assetable_type', 'App\Models\SoftwareLicense'];
        // }
        
        // return QuantityAllocation::where('assetable_id', $request->asset_id);
    }

    private function generateAssetNumber($length = 20)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    private function errors(PurchaseOrderRequest $request)
    {
        //custom errrors scenarios
        $errors = (object) null;

        $class = AssetClass::with('brandModels')->find($request->asset_class_id);
        if (!$class->brandModels->find($request->brand_model_id)) {
            $errors->brand_model_id = ['Asset Class does not exist.'];
        }
        if (!Company::find($request->company_id)) {
            $errors->company_id = ['Company does not exist.'];
        }

        $purchaseOrder = PurchaseOrder::where([
            'brand_model_id' => $request->brand_model_id,
            'po_number' => $request->po_number,
        ])->first();
        
        if ($purchaseOrder) {
            $errors->po_number = ['P.O number already exist.'];
        }

        if (isset($request->account_type)) {
            switch ($request->account_type)
            {
                case 0:
                    if ($request->asset_value < 10000) {
                        $errors->asset_value = ['Asset value should be greater than or equal to 10,000'];
                    }
                    break;
                case 1:
                    if ($request->asset_value >= 10000) {
                        $errors->asset_value = ['Asset value should be lesser than 10,000'];
                    }
                    break;
            }
        }

        return $errors;
    }
}
