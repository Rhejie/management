<?php

namespace App\Http\Resources;

use App\Http\Requests\AssetClassRequest;
use App\Models\AssetSubclass;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Brand;
use App\Models\AssetClass;
use App\Models\PurchaseOrder;
use App\Models\Segment;
use App\Models\Site;
use App\Models\SoftwareLicense;

class SoftwareLicenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $purchase_order = $this->whenLoaded('purchase_order');
        $asset_class = $this->whenLoaded('asset_class');
        $asset_subclass = $this->whenLoaded('asset_subclass');
        $brand = $this->whenLoaded('brand');
        $brand_model = $this->whenLoaded('brand_model');

        // $account_type = (object)[
        //     'id' => $this->account_type,
        //     'name' => SoftwareLicense::TYPES[$this->account_type]
        // ];

        return [
            'id' => $this->id,
            'brand_model' => BrandModelResource::make($brand_model),
            // 'account_type' => $account_type,
            'brand_model_id' => $this->brand_model_id,
            'po_number_id' => $this->po_number_id,
            'purchase_order' => PurchaseOrderResource::make($purchase_order),
            'asset_class' => AssetClassResource::make($asset_class),
            'asset_subclass' => AssetSubclassResource::make($asset_subclass),
            'brand' => BrandResource::make($brand),
            'segment_id' => $this->segment_id,
            'disposal' => $this->disposal,
            // 'asset_value' => $this->asset_value,
            // 'accounting_value' => $this->accounting_value,
            // 'accumulated_depreciation' => $this->accumulated_depreciation,
            // 'isPEZA' => $this->isPEZA,
            // 'lifespan' => $this->lifespan,
            'assetable_type' => $this->assetable_type,
            'assetable_id' => $this->assetable_id,
            'isActive' => $this->isActive,
            // 'quantity' => $this->quantity,
            'sap_code' => $this->sap_code,
            'asset_type' => 0,
        ];
    }
}
