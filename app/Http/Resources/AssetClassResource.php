<?php

namespace App\Http\Resources;

use App\Models\AssetClass;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AssetSubclass;
use App\Http\Resources\SoftwareLicenseResource;
use App\Models\SoftwareLicense;

class AssetClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sub_classes = $this->whenLoaded('subClasses');
        
        return [
            'asset_type_id' => $this->asset_type_id,
            'id' => $this->id,
            'name' => $this->name,
            'sub_classes' => AssetSubclassResource::collection($sub_classes),
            'sap_code' => $this->sap_code,
            //'sub_class' => new AssetSubclassResource(AssetSubclass::find($this->asset_subclass_id)),
        ];
    }
}
