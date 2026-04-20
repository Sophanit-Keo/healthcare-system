<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = [
        'facility_code',
        'name',
        'facility_type',
        'phone',
        'email',
        'address',
        'city_province',
        'status',
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function healthStaff(): HasMany
    {
        return $this->hasMany(HealthStaff::class);
    }
}
