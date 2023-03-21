<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalAsset extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        // 'asset_class_id',
        // 'asset_subclass_id',
        // 'brand_id',
        // 'site_id',
        // 'name',
        // 'description',
        // 'po_number_id',
        // 'date_expired',
        // 'quantity',
        // 'isActive',
        // 'availability',
        // 'serial_number',
        // 'asset_number',
        // 'isPEZA',
        // 'isOPEX',
        // 'account_type',
        // 'sap_code',

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

    // public function brand()
    // {
    //     return $this->belongsTo('App\Models\Brand', 'brand_id');
    // }

    // public function assetClass()
    // {
    //     return $this->belongsTo('App\Models\AssetClass', 'asset_class_id');
    // }

    // public function assetSubclass()
    // {
    //     return $this->belongsTo('App\Models\AssetSubclass', 'asset_subclass_id');
    // }

    // public function sites()
    // {
    //     return $this->belongsTo('App\Models\Site', 'site_id');
    // }
}
