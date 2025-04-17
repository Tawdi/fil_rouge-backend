<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'rating' => 'required|numeric|between:0,10',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'director' => 'nullable|string|max:255',
            'actors' => 'nullable|string',
            'poster' => 'nullable|string',
            'background' => 'nullable|string',
            'trailer' => 'nullable|string|max:255',
            'genre_id' => 'required|exists:genres,id',
        ];
    }
}
