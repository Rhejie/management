<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BrandModel;
use App\Models\Company;
use App\Models\PurchaseOrder;

class PurchaseOrderResource extends JsonResource
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

        $account_type = (object)[
            'id' => $this->account_type,
            'name' => PurchaseOrder::TYPES[$this->account_type]
        ];

        return [
            'id' => $this->id,
            'po_number' => $this->po_number,
            'account_type' => $account_type,
            'date_acquired' => date('Y-m-d', strtotime($this->date_acquired)),
            'expiration_date' => date('Y-m-d', strtotime($this->expiration_date)),
            'isExpired' => ( strtotime('now') >= strtotime(date('Y-m-d', strtotime($this->expiration_date))) ) ? 'expired' : 'active',
            'now' => strtotime('today midnight'),
            'now2' => date('Y-m-d H:i:s', strtotime('today midnight')),
            'sED' => strtotime($this->expiration_date),
            'sED2' => date('Y-m-d H:i:s', strtotime($this->expiration_date)),
            // 'account_type' => $this->account_type,
            'asset_number' => $this->asset_number,
            'serial_number' => $this->serial_number,
            'quantity' => $this->quantity,
            'warranty_date' =>  date('Y-m-d', strtotime($this->warranty_date)),
            'warranty_description' => $this->warranty_description,
            'sap_code' => $this->sap_code,
            'asset_value' => $this->asset_value,
            'accounting_value' => $this->accounting_value,
            'accumulated_depreciation' => $this->accumulated_depreciation,
            'isPEZA' => $this->isPEZA,
            'lifespan' => $this->lifespan,
            'company' => CompanyResource::make($company),
            'brand_model' => new BrandModelResource(BrandModel::findOrFail($this->brand_model_id)),
        ];
    }
}
