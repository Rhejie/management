<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'name',
        'employee_number',
        'email',
        'campaign_id',
    ];

    public function site()
    {
        return $this->belongsToThrough('App\Models\Site', ['App\Models\Campaign']);
    }

    public function company()
    {
        return $this->belongsToThrough('App\Models\Company', ['App\Models\Site', 'App\Models\Campaign']);
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    public function cost_center()
    {
        return $this->belongsToThrough('App\Models\CostCenter', ['App\Models\Campaign']);
    }

    public function account(){
        return $this->hasOne('App\Models\User', 'employee_id');
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'proponentable');
    }
}
