<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEncounterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_id' => ['nullable', 'integer', 'exists:appointments,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'health_staff_id' => ['nullable', 'integer', 'exists:health_staff,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'encounter_type' => ['nullable', 'in:outpatient,inpatient,emergency,follow_up'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'chief_complaint' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'treatment_plan' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
