<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'health_staff_id',
        'notes',
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
}
