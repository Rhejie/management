<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProponentResource extends JsonResource
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
        // $cost_center = $this->whenLoaded('cost_center');
        $rank = $this->whenLoaded('rank');
        $tagged_proponent = $this->whenLoaded('tagged_proponent');
        $type = $this->whenLoaded('type');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'proponent_number' => $this->proponent_number,
            'site' => SiteResource::make($site),
            // 'cost_center' => CostCenterResource::make($cost_center),
            'proponent_type_id' => $this->proponent_type_id,
            'proponent_type' => ProponentTypeResource::make($type),
            'rank' => RankResource::make($rank),
            'tagged_proponent' => ProponentResource::make($tagged_proponent),
            'sap_code' => $this->sap_code
        ];
    }
}
