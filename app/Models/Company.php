<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'name',
        'cost_center',
        'company_code'
    ];

    public function sites()
    {
        return $this->hasMany('App\Models\Site', 'company_code', 'company_code');
    }

    public function proponents(){
        return $this->hasManyDeep('App\Models\Proponent', ['App\Models\Site', 'App\Models\CostCenter']);
    }

    public function employees(){
        return $this->proponents()->where('proponent_type_id', 1);
    }

    public function campaigns(){
        return $this->proponents()->where('proponent_type_id', 2);
    }

    public function cost_centers(){
        return $this->hasManyThrough('App\Models\CostCenter', 'App\Models\Site');
    }
}
