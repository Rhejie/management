<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_code',
        'cost_center',
        'site_code',
        'name',
    ];

    public function company(){
        return $this->belongsTo('App\Models\Company', 'company_code');
    }

    public function campaigns(){
        return $this->hasMany('App\Models\Campaign', 'site_id');
    }

    public function proponents(){
        return $this->hasMany('App\Models\Proponent', 'site_id');
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'proponentable');
    }
}
