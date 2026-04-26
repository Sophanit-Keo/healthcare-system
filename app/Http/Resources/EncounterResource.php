<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EncounterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment_id' => $this->appointment_id,
            'patient_id' => $this->patient_id,
            'health_staff_id' => $this->health_staff_id,
            'facility_id' => $this->facility_id,
            'department_id' => $this->department_id,
            'encounter_type' => $this->encounter_type,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'chief_complaint' => $this->chief_complaint,
            'diagnosis' => $this->diagnosis,
            'treatment_plan' => $this->treatment_plan,
            'notes' => $this->notes,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'vital_signs' => VitalSignResource::collection($this->whenLoaded('vitalSigns')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
