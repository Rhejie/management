<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sites = $this->whenLoaded('sites');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'company_code' => $this->company_code,
            'sites' => SiteResource::collection($sites),
        ];
    }
}
