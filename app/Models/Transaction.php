<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'proponentable_type',
        'proponentable_id',
        'assetable_type',
        'assetable_id',
        'transaction_type_id',
        'attachment_url',
        'details',
        'ticket_number',
        'ticket_status',
        'isAcknowledged',
        'date_acknowledged'
    ];

    const TRANSACTION_TYPES = [
        'assign',
        'transfer',
        'disposal'
    ];

    public function proponentable()
    {
        return $this->morphTo();
    }

    public function assetable()
    {
        return $this->morphTo();
    }
}
