<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssetSubclass;

class AssetClass extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'asset_type_id',
        'name',
        'sap_code',
    ];

    const ASSET_TYPE = [
        0 => 'Software License',
        1 => 'Physical Asset'
    ];

    public function subClasses(){
        return $this->hasMany('App\Models\AssetSubclass', 'asset_class_id');
        // return $this->hasMany(AssetSubclass::class);
    }

    public function brandModels()
    {
        return $this->hasManyDeep('App\Models\BrandModel', ['App\Models\AssetSubclass', 'App\Models\Brand']);
    }

    public function type(): String
    {
        try {
            return ASSET_TYPE[$this->asset_type_id];
        } catch (\Throwable $th) {
            return 'none';
        }
    }
}
