<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabOrder extends Model
{
    protected $fillable = [
        'encounter_id',
        'patient_id',
        'facility_id',
        'ordered_by_health_staff_id',
        'status',
        'ordered_at',
        'notes',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    public function encounter(): BelongsTo
    {
        return $this->belongsTo(Encounter::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function orderedByHealthStaff(): BelongsTo
    {
        return $this->belongsTo(HealthStaff::class, 'ordered_by_health_staff_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(LabOrderItem::class);
    }
}

