<?php

namespace App\Http\DataHandlers;

use App\Models\CostCenter;
use App\Models\Site;
use App\Http\Requests\CostCenterRequest;
use App\Traits\ResultTrait;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CostCenterHandler
{
    use ResultTrait;

    public function __construct()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'error' => true,
            ]);
        }
    }

    public function create(CostCenterRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $site = Site::findOrFail($request->site_id);
            $site->cost_centers()->firstOrCreate([
                'name'
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, 'Site not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(CostCenterRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$site = Site::with('sites')->find($request->site_id)) {
            return $this->result(true, 'Site not found');
        }

        try {
            $cost_center = $site->cost_centers()->findOrFail($request->id);
            $cost_center->update([
                'name' => $request->name,
                'sap_code' => $request->sap_code,
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, 'Cost Center not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(CostCenterRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $cost_center = $site->cost_centers()->findOrFail($request->id);
            $cost_center->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, 'Cost Center not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }
}
