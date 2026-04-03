<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $fillable = [
        'encounter_id',
        'type',
        'value',
        'unit',
        'recorded_at',
    ];
    public function encounter() {
    return $this->belongsTo(Encounter::class);
    }
}
