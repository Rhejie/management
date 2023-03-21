<?php

namespace App\Http\DataHandlers;

use App\Models\SoftwareLicense;

use App\Http\Requests\SoftwareLicenseRequest;
use App\Models\AssetSubclass;
use App\Models\AssetClass;
use App\Models\Brand;
use App\Models\PurchaseOrder;
use App\Models\Site;
// use App\Http\Requests\FileRequest;
use App\Traits\ResultTrait;

use Illuminate\Support\Facades\DB;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class SoftwareHandler
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

    public function create(SoftwareLicenseRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if($errors = $this->errors($request))
        {
            return $this->result(true, $errors);
        }

        // return $this->result(false, $request->all());
        try {
            DB::transaction(function() use ($request) {
                $PO = PurchaseOrder::firstOrCreate([
                    'po_number' => $request->po_number,
                    'date_acquired' => $request->date_acquired,
                    'expiration_date' => $request->date_expired,
                    'asset_number' => $request->asset_number,
                    'serial_number' => $request->serial_number,
                    'quantity' => $request->quantity,
                    'warranty_date' => $request->warranty_date,
                    'warranty_description' => $request->warranty_description
                ]);

                $SoftwareLicense = SoftwareLicense::firstOrCreate([
                    'account_type' => $request->account_type,
                    'asset_class_id' => $request->asset_class_id,
                    'asset_subclass_id' => $request->asset_subclass_id,
                    'brand_id' => $request->brand_id,
                    'brand_model_id' => $request->brand_model_id,
                    'po_number_id' => $PO->id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'segment_id' => $request->segment_id,
                    // 'disposal' => $request->disposal ? 1 : 0,
                    'disposal' => $request->isDisposal,
                    'asset_value' => $request->asset_value,
                    'accounting_value' => $request->accounting_value,
                    'accumulated_depreciation' => $request->accumulated_depreciation,
                    'isPEZA' => $request->isPEZA,
                    'lifespan' => $request->lifespan,
                    'mother_asset' => $request->mother_asset,
                    'mother_asset_code' => $request->mother_asset_code,
                ]);
            });
            
            return $this->result(false, 'Success');
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(SoftwareLicenseRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $SoftwareLicense = SoftwareLicense::findOrFail($request->id);
            $SoftwareLicense->update([
                'asset_class_id' => $request->asset_class_id,
                'asset_subclass_id' => $request->asset_subclass_id,
                'brand_id' => $request->brand_id,
                'site_id' => $request->site_id,
                'name' => $request->name,
                'description' => $request->description,
                'po_number_id' => $request->po_number_id, //purchase_orders table
                'date_expired' => $request->date_expired,
                'quantity' => $request->quantity,
                'availability' => $request->availability,
                'serial_number' => $request->serial_number,
                'asset_number' => ($request->asset_number) ? $request->asset_number : $this->generateAssetNumber(),
                'isPEZA' => $request->isPEZA,
                'isOPEX' => $request->isOPEX,
                'account_type' => $request->account_type,
                'date_acquired' => $request->date_acquired,
                'segment_type' => 1,
                'warranty_date' => $request->warranty_date,
                'warranty_description' => $request->warranty_description,
                'asset_cost_center' => $request->asset_cost_center,
                'disposal' => $request->disposal,
                'asset_value' => $request->asset_value,
                'accounting_value' => $request->accounting_value,
                'accumulated_depreciation' => $request->accumulated_depreciation,
                'lifespan' => $request->lifespan,
                'mother_asset_code' => ($request->mother_asset_code) ? $request->mother_asset_code : $this->generateAssetNumber(),
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Software not found.');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    // public function bulk(FileRequest $request)
    // {
    //     try {
    //         $import = new ProponentsImport;

    //         $import->import($request->file('file'));

    //         $errors = [];

    //         foreach ($import->failures() as $failure) {
    //             array_push($errors, (object)[
    //                 'row' => $failure->row(),
    //                 'attribute' => $failure->attribute(),
    //                 'errors' => $failure->errors(),
    //                 'values' => $failure->values()
    //             ]);
    //        }

    //        return (count($errors) > 0) ? $this->result(true, $errors) : $this->result(false, 'Success');

    //     } catch (\Throwable $th) {
    //         return $this->result(true, $th->getMessage());
    //     }
    // }

    private function generateAssetNumber($length = 20)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    private function errors(SoftwareLicenseRequest $request)
    {
        //custom errrors scenarios
        $errors = [];

        if($request->asset_class_id && !AssetClass::find($request->asset_class_id))
            $errors[] = 'Asset Class not exists.';

        if($request->asset_subclass_id && !AssetSubclass::find($request->asset_subclass_id))
            $errors[] = 'Asset Sub Class not exists.';

        if($request->brand_id && !Brand::find($request->brand_id))
            $errors[] = 'Brand not exists.';

        if($request->site_id && !Site::find($request->site_id))
            $errors[] = 'Site not exists.';

        return $errors;
    }
}
