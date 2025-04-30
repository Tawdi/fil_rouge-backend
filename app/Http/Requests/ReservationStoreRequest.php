<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'seance_id' => 'required|exists:seances,id',
            'seats' => 'required|array|min:1',
            'seats.*.row' => 'required|integer',
            'seats.*.col' => 'required|integer',
            'seats.*.type' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'seance_id.required' => 'Seance ID is required.',
            'seance_id.exists' => 'The selected seance does not exist.',
            'seats.required' => 'At least one seat must be selected.',
        ];
    }
}
