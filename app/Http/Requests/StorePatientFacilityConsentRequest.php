<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePatientFacilityConsentRequest extends FormRequest
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
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'facility_id' => ['required', 'integer', 'exists:facilities,id'],
            'status' => ['nullable', 'in:granted,revoked'],
            'scopes' => ['nullable', 'array'],
            'expires_at' => ['nullable', 'date'],
        ];
    }
}
