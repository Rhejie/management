<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSubclass extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_class_id',
        'name',
        'extension',
        'sap_code',
    ];

    public function assetClass(){
        return $this->belongsTo('App\Models\AssetClass', 'asset_class_id');
    }

    public function brands(){
        return $this->hasMany('App\Models\Brand', 'asset_subclass_id');
    }
}
