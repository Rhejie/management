<?php

namespace App\Http\Resources;
use App\Models\AssetClass;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetSubclassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
           
        return [
            'id' => $this->id,
            'asset_class' => AssetClassResource::make(AssetClass::findOrFail($this->asset_class_id)),
            'name' => $this->name,
            'extension' => $this->extension,
        ];
    }
}
