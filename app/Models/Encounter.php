<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'health_staff_id',
        'facility_id',
        'department_id',
        'notes',
        'encounter_type',
        'started_at',
        'ended_at',
        'chief_complaint',
        'diagnosis',
        'treatment_plan',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];
    
    public function appointment() {
    return $this->belongsTo(Appointment::class);
    }

    public function patient() {
    return $this->belongsTo(Patient::class);
    }

    public function staff() {
    return $this->belongsTo(HealthStaff::class, 'health_staff_id');
    }

    public function vitalSigns() {
    return $this->hasMany(VitalSign::class);
    }

    public function labOrders()
    {
        return $this->hasMany(LabOrder::class);
    }
}
