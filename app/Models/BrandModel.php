<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class BrandModel extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'brand_id',
        'name',
        'other_name',
        'description',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function asset_class()
    {
        return $this->belongsToThrough('App\Models\AssetClass', ['App\Models\AssetSubclass', 'App\Models\Brand']);
    }

    public function asset_subclass()
    {
        return $this->belongsToThrough('App\Models\AssetSubclass', ['App\Models\Brand']);
    }

    public function purchase_orders()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'brand_model_id');
    }

    public function software_assets()
    {
        return $this->hasManyThrough('App\Models\SoftwareLicense', 'App\Models\PurchaseOrder', 'brand_model_id', 'po_number_id');
    }

    public function physical_assets()
    {
        return $this->hasManyThrough('App\Models\PhysicalAsset', 'App\Models\PurchaseOrder', 'brand_model_id', 'po_number_id');
    }

    public function all_assets()
    {
        return ($this->asset_class->asset_type_id == 0) ? $this->software_assets() : $this->physical_assets();
    }

    public function latest_asset()
    {
        return ($this->asset_class->asset_type_id == 0) ? $this->latest_software() : $this->latest_physical();
    }

    public function latest_software()
    {
        // return $this->software_assets()->latest()->first();
        return $this->hasOneThrough('App\Models\SoftwareLicense', 'App\Models\PurchaseOrder', 'brand_model_id', 'po_number_id')->latest();
    }

    public function latest_physical()
    {
        // return $this->physical_assets()->latest()->first();
        return $this->hasOneThrough('App\Models\PhysicalAsset', 'App\Models\PurchaseOrder', 'brand_model_id', 'po_number_id')->latest();
    }

    public function latest_po()
    {
        return $this->hasOne('App\Models\PurchaseOrder', 'brand_model_id')->latest();
    }

    public function assets()
    {
        return $this->morphMany(QuantityAllocation::class, 'assetable');
    }

    public function software_tags(){
        return $this->hasManyDeep('App\Models\ProponentSoftwareTag',
            ['App\Models\PurchaseOrder', 'App\Models\SoftwareLicense'],
            ['brand_model_id', 'po_number_id']
        );
    }

    public function physical_asset_tags(){
        return $this->hasManyDeep('App\Models\ProponentPhysicalAssetTag',
            ['App\Models\PurchaseOrder', 'App\Models\PhysicalAsset'],
            ['brand_model_id', 'po_number_id']
        );
    }
}
