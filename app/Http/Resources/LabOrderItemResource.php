<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabOrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lab_order_id' => $this->lab_order_id,
            'test_code' => $this->test_code,
            'test_name' => $this->test_name,
            'specimen' => $this->specimen,
            'status' => $this->status,
            'result' => $this->result,
            'unit' => $this->unit,
            'reference_range' => $this->reference_range,
            'collected_at' => $this->collected_at,
            'resulted_at' => $this->resulted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
