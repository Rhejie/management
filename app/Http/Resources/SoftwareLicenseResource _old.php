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
        return [
            'id' => $this->id,
            'account_type' => $this->account_type == 1 ? 'CAPEX' : 'OPEX',
            'asset_class_id' => $this->asset_class_id,
            'class' => new AssetClassResource(AssetClass::findOrFail($this->asset_class_id)),
            'asset_subclass_id' => $this->asset_subclass_id,
            'subclass' => new AssetSubclassResource(AssetSubclass::findOrFail($this->asset_subclass_id)),
            'brand_id' => $this->brand_id,
            'brand' => new BrandResource(Brand::findOrFail($this->brand_id)),
            'name' => $this->name,
            'description' => $this->description,
            'po_number_id' => $this->po_number_id,
            'segment_id' => $this->segment_id,
            'segment' => new SegmentResource(Segment::findOrFail($this->segment_id)),
            'disposal' => $this->disposal,
            'asset_value' => $this->asset_value,
            'accounting_value' => $this->accounting_value,
            'accumulated_depreciation' => $this->accumulated_depreciation,
            'isPEZA' => $this->isPEZA,
            'lifespan' => $this->lifespan,
            'mother_asset' => $this->mother_asset,
            'mother_asset_code' => $this->mother_asset_code,
            'purchase_order' => new PurchaseOrderResource(PurchaseOrder::findOrFail($this->po_number_id)),

            // 'id' => $this->id,
            // 'asset_class_id' => $this->asset_class_id,
            // 'class' => new AssetClassResource(AssetClass::findOrFail($this->asset_class_id)),
            // 'subclass' => new AssetSubclassResource(AssetSubclass::findOrFail($this->asset_subclass_id)),
            // 'asset_subclass_id' => $this->asset_subclass_id,
            // 'brand' => new BrandResource(Brand::findOrFail($this->brand_id)),
            // 'brand_id' => $this->brand_id,
            // // 'site' => new SiteResource(Site::findOrFail($this->site_id)),
            // 'name' => $this->name,
            // 'description' => $this->description,
            // 'po_number_id' => $this->po_number_id,
            // 'date_expired' => $this->date_expired,
            // // 'quantity' => $this->quantity,
            // 'isActive' => $this->isActive,
            // 'availability' => $this->availability,
            // 'serial_number' => $this->serial_number,
            // 'asset_number' => $this->asset_number,
            // 'isPEZA' => $this->isPEZA,
            // 'isOPEX' => $this->isOPEX,
            // // 'account_type' => $this->account_type,
            // 'sap_code' => $this->sap_code,

            // 'date_acquired' => $this->date_acquired,
            // 'segment_type' => $this->segment,
            // 'warranty_date' => $this->warranty_date,
            // 'warranty_description' => $this->warranty_description,
            // 'asset_cost_center' => $this->asset_cost_center,
            // 'disposal' => $this->disposal,
            // 'asset_value' => $this->asset_value,
            // 'accounting_value' => $this->accounting_value,
            // 'accumulated_depreciation' => $this->accumulated_depreciation,
            // 'lifespan' => $this->lifespan,
            // 'mother_asset_code' => $this->mother_asset_code,
            // 'mother_asset' => '',
        ];

        // return parent::toArray($request);
    }
}
