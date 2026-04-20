<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabOrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'encounter_id' => $this->encounter_id,
            'patient_id' => $this->patient_id,
            'facility_id' => $this->facility_id,
            'ordered_by_health_staff_id' => $this->ordered_by_health_staff_id,
            'status' => $this->status,
            'ordered_at' => $this->ordered_at,
            'notes' => $this->notes,
            'items' => LabOrderItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

