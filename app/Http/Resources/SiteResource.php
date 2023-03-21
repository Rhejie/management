<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $company = $this->whenLoaded('company');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'company_id' => $this->company_id,
            'company' => CompanyResource::make($company),
        ];
    }
}
