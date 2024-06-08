<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'username' => 'nullable|min:4',
            'password' => 'nullable|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'username.min' => 'El nombre de usuario debe tener al menos 4 carácteres.',

            'password.min' => 'La contraseña debe tener al menos 6 carácteres.',
        ];
    }
}
