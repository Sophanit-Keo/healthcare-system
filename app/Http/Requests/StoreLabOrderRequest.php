<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'encounter_id' => ['nullable', 'integer', 'exists:encounters,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'ordered_by_health_staff_id' => ['nullable', 'integer', 'exists:health_staff,id'],
            'status' => ['nullable', 'in:ordered,in_progress,completed,cancelled'],
            'ordered_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],

            'items' => ['nullable', 'array', 'min:1'],
            'items.*.test_code' => ['nullable', 'string', 'max:50'],
            'items.*.test_name' => ['required_with:items', 'string', 'max:150'],
            'items.*.specimen' => ['nullable', 'string', 'max:100'],
        ];
    }
}
