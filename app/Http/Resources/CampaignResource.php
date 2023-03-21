<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $site = $this->whenLoaded('site');
        $costCenter = $this->whenLoaded('cost_center');
        $company = $this->whenLoaded('company');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'campaign_number' => $this->campaign_number,
            'site_id' => $this->site_id,
            'site' => SiteResource::make($site),
            'cost_center_id' => $this->cost_center_id,
            'cost_center' => CostCenterResource::make($costCenter),
            'company' => CompanyResource::make($company),
        ];
    }
}
