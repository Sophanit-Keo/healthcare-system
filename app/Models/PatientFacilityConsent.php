<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientFacilityConsent extends Model
{
    protected $fillable = [
        'patient_id',
        'facility_id',
        'status',
        'scopes',
        'granted_at',
        'revoked_at',
        'expires_at',
        'updated_by_user_id',
    ];

    protected $casts = [
        'scopes' => 'array',
        'granted_at' => 'datetime',
        'revoked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
}
