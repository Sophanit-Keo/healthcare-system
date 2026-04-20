<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $primaryKey = 'DoctorID';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialization',
        'status',
        'years_of_experience',
        'consultation_fee',
        'schedule_load',
        'biography_note',
    ];
}
