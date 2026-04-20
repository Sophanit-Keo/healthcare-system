<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVitalSignRequest extends FormRequest
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
            'temperature' => ['nullable', 'numeric', 'min:25', 'max:45'],
            'blood_pressure_systolic' => ['nullable', 'integer', 'min:30', 'max:300'],
            'blood_pressure_diastolic' => ['nullable', 'integer', 'min:20', 'max:200'],
            'heart_rate' => ['nullable', 'integer', 'min:20', 'max:250'],
            'respiratory_rate' => ['nullable', 'integer', 'min:5', 'max:80'],
            'oxygen_saturation' => ['nullable', 'integer', 'min:0', 'max:100'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'recorded_at' => ['nullable', 'date'],
        ];
    }
}
