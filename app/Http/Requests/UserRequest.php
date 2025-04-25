<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $emailRule = 'required|email|unique:users,email';
        $userId = $this->route('id');

        if ($userId) {
            $emailRule .= ',' . $userId;
        }
        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => $userId ? 'nullable|string|min:6' : 'required|string|min:6',
            'role' => 'required|in:user,cinema_admin,super_admin',
        ];
    }
}
