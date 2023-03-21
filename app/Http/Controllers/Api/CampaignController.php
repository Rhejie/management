<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CostCenter;
use App\Models\Site;
use App\Models\Campaign;

use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Http\DataHandlers\CampaignHandler;

use App\Http\Requests\SearchRequest;

class CampaignController extends Controller
{
    public function all()
    {
        return CampaignResource::collection(Campaign::with(['site', 'cost_center'])->get());
    }

    public function siteCampaigns(Site $site)
    {
        return CampaignResource::collection($site->campaigns);
    }

    public function search(SearchRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }
        
        return CampaignResource::collection(Campaign::with(['company', 'cost_center'])->where('name', 'like', '%'.$request->search_name.'%')->get());
    }

    public function create(CampaignRequest $request, CampaignHandler $handler)
    {
        return $handler->create($request);
    }

    public function update(CampaignRequest $request, CampaignHandler $handler)
    {
        return $handler->update($request);
    }

    public function delete(CampaignRequest $request, CampaignHandler $handler)
    {
        return $handler->delete($request);
    }
}
