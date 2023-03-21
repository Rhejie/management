<?php

namespace App\Http\DataHandlers;

use App\Models\AssetSubclass;
use App\Models\AssetClass;
use App\Http\Requests\AssetSubclassRequest;
// use App\Http\Requests\FileRequest;
use App\Traits\ResultTrait;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssetSubClassHandler
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

    public function create(AssetSubclassRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if($errors = $this->errors($request)) {
            return $this->result(true, $errors);
        }

        try {
            $AssetSubClass = AssetSubclass::firstOrCreate([
                'asset_class_id' => $request->asset_class_id,
                'name' => $request->name,
                'extension' => $request->extension
            ]);
            return $this->result(false, ['id' => $AssetSubClass->id]);
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(AssetSubclassRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if ($errors = $this->errors($request)) {
            return $this->result(true, $errors);
        }

        try {
            $AssetSubClas = AssetSubclass::findOrFail($request->id);
            $AssetSubClas->update([
                'asset_class_id' => $request->asset_class_id,
                'name' => $request->name,
                'extension' => $request->extension,
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

    public function delete(AssetSubclassRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if ($errors = $this->errors($request)) {
            return $this->result(true, $errors);
        }

        try {
            $AssetSubclass = AssetSubclass::findOrFail($request->id);
            $AssetSubclass->delete();
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

    private function errors(AssetSubclassRequest $request)
    {
        //custom errors scenarios
        $errors = [];

        if($request->getMethod() === "POST" || $request->getMethod() === "PATCH")
            if(!AssetClass::find($request->asset_class_id))
                $errors[] = "Asset class not found.";

        return $errors;
    }
}
