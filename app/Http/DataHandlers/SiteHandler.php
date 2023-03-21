<?php

namespace App\Http\DataHandlers;

use App\Models\Site;
use App\Models\Company;

use App\Http\Requests\SiteRequest;
use App\Traits\ResultTrait;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class SiteHandler
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

    public function create(SiteRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$company = Company::find($request->company_id)) {
            return $this->result(true, (object)[
                'company_id' => 'Company not found',
            ]);
        }

        $slug = preg_replace('/\s+/', '_', $request->name);

        try {
            $site = $company->sites()->where('name', $request->name)->first();
            if ($site) {
                return $this->result(true, (object)[
                    'proponent_name' => 'Name already taken',
                ]);
            }
            $company->sites()->create([
                'name' => $request->name,
                'slug' => strtolower($slug),
            ]);
            
            return $this->result(false, 'Success');
        } catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(SiteRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$company = Company::with('sites')->find($request->company_id)) {
            return $this->result(true, (object)[
                'company_id' => 'Company not found',
            ]);
        }

        $slug = preg_replace('/\s+/', '_', $request->name);

        try {
            $site = Site::findOrFail($request->id);
            $site->update([
                'company_id' => $request->company_id,
                'name' => $request->name,
                'slug' => strtolower($slug),
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, (object)[
                'id' => 'Site not found',
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(SiteRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        try {
            $site = Site::findOrFail($request->id);
            $site->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, (object)[
                'id' => 'Site not found',
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }
}
