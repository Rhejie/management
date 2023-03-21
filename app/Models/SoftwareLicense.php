<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use App\Models\AssetClass;
use App\Models\AssetSubclass;
use App\Models\Site;

class SoftwareLicense extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        // 'asset_class_id',
        // 'asset_subclass_id',
        // 'brand_id',
        // 'brand_model_id',
        // 'po_number_id',
        // 'name',
        // 'description',
        // 'segment_id',
        // 'isDisposal',
        // 'asset_value',
        // 'accounting_value',
        // 'accumulated_depreciation',
        // 'isPEZA',
        // 'lifespan',
        // 'mother_asset',
        // 'mother_asset_code',

        // 'account_type',
        'brand_model_id',
        'po_number_id',
        'segment_id',
        'disposal',
        // 'asset_value',
        // 'accounting_value',
        // 'accumulated_depreciation',
        // 'isPEZA',
        // 'lifespan',
        'assetable_type',
        'assetable_id',
        'isActive',
        // 'quantity',
        'sap_code',
    ];

    const TYPES = [
        0 => 'CAPEX',
        1 => 'OPEX'
    ];

    protected $guarded = [];

    public function assets()
    {
        return $this->morphMany(QuantityAllocation::class, 'assetable');
    }

    public function asset_class()
    {
        return $this->belongsToThrough('App\Models\AssetClass', ['App\Models\AssetSubclass', 'App\Models\Brand', 'App\Models\BrandModel']);
    }

    public function asset_subclass()
    {
        return $this->belongsToThrough('App\Models\AssetSubclass', ['App\Models\Brand', 'App\Models\BrandModel']);
    }

    public function brand()
    {
        return $this->belongsToThrough('App\Models\Brand', ['App\Models\BrandModel']);
    }

    public function brand_model()
    {
        return $this->belongsTo(BrandModel::class, 'brand_model_id');
    }

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_number_id');
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'assetable');
    }
}
