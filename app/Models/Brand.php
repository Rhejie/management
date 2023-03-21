<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'name',
        // 'company_name',
        'sap_code',
        'asset_subclass_id'
    ];

    public function asset_class()
    {
        return $this->belongsToThrough('App\Models\AssetClass', ['App\Models\AssetSubclass']);
    }

    public function asset_subclass(){
        return $this->belongsTo('App\Models\AssetSubclass', 'asset_subclass_id');
    }

    public function brand_models(){
        return $this->hasMany('App\Models\BrandModel', 'brand_id');
    }
}
