<?php

namespace App\Http\DataHandlers;

use App\Models\BrandModel;
use App\Models\Brand;
use App\Http\Requests\BrandModelRequest;
use App\Traits\ResultTrait;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class BrandModelHandler
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

    public function create(BrandModelRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if($errors = $this->errors($request)) {
            return $this->result(true, $errors);
        }

        try {
            $AssetSubClass = BrandModel::firstOrCreate([
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'other_name' => $request->other_name,
                'description' => $request->description,
            ]);
            return $this->result(false, ['id' => $AssetSubClass->id]);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(BrandModelRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if ($errors = $this->errors($request)) {
            return $this->result(true, $errors);
        }

        try {
            $AssetSubClas = BrandModel::findOrFail($request->id);
            $AssetSubClas->update([
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'other_name' => $request->other_name,
                'description' => $request->description,
            ]);

            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Asset sub class not found');
        }
        catch (\Throwable $th) 
        {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(BrandModelRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if ($errors = $this->errors($request)) {
            return $this->result(true, $errors);
        }

        try {
            $BrandModel = BrandModel::findOrFail($request->id);
            $BrandModel->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Asset sub class not found');
        }
        catch (\Throwable $th) 
        {
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

    private function errors(BrandModelRequest $request)
    {
        //custom errors scenarios
        $errors = [];

        if($request->getMethod() === "POST" || $request->getMethod() === "PATCH")
            if(!Brand::find($request->brand_id))
                $errors[] = "Asset class not found.";

        return $errors;
    }
}
