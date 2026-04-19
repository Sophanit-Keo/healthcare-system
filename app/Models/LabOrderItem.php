<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabOrderItem extends Model
{
    protected $fillable = [
        'lab_order_id',
        'test_code',
        'test_name',
        'specimen',
        'status',
        'result',
        'unit',
        'reference_range',
        'collected_at',
        'resulted_at',
    ];

    protected $casts = [
        'collected_at' => 'datetime',
        'resulted_at' => 'datetime',
    ];

    public function labOrder(): BelongsTo
    {
        return $this->belongsTo(LabOrder::class);
    }
}

