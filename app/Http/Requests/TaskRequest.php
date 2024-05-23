<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string|max:1000',
                'date_start' => 'sometimes|required|date',
                'date_end' => 'sometimes|required|date|after_or_equal:date_start',
            ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no debe exceder los 1000 caracteres.',

            'date_start.required' => 'La fecha de inicio es obligatoria.',
            'date_start.date' => 'La fecha de inicio debe ser una fecha válida.',

            'date_end.required' => 'La fecha de fin es obligatoria.',
            'date_end.date' => 'La fecha de fin debe ser una fecha válida.',
            'date_end.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    }
}
