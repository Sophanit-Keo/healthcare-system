<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'health_staff_id' => $this->health_staff_id,
            'facility_id' => $this->facility_id,
            'department_id' => $this->department_id,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'status' => $this->status,
            'reason' => $this->reason,
            'notes' => $this->notes,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
