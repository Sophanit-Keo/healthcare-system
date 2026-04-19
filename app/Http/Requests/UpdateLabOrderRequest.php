<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLabOrderRequest extends FormRequest
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
            'status' => ['sometimes', 'in:ordered,in_progress,completed,cancelled'],
            'notes' => ['nullable', 'string'],

            // Optional quick update for item results.
            'items' => ['nullable', 'array'],
            'items.*.id' => ['required_with:items', 'integer', 'exists:lab_order_items,id'],
            'items.*.status' => ['nullable', 'in:ordered,collected,resulted,cancelled'],
            'items.*.result' => ['nullable', 'string'],
            'items.*.unit' => ['nullable', 'string', 'max:50'],
            'items.*.reference_range' => ['nullable', 'string', 'max:100'],
            'items.*.collected_at' => ['nullable', 'date'],
            'items.*.resulted_at' => ['nullable', 'date'],
        ];
    }
}
