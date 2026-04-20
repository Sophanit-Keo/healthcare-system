<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
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
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

