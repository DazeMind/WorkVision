<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class WorkerUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'first_last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'rut' => 'required|string|unique:workers,rut,' . $this->worker->id,
            'email' => 'required|email|unique:workers,email,' . $this->worker->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'afp' => 'nullable|string|max:255',
            'health_plan' => 'nullable|string|max:255',
            'id_company' => 'nullable|exists:companies,id',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_last_name.required' => 'El primer apellido es obligatorio.',
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'El RUT ya está en uso.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'id_company.exists' => 'La empresa seleccionada no es válida.',
        ];
    }
}
