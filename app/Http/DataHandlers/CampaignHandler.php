<?php

namespace App\Http\DataHandlers;

use App\Models\CostCenter;
use App\Models\Site;
use App\Models\Campaign;
use App\Http\Requests\CampaignRequest;
use App\Traits\ResultTrait;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CampaignHandler
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

    public function create(CampaignRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!CostCenter::find($request->cost_center_id)) {
            return $this->result(true, (object)[
                'site_id' => ['Cost Center not found']
            ]);
        }

        try {
            $site = Site::findOrFail($request->site_id);

            $site->campaigns()->create([
                'campaign_number' => $request->proponent_number,
                'name' => $request->name,
                'cost_center_id' => $request->cost_center_id,
            ]);

            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, (object)[
                'site_id' => ['Site not found']
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function update(CampaignRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!CostCenter::find($request->cost_center_id)) {
            return $this->result(true, (object)[
                'site_id' => ['Cost Center not found']
            ]);
        }

        if (!$site = Site::with('campaigns')->find($request->site_id)) {
            return $this->result(true, (object)[
                'site_id' => ['Site not found']
            ]);
        }

        try {
            $campaign = $site->campaigns->findOrFail($request->id);
            $campaign->update([
                'campaign_number' => $request->proponent_number,
                'name' => $request->name,
                'cost_center_id' => $request->cost_center_id,
            ]);
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, (object)[
                'site_id' => ['Cost Center not found']
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function delete(CampaignRequest $request)
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
            $campaign = $site->campaigns()->findOrFail($request->id);
            $campaign->delete();
            return $this->result(false, 'Success');
        }
        catch(ModelNotFoundException $e) {
            return $this->result(true, (object)[
                'site_id' => ['Cost Center not found']
            ]);
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }
}
