<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientFacilityConsent;
use Carbon\CarbonImmutable;

class ConsentService
{
    public function hasActiveFacilityConsent(Patient $patient, int $facilityId): bool
    {
        $now = CarbonImmutable::now();

        return PatientFacilityConsent::query()
            ->where('patient_id', $patient->id)
            ->where('facility_id', $facilityId)
            ->where('status', 'granted')
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', $now);
            })
            ->exists();
    }
}

