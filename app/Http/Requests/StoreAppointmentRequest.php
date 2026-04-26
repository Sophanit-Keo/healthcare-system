<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();
        $isPatient = ($user?->role ?? null) === 'patient'
            || (method_exists($user, 'hasRole') && $user->hasRole('patient'));

        return [
            'patient_id' => [$isPatient ? 'nullable' : 'required', 'integer', 'exists:patients,id'],
            'health_staff_id' => ['nullable', 'integer', 'exists:health_staff,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'status' => ['nullable', 'in:scheduled,completed,cancelled,no_show'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
