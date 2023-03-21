<?php

namespace App\Http\DataHandlers;

use App\Models\Proponent;
use App\Models\Company;
use App\Models\ProponentType;
use App\Models\Rank;
use App\Models\Site;

use App\Http\Requests\ProponentRequest;
use App\Http\Requests\FileRequest;
use App\Traits\ResultTrait;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProponentHandler
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

    public function create(ProponentRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {

            $errors = $this->errors($request);

            if ($request->company_id && !$company = Company::find($request->company_id)) {
                array_push($errors, 'Company not found');
            }

            if ($request->site_id && !$site = $company->sites()->find($request->site_id)) {
                array_push($errors, 'Site not found');
            }

            if (count($errors) > 0) {
                return $this->result(true, $errors);
            }

            if ($request->proponent_type_id == 3) {
                $site = $company->sites()->firstOrCreate([
                    'name' => $request->name,
                ],[
                    'slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'sap_code' => $request->sap_code,
                ]);
            }

            $site->proponents()->firstOrCreate([
                'name' => $request->name,
                'proponent_number' => $request->proponent_number,
                'cost_center_id' => $request->cost_center_id,
                'proponent_type_id' => $request->proponent_type_id,
                // 'rank_id' => $request->rank_id,
                'tagged_proponent_id' => $request->tagged_proponent_id,
                'sap_code' => $site->sap_code
            ]);

            return $this->result(false, 'Success');
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(ProponentRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        $errors = $this->errors($request);

        if ($request->site_id && !$site = Site::find($request->site_id)) {
            array_push($errors, 'Site not found');
        }

        if (count($errors) > 0) {
            return $this->result(true, $errors);
        }

        try {
            $proponent = Proponent::findOrFail($request->id);
            $proponent->update([
                'name' => $request->name,
                'proponent_number' => $request->proponent_number,
                'proponent_type_id' => $request->proponent_type_id,
                'cost_center_id' => $request->cost_center_id,
                'site_id' => $request->site_id,
                // 'rank_id' => $request->rank_id,
                'tagged_proponent_id' => $request->tagged_proponent_id,
                'sap_code' => $request->sap_code
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Asset user not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(ProponentRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $proponent = Proponent::findOrFail($request->id);
            $proponent->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Asset user not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function bulk(FileRequest $request)
    {
        try {
            $import = new ProponentsImport;

            $import->import($request->file('file'));

            $errors = [];

            foreach ($import->failures() as $failure) {
                array_push($errors, (object)[
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values()
                ]);
           }

           return (count($errors) > 0) ? $this->result(true, $errors) : $this->result(false, 'Success');

        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    private function errors(ProponentRequest $request)
    {
        $errors = [];

        if ($request->cost_center_id && !CostCenter::find($request->cost_center_id)) {
            array_push($errors, 'Cost Center not found');
        }

        if (!ProponentType::find($request->proponent_type_id)) {
            array_push($errors, 'Invalid type not found');
        }

        // if ($request->rank && !Rank::find($request->rank_id)) {
        //     array_push($errors, 'Rank not found');
        // }

        if ($request->tagged_proponent_id && !Proponent::find($request->tagged_proponent_id)) {
            array_push($errors, 'Asset holder not found');
        }

        return $errors;
    }
}
