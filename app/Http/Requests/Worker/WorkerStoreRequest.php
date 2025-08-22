<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class WorkerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'first_last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'rut' => 'required|string|max:20|unique:workers,rut',
            'email' => 'required|string|email|max:255|unique:workers,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'afp' => 'nullable|string|max:255',
            'health_plan' => 'nullable|string|max:255',
            'id_company' => 'required|exists:companies,id', // Asegúrate de que la compañía exista
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_last_name.required' => 'El primer apellido es obligatorio.',
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'El RUT ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'phone.required' => 'El teléfono es obligatorio.',
            'id_company.required' => 'La compañía es obligatoria.',
            'id_company.exists' => 'La compañía seleccionada no existe.',
        ];
    }
}
