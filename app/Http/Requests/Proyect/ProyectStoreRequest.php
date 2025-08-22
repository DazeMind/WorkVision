<?php

namespace App\Http\Requests\Proyect;

use Illuminate\Foundation\Http\FormRequest;

class ProyectStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'budget' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'id_company' => 'required|integer',
            'status' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El Campo Nombre es obligatorio.',
            'description.max' => 'El Campo Descripción Debe tener un maximo de 1000 caracteres.',
            'start_date.required' => 'El Campo Fecha de inicio es obligatorio.',
            'end_date.required' => 'El Campo Fecha Finalización es obligatorio.',
        ];
    }
}
