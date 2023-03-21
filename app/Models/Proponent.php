<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'proponent_number',
        'site_id',
        // 'cost_center_id',
        'proponent_type_id',
        'rank_id',
        'tagged_proponent_id',
        'sap_code'
    ];

    // public function cost_center(){
    //     return $this->belongsTo('App\Models\CostCenter', 'cost_center_id');
    // }

    public function rank(){
        return $this->belongsTo('App\Models\Rank', 'rank_id');
    }

    public function tagged_proponent(){
        return $this->belongsTo('App\Models\Proponent', 'tagged_proponent_id');
    }

    public function type(){
        return $this->belongsTo('App\Models\ProponentType', 'proponent_type_id');
    }

    public function site(){
        return $this->belongsTo('App\Models\Site', 'site_id');
    }
}
