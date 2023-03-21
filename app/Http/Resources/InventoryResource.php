<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AssetClass;
use App\Models\AssetSubclass;
use App\Models\Brand;
use App\Models\Site;

class InventoryResource extends JsonResource
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
            'brand_model' => $this->brand_model,
            'account_type' => $this->account_type,
            'brand_model_id' => $this->brand_model_id,
            'po_number_id' => $this->po_number_id,
            'purchase_order' => $this->purchase_order,
            'asset_class' => $this->asset_class,
            'asset_subclass' => $this->asset_subclass,
            'brand' => $this->brand,
            'segment_id' => $this->segment_id,
            'disposal' => $this->disposal,
            'assetable_type' => $this->assetable_type,
            'assetable_id' => $this->assetable_id,
            'isActive' => $this->isActive,
            'quantity' => $this->quantity,
            'sap_code' => $this->sap_code,
            'asset_type' => 1,
        ];

        //return parent::toArray($request);
    }
}
