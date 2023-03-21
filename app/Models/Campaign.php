<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'site_id',
        'cost_center_id',
        'name',
        'campaign_number'
    ];

    public function site(){
        return $this->belongsTo('App\Models\Site', 'site_id');
    }

    public function cost_center(){
        return $this->belongsTo('App\Models\CostCenter', 'cost_center_id');
    }

    public function employees(){
        return $this->hasMany('App\Models\Employee', 'campaign_id');
    }

    public function company()
    {
        return $this->belongsToThrough('App\Models\Company', ['App\Models\Site']);
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'proponentable');
    }
}
