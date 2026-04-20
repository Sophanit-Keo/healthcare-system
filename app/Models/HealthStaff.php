<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class HealthStaff extends Model
{
    protected $table = 'health_staff';

    protected $fillable = [
        'user_id',
        'staff_code',
        'facility_id',
        'department_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'role',
        'license_number',
        'hire_date',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
