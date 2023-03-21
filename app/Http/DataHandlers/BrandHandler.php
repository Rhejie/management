<?php

namespace App\Http\DataHandlers;

use App\Models\Brand;
use App\Models\AssetSubclass;

use App\Http\Requests\BrandRequest;
// use App\Http\Requests\FileRequest;
use App\Traits\ResultTrait;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class BrandHandler
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

    public function create(BrandRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $subclass = AssetSubclass::findOrFail($request->asset_subclass_id);
            $brand = $subclass->brands()->firstOrCreate([
                'name' => $request->name,
            ]);
            return $this->result(false, ['id' => $brand->id]);
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, (object)[
                'asset_subclass_id' => ['Asset Subclass not found']
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(BrandRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$subclass = AssetSubclass::find($request->asset_subclass_id)) {
            return $this->result(true, (object)[
                'asset_subclass_id' => ['Asset Subclass not found']
            ]);
        }

        try {
            $brand = Brand::findOrFail($request->id);
            $brand->update([
                'name' => $request->name,
                'asset_subclass_id' => $request->asset_subclass_id,
                // 'company_name' => $request->company_name
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, (object)[
                'id' => ['Brand not found.']
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(BrandRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $AssetClass = Brand::findOrFail($request->id);
            $AssetClass->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Brand not found.');
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

    private function errors(BrandRequest $request)
    {
        //custom errrors scenarios
        $errors = [];

        return $errors;
    }
}
