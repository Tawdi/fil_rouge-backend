<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeanceRequest extends FormRequest
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
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'pricing' => 'required|json',
            'start_time' => 'required|date|after:now',
            'end_time'   => 'required|date|after:start_time',
        ];
    }
}
