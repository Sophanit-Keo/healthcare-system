<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientFacilityConsentRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'in:granted,revoked'],
            'scopes' => ['nullable', 'array'],
            'expires_at' => ['nullable', 'date'],
        ];
    }
}
