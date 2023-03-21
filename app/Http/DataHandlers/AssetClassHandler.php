<?php

namespace App\Http\DataHandlers;

// use App\Models\Proponent;
// use App\Models\CostCenter;
use App\Models\AssetClass;
// use App\Models\Rank;
// use App\Models\Site;

use App\Http\Requests\AssetClassRequest;
// use App\Http\Requests\FileRequest;
use App\Traits\ResultTrait;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssetClassHandler
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

    public function create(AssetClassRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $AssetClass = AssetClass::firstOrCreate([
                'asset_type_id' => $request->asset_type_id,
                'name' => $request->name,
                'sap_code' => $request->sap_code,
            ]);
            return $this->result(false, ['id' => $AssetClass->id]);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(AssetClassRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $AssetClass = AssetClass::findOrFail($request->id);
            $AssetClass->update([
                'asset_type_id' => $request->asset_type_id,
                'name' => $request->name,
                'sap_code' => $request->sap_code,
            ]);
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

    public function delete(AssetClassRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $AssetClass = AssetClass::findOrFail($request->id);
            $AssetClass->delete(); //also delete sub classes
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Asset class not found.');
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

    private function errors(AssetClassRequest $request)
    {
        //custom errrors scenarios
        $errors = [];

        return $errors;
    }
}
