<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'facility_id',
        'department_id',
        'health_staff_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'notes',
        'patient_name',
        'email',
        'phone',
        'doctor',
        'department',
        'date',
        'time',
        'status',
        'message',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'appointment_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function departmentRef(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(HealthStaff::class, 'health_staff_id');
    }

    public function encounter(): HasOne
    {
        return $this->hasOne(Encounter::class);
    }
}
