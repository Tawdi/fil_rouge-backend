<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeanceRequest extends FormRequest
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
            'movie_id'   => 'sometimes|exists:movies,id',
            'room_id'    => 'sometimes|exists:rooms,id',
            'start_time' => 'sometimes|date|after:now',
            'end_time'   => 'sometimes|date|after:start_time',
            'pricing'    => 'sometimes|json',
        ];
    }
}
