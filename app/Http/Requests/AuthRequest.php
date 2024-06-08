<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'username' => 'required|min:4',
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'birthday' => 'date|before:today',
            'role' => 'in:supervisor,participant,admin'
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.min' => 'El nombre de usuario debe tener al menos 4 carácteres.',

            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 4 carácteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 carácteres.',

            'birthday.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'birthday.before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'role.in' => 'El rol debe ser supervisor, participant o admin.'
        ];
    }
}
