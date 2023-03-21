<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $campaign = $this->whenLoaded('campaign');
        $site = $this->whenLoaded('site');
        $company = $this->whenLoaded('company');
        $cost_center = $this->whenLoaded('cost_center');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'employee_number' => $this->employee_number,
            'email' => $this->email,
            'campaign_id' => $this->campaign_id,
            'campaign' => CampaignResource::make($campaign),
            'site' => SiteResource::make($site),
            'company' => CompanyResource::make($company),
            'cost_center' => CostCenterResource::make($cost_center),
        ];
    }
}
