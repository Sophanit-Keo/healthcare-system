<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientFacilityConsentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'facility_id' => $this->facility_id,
            'status' => $this->status,
            'scopes' => $this->scopes,
            'granted_at' => $this->granted_at,
            'revoked_at' => $this->revoked_at,
            'expires_at' => $this->expires_at,
            'updated_by_user_id' => $this->updated_by_user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

