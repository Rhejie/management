<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityAllocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assetable()
    {
        return $this->morphTo();
    }
}
