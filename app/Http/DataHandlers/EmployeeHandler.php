<?php

namespace App\Http\DataHandlers;

use App\Models\CostCenter;
use App\Models\Site;
use App\Models\Campaign;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\FileRequest;
use App\Traits\ResultTrait;
// use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProponentsImport;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeHandler
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

    public function create(EmployeeRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$site = Site::with('campaigns')->find($request->site_id)) {
            return $this->result(true, (object)[
                'site_id' => ['Site not found']
            ]);
        }

        try {
            $campaign = $site->campaigns->find($request->campaign_id);

            if (!$campaign) {
                return $this->result(true, (object)[
                    'campaign_id' => ['Campaign not found']
                ]);
            }

            $campaign->employees()->create([
                'employee_number' => $request->proponent_number,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, (object)[
                'campaign_id' => ['Campaign not found']
            ]);
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

    public function update(EmployeeRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$site = Site::with('campaigns')->find($request->site_id)) {
            return $this->result(true, (object)[
                'site_id' => ['Site not found']
            ]);
        }

        if (!$campaign = $site->campaigns()->find($request->campaign_id)) {
            return $this->result(true, (object)[
                'site_id' => ['Campaign not found']
            ]);
        }

        try {

            $employee_for_update = Employee::findOrFail($request->id);
            $employee = Employee::where('email', $request->email)->first();

            if ($employee) {
                if ($employee_for_update->id != $employee->id) {
                    return $this->result(true, (object)[
                        'email' => ['Already taken']
                    ]);
                }
            }

            $employee_for_update->update([
                'employee_number' => $request->proponent_number,
                'name' => $request->name,
                'email' => $request->email,
                'campaign_id' => $request->campaign_id,
            ]);

            if ($employee_for_update->account) {
                $employee_for_update->account()->update([
                    'email' => $request->email,
                    'name' => $request->name,
                ]);
            }

            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, 'Employee not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(EmployeeRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$site = Site::with('campaigns')->find($request->site_id)) {
            return $this->result(true, 'Site not found');
        }

        try {
            $campaign = $site->campaigns()->findOrFail($request->id);
            $campaign->delete();
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
