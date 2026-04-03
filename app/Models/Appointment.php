<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'health_staff_id',
        'facility_id',
        'department_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
        'notes',
    ];
    public function patient() {
    return $this->belongsTo(Patient::class);
    }

    public function staff() {
    return $this->belongsTo(HealthStaff::class, 'health_staff_id');
    }

    public function facility() {
    return $this->belongsTo(Facility::class);
    }

    public function department() {
    return $this->belongsTo(Department::class);
    }

    public function encounter() {
    return $this->hasOne(Encounter::class);
    }
}
