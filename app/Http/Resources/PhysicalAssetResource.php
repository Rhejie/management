<?php

namespace App\Http\Resources;

use App\Http\Requests\AssetClassRequest;
use App\Models\AssetSubclass;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Brand;
use App\Models\AssetClass;
use App\Models\Site;
use App\Models\SoftwareLicense;

class PhysicalAssetResource extends JsonResource
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
            'quantity' => $this->quantity,
            'sap_code' => $this->sap_code,
            'asset_type' => 1,
        ];
        // $asset_class = $this->whenLoaded('assetClass');
        // $sub_class = $this->whenLoaded('assetSubclass');
        // $brand = $this->whenLoaded('brand');
        // $site = $this->whenLoaded('site');

        // return [
        //     'id' => $this->id,
        //     'asset_class' => new AssetClassResource($asset_class),
        //     'asset_subclass' => new AssetSubclassResource($sub_class),
        //     'brand' => new BrandResource($brand),
        //     'site' => new SiteResource($site),
        //     'name' => $this->name,
        //     'description' => $this->description,
        //     'po_number_id' => $this->po_number_id,
        //     'date_expired' => $this->date_expired,
        //     'quantity' => $this->quantity,
        //     'isActive' => $this->isActive,
        //     'availability' => $this->availability,
        //     'serial_number' => $this->serial_number,
        //     'asset_number' => $this->asset_number,
        //     'isPEZA' => $this->isPEZA,
        //     'isOPEX' => $this->isOPEX,
        //     'account_type' => $this->account_type,
        //     'sap_code' => $this->sap_code,
        // ];
    }
}
