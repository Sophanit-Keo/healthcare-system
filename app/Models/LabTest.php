<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    protected $fillable = [
        'user_id', 'test_name', 'department', 'test_date',
        'status', 'result', 'notes', 'doctor_name',
    ];

    protected $casts = [
        'test_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

