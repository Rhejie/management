<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'company_id',
        'brand_model_id',
        'po_number',
        'date_acquired',
        'expiration_date',
        // 'asset_number',
        'account_type',
        'asset_value',
        'accounting_value',
        'accumulated_depreciation',
        'isPEZA',
        'lifespan',
        
        'serial_number',
        'warranty_date',
        'warranty_description',
        'sap_code',
        'quantity',
    ];

    const TYPES = [
        0 => 'CAPEX',
        1 => 'OPEX'
    ];

    //add brand_model_id, relationship, resource, migration and controller
    //change ui for update

    public function physicalAssets(){
        return $this->hasMany('App\Models\PhysicalAsset', 'po_number_id');
    }

    public function softwareLicenses(){
        return $this->hasMany('App\Models\SoftwareLicense', 'po_number_id');
    }

    public function brand_model(){
        return $this->belongsTo('App\Models\BrandModel', 'brand_model_id');
    }

    public function assetClass()
    {
        return $this->belongsToThrough('App\Models\AssetClass', ['App\Models\AssetSubclass', 'App\Models\Brand', 'App\Models\BrandModel']);
    }

    public function company(){
        return $this->belongsTo('App\Models\Company', 'company_id');
    }
}
