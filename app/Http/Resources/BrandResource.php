<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BrandModel;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $brand_models = $this->whenLoaded('brand_models');
        $asset_subclass = $this->whenLoaded('asset_subclass');
        $asset_class = $this->whenLoaded('asset_class');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'asset_class' => AssetClassResource::make($this->asset_class),
            'asset_subclass_id' => $this->asset_subclass_id,
            // 'asset_subclass' => AssetSubclassResource::make($asset_subclass),
            'asset_subclass' => AssetSubclassResource::make($this->asset_subclass),
            'brand_models' => BrandModelResource::collection($brand_models),
            // 'company_name' => $this->company_name,
        ];
    }
}
