<?php

namespace App\Http\Resources;
use App\Models\Brand;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $brand = $this->whenLoaded('brand');
        $asset_class = $this->whenLoaded('asset_class');
        $asset_subclass = $this->whenLoaded('asset_subclass');
        $latest_po = $this->whenLoaded('latest_po');
        $purchase_orders = $this->whenLoaded('purchase_orders');
        // $software_assets = $this->whenLoaded('software_assets');
        // $physical_assets = $this->whenLoaded('physical_assets');
        $latest_asset = $this->whenLoaded('latest_asset');
        $assets = $this->whenLoaded('all_assets');

        // echo "<pre>";print_r($this->latest_asset());die;

        $collection = [
            'id' => $this->id,
            'brand' => BrandResource::make($brand),
            'asset_class' => AssetClassResource::make($asset_class),
            'asset_subclass' => AssetSubclassResource::make($asset_subclass),
            'latest_asset' => AssetResource::make($latest_asset),
            'latest_po' => PurchaseOrderResource::make($latest_po),
            'purchase_orders' => PurchaseOrderResource::collection($purchase_orders),
            // 'physical_assets' => PhysicalAssetResource::collection($physical_assets),
            // 'software_assets' => SoftwareLicenseResource::collection($software_assets),
            'assets' => SoftwareLicenseResource::collection($assets),
            'name' => $this->name,
            'other_name' => $this->other_name,
            'description' => $this->description,
        ];

        if (isset($this->purchase_orders_count)) {
            $collection['total_purchase_orders'] = (int)$this->purchase_orders_count;
        }

        if (isset($this->purchase_orders_sum_quantity)) {
            $collection['total_quantity'] = (int)$this->purchase_orders_sum_quantity;
        }

        if (isset($this->software_tags_count)) {
            $collection['total_tagged'] = (int)$this->software_tags_count;
        }

        if (isset($this->physical_asset_tags_count)) {
            $collection['total_tagged'] = (int)$this->physical_asset_tags_count;
        }

        return $collection;

        // if (isset($this->purchase_orders_sum_quantity)) {
        //     array_push($collection, (object)[
        //         'purchase_orders_sum_quantity' => $this->purchase_orders_sum_quantity
        //     ]);
        // }

        // return $collection;
    }
}
